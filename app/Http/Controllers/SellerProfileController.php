<?php

namespace App\Http\Controllers;

use App\Models\SellerProfile;
use Illuminate\Http\Request;

class SellerProfileController extends Controller
{
    public function index()
    {
        return view ('seller.dashboard');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'store_name' => 'required|string|max:255',
            'store_slug' => 'required|string|max:255|unique:seller_profiles,store_slug',
        ]);

        return SellerProfile::create($validated);
    }

    public function show(SellerProfile $sellerProfile)
    {
        return $sellerProfile;
    }

    public function update(Request $request, SellerProfile $sellerProfile)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'store_name' => 'sometimes|string|max:255',
            'store_slug' => 'sometimes|string|max:255|unique:seller_profiles,store_slug,' . $sellerProfile->id,
        ]);

        $sellerProfile->update($validated);

        return $sellerProfile;
    }

    public function destroy(SellerProfile $sellerProfile)
    {
        $sellerProfile->delete();

        return response()->noContent();
    }
}
