<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'phone',
        'phone_country_code',
        'phone_number',
        'password',
        'user_type',
        'full_name',
        'date_of_birth',
        'gender',
        'location',
        'region',
        'region_id',
        'terms_accepted'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'terms_accepted' => 'boolean',
    ];

    // Relationships
    public function seller() {
        return $this->hasOne(Seller::class, 'user_id');
    }

    public function customer() {
        return $this->hasOne(Customer::class, 'id');
    }

    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function carts() {
        return $this->hasMany(Cart::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function conversations() {
        return $this->hasMany(Conversation::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    // Review Relationships
    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews() {
        return $this->reviews()->where('is_approved', true);
    }

    // Helper Methods
    public function isSeller() {
        return $this->user_type === 'seller';
    }

    public function isCustomer() {
        return $this->user_type === 'customer';
    }

    public function hasSellerProfile() {
        return $this->seller()->exists();
    }

    public function hasCustomerProfile() {
        return $this->customer()->exists();
    }

    /**
     * Get the full phone number with country code
     */
    public function getFullPhoneAttribute() {
        if ($this->phone_country_code && $this->phone_number) {
            return $this->phone_country_code . $this->phone_number;
        }
        return $this->phone;
    }

    /**
     * Get formatted phone number
     */
    public function getFormattedPhoneAttribute() {
        if ($this->phone_country_code && $this->phone_number) {
            return $this->phone_country_code . ' ' . $this->phone_number;
        }
        return $this->phone;
    }

    /**
     * Get user's display name
     */
    public function getDisplayNameAttribute() {
        return $this->full_name ?: $this->username;
    }

    /**
     * Get user's initials for avatar
     */
    public function getInitialsAttribute() {
        if ($this->full_name) {
            $names = explode(' ', $this->full_name);
            $initials = '';
            foreach ($names as $name) {
                $initials .= strtoupper(substr($name, 0, 1));
            }
            return substr($initials, 0, 2);
        }
        return strtoupper(substr($this->username, 0, 2));
    }

    /**
     * Scope a query to only include sellers
     */
    public function scopeSellers($query) {
        return $query->where('user_type', 'seller');
    }

    /**
     * Scope a query to only include customers
     */
    public function scopeCustomers($query) {
        return $query->where('user_type', 'customer');
    }

    /**
     * Scope a query to only include users with phone numbers
     */
    public function scopeWithPhone($query) {
        return $query->whereNotNull('phone_number')->orWhereNotNull('phone');
    }

    /**
     * Scope a query to only include users from a specific region
     */
    public function scopeInRegion($query, $regionId) {
        return $query->where('region_id', $regionId);
    }

    /**
     * Check if user can switch to seller
     */
    public function canBecomeSeller() {
        return $this->isCustomer() && !$this->hasSellerProfile();
    }

    /**
     * Check if user can switch to customer
     */
    public function canBecomeCustomer() {
        return $this->isSeller() && !$this->hasCustomerProfile();
    }

    /**
     * Get user's active profile (seller or customer)
     */
    public function getActiveProfileAttribute() {
        if ($this->isSeller() && $this->seller) {
            return $this->seller;
        }
        if ($this->isCustomer() && $this->customer) {
            return $this->customer;
        }
        return null;
    }

    /**
     * Update user's phone number with country code
     */
    public function updatePhone($countryCode, $phoneNumber) {
        $this->update([
            'phone_country_code' => $countryCode,
            'phone_number' => $phoneNumber,
            'phone' => $countryCode . $phoneNumber,
        ]);
    }

    /**
     * Get user's region name
     */
    public function getRegionNameAttribute() {
        return $this->region ? $this->region->name : $this->region;
    }

    /**
     * Check if user has completed profile
     */
    public function getHasCompleteProfileAttribute() {
        return $this->full_name && $this->email && $this->phone_number;
    }

    /**
     * Get profile completion percentage
     */
    public function getProfileCompletionAttribute() {
        $completed = 0;
        $totalFields = 5;

        if ($this->username) $completed++;
        if ($this->email) $completed++;
        if ($this->phone_number) $completed++;
        if ($this->full_name) $completed++;
        if ($this->region_id) $completed++;

        return round(($completed / $totalFields) * 100);
    }

    // Review-related Methods
    /**
     * Get user's average rating as a seller
     */
    public function getSellerRatingAttribute() {
        if (!$this->isSeller() || !$this->seller) {
            return 0;
        }

        return $this->seller->getAverageRating();
    }

    /**
     * Get user's total reviews as a seller
     */
    public function getSellerReviewsCountAttribute() {
        if (!$this->isSeller() || !$this->seller) {
            return 0;
        }

        return $this->seller->getTotalReviewsCount();
    }

    /**
     * Get user's recent reviews
     */
    public function getRecentReviews($limit = 5) {
        return $this->reviews()
            ->with('product')
            ->where('is_approved', true)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Check if user can review a product
     */
    public function canReviewProduct($productId) {
        // User can review if they have purchased the product
        return $this->orders()
            ->whereHas('items', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->where('status', 'delivered')
            ->exists();
    }

    /**
     * Check if user has already reviewed a product
     */
    public function hasReviewedProduct($productId) {
        return $this->reviews()
            ->where('product_id', $productId)
            ->exists();
    }

    /**
     * Get user's review for a specific product
     */
    public function getProductReview($productId) {
        return $this->reviews()
            ->where('product_id', $productId)
            ->first();
    }

    /**
     * Get user's review statistics
     */
    public function getReviewStatsAttribute() {
        $totalReviews = $this->reviews()->count();
        $approvedReviews = $this->approvedReviews()->count();
        $averageRating = $this->reviews()->avg('rating') ?? 0;

        return [
            'total_reviews' => $totalReviews,
            'approved_reviews' => $approvedReviews,
            'average_rating' => round($averageRating, 1),
            'pending_reviews' => $totalReviews - $approvedReviews,
        ];
    }

    /**
     * Get user's rating distribution
     */
    public function getRatingDistributionAttribute() {
        $distribution = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0
        ];

        $reviews = $this->reviews()
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->get();

        foreach ($reviews as $review) {
            $distribution[$review->rating] = $review->count;
        }

        return $distribution;
    }

    /**
     * Check if user can edit a review
     */
    public function canEditReview($reviewId) {
        $review = $this->reviews()->find($reviewId);
        return $review && $review->canBeEdited();
    }

    /**
     * Get user's most helpful reviews
     */
    public function getMostHelpfulReviews($limit = 3) {
        // This would require a 'helpful_count' field in reviews table
        return $this->approvedReviews()
            ->with('product')
            ->orderBy('helpful_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Check if user has any reviews
     */
    public function getHasReviewsAttribute() {
        return $this->reviews()->exists();
    }

    /**
     * Get user's review contribution score
     */
    public function getReviewContributionScoreAttribute() {
        $totalReviews = $this->reviews()->count();
        $helpfulReviews = $this->reviews()->where('helpful_count', '>', 0)->count();
        $detailedReviews = $this->reviews()->where('comment', '!=', '')->count();

        $score = ($totalReviews * 10) + ($helpfulReviews * 5) + ($detailedReviews * 3);
        return min($score, 100); // Cap at 100
    }

    /**
     * Scope a query to only include users with reviews
     */
    public function scopeWithReviews($query) {
        return $query->whereHas('reviews');
    }

    /**
     * Scope a query to only include users with approved reviews
     */
    public function scopeWithApprovedReviews($query) {
        return $query->whereHas('reviews', function($q) {
            $q->where('is_approved', true);
        });
    }

    /**
     * Get user's review activity timeline
     */
    public function getReviewActivityTimeline($months = 6) {
        return $this->reviews()
            ->where('created_at', '>=', now()->subMonths($months))
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    }
}