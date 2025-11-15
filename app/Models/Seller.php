<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_name',
        'store_slug',
        'store_description',
        'business_place',
        'business_region',
        'logo',
        'banner',
        'rating',
        'total_sales',
        'total_earnings',
        'is_verified',
        'is_active',
        'verification_status',
        'tax_id',
        'business_license',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'momo_number',
        'momo_name',
        'customer_service_phone',
        'customer_service_email',
        'return_policy',
        'shipping_policy',
        'support_phone',
        'support_email',
        'social_facebook',
        'social_instagram',
        'social_twitter',
        'opening_hours',
        'vacation_mode',
        'vacation_message',
        'last_login_at',
        'profile_completed_at'
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'total_earnings' => 'decimal:2',
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'vacation_mode' => 'boolean',
        'last_login_at' => 'datetime',
        'profile_completed_at' => 'datetime',
        'opening_hours' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id', 'user_id');
    }

    public function orders()
    {
        return Order::whereHas('items.product', function($query) {
            $query->where('seller_id', $this->user_id);
        });
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'seller_user_id', 'user_id');
    }

    // Review Relationships
    public function reviews()
    {
        return $this->hasManyThrough(
            Review::class,
            Product::class,
            'seller_id', // Foreign key on products table
            'product_id', // Foreign key on reviews table
            'user_id', // Local key on sellers table
            'id' // Local key on products table
        );
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('is_approved', true);
    }

    public function pendingReviews()
    {
        return $this->reviews()->where('is_approved', false);
    }

    // Accessors
    public function getStoreUrlAttribute()
    {
        return route('seller.public.store', $this->store_slug);
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('images/default-store-logo.png');
    }

    public function getBannerUrlAttribute()
    {
        return $this->banner ? asset('storage/' . $this->banner) : asset('images/default-store-banner.jpg');
    }

    public function getTotalProductsAttribute()
    {
        return $this->products()->count();
    }

    public function getActiveProductsAttribute()
    {
        return $this->products()->where('is_active', true)->count();
    }

    public function getOutOfStockProductsAttribute()
    {
        return $this->products()->where('stock_quantity', 0)->count();
    }

    public function getTotalOrdersAttribute()
    {
        return $this->orders()->count();
    }

    public function getPendingOrdersAttribute()
    {
        return $this->orders()->where('status', 'pending')->count();
    }

    public function getCompletedOrdersAttribute()
    {
        return $this->orders()->where('status', 'delivered')->count();
    }

    public function getTotalEarningsFormattedAttribute()
    {
        return 'TZS ' . number_format($this->total_earnings, 2);
    }

    public function getRatingFormattedAttribute()
    {
        return number_format($this->rating, 1);
    }

    public function getJoinedDateAttribute()
    {
        return $this->created_at->format('M d, Y');
    }

    public function getBusinessLocationAttribute()
    {
        return $this->business_place . ', ' . $this->business_region;
    }

    // Review-related Accessors
    public function getAverageRating()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating') ?? 0;
    }

    public function getTotalReviewsCount()
    {
        return $this->reviews()->where('is_approved', true)->count();
    }

    public function getRatingBreakdown()
    {
        $breakdown = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0
        ];

        $reviews = $this->reviews()
            ->where('is_approved', true)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->get();

        foreach ($reviews as $review) {
            $breakdown[$review->rating] = $review->count;
        }

        return $breakdown;
    }

    public function getRatingPercentage($rating)
    {
        $total = $this->getTotalReviewsCount();
        if ($total === 0) return 0;
        
        $breakdown = $this->getRatingBreakdown();
        return round(($breakdown[$rating] / $total) * 100);
    }

    public function getRecentReviews($limit = 5)
    {
        return $this->reviews()
            ->with(['user', 'product'])
            ->where('is_approved', true)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getTopRatedProducts($limit = 5)
    {
        return $this->products()
            ->whereHas('reviews', function($query) {
                $query->where('is_approved', true);
            })
            ->withAvg(['reviews as avg_rating' => function($query) {
                $query->where('is_approved', true);
            }], 'rating')
            ->withCount(['reviews as reviews_count' => function($query) {
                $query->where('is_approved', true);
            }])
            ->orderBy('avg_rating', 'desc')
            ->orderBy('reviews_count', 'desc')
            ->limit($limit)
            ->get();
    }

    // Methods
    public function updateStats()
    {
        // Update rating
        $this->rating = $this->getAverageRating();

        // Update total sales and earnings
        $orderStats = $this->orders()
            ->where('status', 'delivered')
            ->select(
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('SUM(total_amount) as total_earnings')
            )
            ->first();

        $this->total_sales = $orderStats->total_sales ?? 0;
        $this->total_earnings = $orderStats->total_earnings ?? 0;

        $this->save();
    }

    public function isOnVacation()
    {
        return $this->vacation_mode;
    }

    public function enableVacationMode($message = null)
    {
        $this->update([
            'vacation_mode' => true,
            'vacation_message' => $message,
        ]);
    }

    public function disableVacationMode()
    {
        $this->update([
            'vacation_mode' => false,
            'vacation_message' => null,
        ]);
    }

    public function completeProfile()
    {
        $this->update([
            'profile_completed_at' => now(),
        ]);
    }

    public function isProfileComplete()
    {
        return !is_null($this->profile_completed_at) &&
               $this->store_name &&
               $this->business_place &&
               $this->business_region;
    }

    public function getProfileCompletionPercentage()
    {
        $completed = 0;
        $totalFields = 10;

        $fields = [
            'store_name',
            'store_description',
            'business_place',
            'business_region',
            'logo',
            'bank_account_number',
            'momo_number',
            'customer_service_phone',
            'return_policy',
            'shipping_policy'
        ];

        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }

        return round(($completed / $totalFields) * 100);
    }

    // Review-related Methods
    public function getReviewStats()
    {
        $totalReviews = $this->reviews()->count();
        $approvedReviews = $this->approvedReviews()->count();
        $averageRating = $this->getAverageRating();
        $pendingReviews = $totalReviews - $approvedReviews;

        return [
            'total_reviews' => $totalReviews,
            'approved_reviews' => $approvedReviews,
            'pending_reviews' => $pendingReviews,
            'average_rating' => round($averageRating, 1),
            'rating_breakdown' => $this->getRatingBreakdown(),
        ];
    }

    public function getMonthlyReviewStats($months = 6)
    {
        return $this->reviews()
            ->where('created_at', '>=', now()->subMonths($months))
            ->where('is_approved', true)
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count, AVG(rating) as avg_rating')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get()
            ->map(function($stat) {
                return [
                    'month' => $stat->month,
                    'year' => $stat->year,
                    'count' => $stat->count,
                    'average_rating' => round($stat->avg_rating, 1),
                    'period' => date('M Y', mktime(0, 0, 0, $stat->month, 1, $stat->year))
                ];
            });
    }

    public function getTopReviewers($limit = 5)
    {
        return $this->reviews()
            ->where('is_approved', true)
            ->with('user')
            ->selectRaw('user_id, COUNT(*) as review_count, AVG(rating) as avg_rating')
            ->groupBy('user_id')
            ->orderBy('review_count', 'desc')
            ->orderBy('avg_rating', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($reviewer) {
                return [
                    'user' => $reviewer->user,
                    'review_count' => $reviewer->review_count,
                    'average_rating' => round($reviewer->avg_rating, 1),
                ];
            });
    }

    public function hasRecentNegativeReviews($days = 30, $threshold = 3.0)
    {
        return $this->reviews()
            ->where('created_at', '>=', now()->subDays($days))
            ->where('is_approved', true)
            ->where('rating', '<', $threshold)
            ->exists();
    }

    public function getResponseRate()
    {
        $totalReviews = $this->reviews()->where('is_approved', true)->count();
        $repliedReviews = $this->reviews()->where('is_approved', true)->whereNotNull('seller_response')->count();

        if ($totalReviews === 0) return 100; // If no reviews, consider response rate as 100%

        return round(($repliedReviews / $totalReviews) * 100);
    }

    public function getCustomerSatisfactionScore()
    {
        $stats = $this->getReviewStats();
        $totalReviews = $stats['approved_reviews'];
        
        if ($totalReviews === 0) return 0;

        $weightedScore = (
            $stats['rating_breakdown'][5] * 100 +
            $stats['rating_breakdown'][4] * 80 +
            $stats['rating_breakdown'][3] * 60 +
            $stats['rating_breakdown'][2] * 40 +
            $stats['rating_breakdown'][1] * 20
        ) / $totalReviews;

        return round($weightedScore);
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithReviews($query)
    {
        return $query->whereHas('reviews');
    }

    public function scopeHighlyRated($query, $minRating = 4.0)
    {
        return $query->where('rating', '>=', $minRating);
    }

    public function scopeWithMinReviews($query, $minReviews = 10)
    {
        return $query->whereHas('reviews', function($q) use ($minReviews) {
            $q->where('is_approved', true)
              ->groupBy('product_id')
              ->havingRaw('COUNT(*) >= ?', [$minReviews]);
        });
    }

    public function scopeInRegion($query, $region)
    {
        return $query->where('business_region', $region);
    }

    // Business Logic
    public function canAddProduct()
    {
        return $this->is_active && !$this->vacation_mode;
    }

    public function getPerformanceMetrics()
    {
        return [
            'customer_satisfaction' => $this->getCustomerSatisfactionScore(),
            'response_rate' => $this->getResponseRate(),
            'order_fulfillment_rate' => $this->calculateOrderFulfillmentRate(),
            'on_time_delivery_rate' => $this->calculateOnTimeDeliveryRate(),
        ];
    }

    private function calculateOrderFulfillmentRate()
    {
        $totalOrders = $this->orders()->count();
        $fulfilledOrders = $this->orders()->where('status', 'delivered')->count();

        if ($totalOrders === 0) return 100;

        return round(($fulfilledOrders / $totalOrders) * 100);
    }

    private function calculateOnTimeDeliveryRate()
    {
        // This would require delivery date tracking in orders
        // For now, we'll use a simplified calculation
        $deliveredOrders = $this->orders()->where('status', 'delivered')->count();
        $onTimeOrders = $this->orders()
            ->where('status', 'delivered')
            ->where('updated_at', '<=', DB::raw('DATE_ADD(created_at, INTERVAL 7 DAY)'))
            ->count();

        if ($deliveredOrders === 0) return 100;

        return round(($onTimeOrders / $deliveredOrders) * 100);
    }
}