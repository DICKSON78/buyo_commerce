<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Pata seller info kutoka kwenye sellers table
        $seller = Seller::where('user_id', $user->id)->first();

        // Kama seller haipo, create default
        if (!$seller) {
            $seller = Seller::create([
                'user_id' => $user->id,
                'store_name' => $user->username . "'s Store",
                'store_description' => 'Welcome to my store! Add a description to tell customers about your business.',
                'business_place' => 'Dar es Salaam',
                'business_region' => 'Dar es Salaam',
                'is_verified' => false,
                'is_active' => true,
                'rating' => 0.00,
                'total_sales' => 0,
            ]);
        }

        // Pata bidhaa zote za seller kwa grid ya Instagram style
        $sellerProducts = Product::where('seller_id', $seller->id)
            ->with(['images' => function($query) {
                $query->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        // Takwimu za bidhaa - zote zinatumika kwenye frontend
        $productStats = [
            'total' => Product::where('seller_id', $seller->id)->count(),
            'active' => Product::where('seller_id', $seller->id)->where('status', 'active')->count(),
            'sold' => Product::where('seller_id', $seller->id)->where('status', 'sold')->count(),
            'out_of_stock' => Product::where('seller_id', $seller->id)->where('quantity', 0)->count(),
            'low_stock' => Product::where('seller_id', $seller->id)->where('quantity', '<=', 5)->where('quantity', '>', 0)->count(),
            'draft' => Product::where('seller_id', $seller->id)->where('status', 'draft')->count(),
        ];

        // Pata takwimu za mauzo (revenue) - zinahitajika kwenye frontend
        $revenueStats = [
            'total' => Product::where('seller_id', $seller->id)->where('status', 'sold')->sum('price'),
            'monthly' => Product::where('seller_id', $seller->id)
                ->where('status', 'sold')
                ->whereMonth('created_at', now()->month)
                ->sum('price'),
        ];

        // Pata takwimu za orders - kwa ajili ya analytics
        $orderStats = [
            'total' => $seller->total_sales, // Kutumia field ya total_sales kwenye sellers table
            'pending' => 0, // Unaweza kuongeza logic ya orders hapa
            'processing' => 0,
            'shipped' => 0,
            'delivered' => 0,
        ];

        // Pata reviews count - kwa ajili ya reviews tab
        $reviewsCount = Product::where('seller_id', $seller->id)
            ->whereHas('reviews')
            ->withCount('reviews')
            ->get()
            ->sum('reviews_count');

        // Pata recent reviews - kwa ajili ya reviews tab
        $recentReviews = collect([]); // Unaweza kuimplement reviews logic hapa

        // Pata analytics stats - kwa ajili ya analytics tab
        $analyticsStats = [
            'conversion_rate' => $productStats['total'] > 0 ?
                round(($productStats['sold'] / $productStats['total']) * 100, 1) : 0,
        ];

        // Pata profile completion percentage
        $profileCompletion = $this->calculateProfileCompletion($seller);

        return view('seller.profile', compact(
            'seller',
            'sellerProducts',
            'productStats',
            'revenueStats',
            'orderStats',
            'reviewsCount',
            'recentReviews',
            'analyticsStats',
            'profileCompletion'
        ));
    }

    /**
     * Calculate profile completion percentage
     */
    private function calculateProfileCompletion($seller)
    {
        $completion = 0;
        $totalFields = 6; // Total fields to check

        if (!empty($seller->store_name)) $completion++;
        if (!empty($seller->store_description)) $completion++;
        if (!empty($seller->business_place)) $completion++;
        if (!empty($seller->business_region)) $completion++;
        if (!empty($seller->logo)) $completion++;
        if ($seller->is_verified) $completion++;

        return round(($completion / $totalFields) * 100);
    }
}
