<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'comment',
        'is_approved',
        'reviewer_name',
        'reviewer_email',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that made the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that was reviewed.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the order associated with the review.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the seller through the product.
     */
    public function seller()
    {
        return $this->hasOneThrough(
            Seller::class,
            Product::class,
            'id', // Foreign key on products table
            'user_id', // Foreign key on sellers table
            'product_id', // Local key on reviews table
            'seller_id' // Local key on products table
        );
    }

    /**
     * Scope a query to only include approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope a query to only include reviews for a specific product.
     */
    public function scopeForProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope a query to only include reviews for a specific seller.
     */
    public function scopeForSeller($query, $sellerId)
    {
        return $query->whereHas('product', function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        });
    }

    /**
     * Get the rating as stars HTML.
     */
    public function getStarsAttribute(): string
    {
        $stars = '';
        $fullStars = floor($this->rating);
        $halfStar = $this->rating - $fullStars >= 0.5;
        
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $fullStars) {
                $stars .= '<i class="fas fa-star text-yellow-400"></i>';
            } elseif ($halfStar && $i == $fullStars + 1) {
                $stars .= '<i class="fas fa-star-half-alt text-yellow-400"></i>';
            } else {
                $stars .= '<i class="far fa-star text-yellow-400"></i>';
            }
        }
        
        return $stars;
    }

    /**
     * Get the reviewer name.
     */
    public function getReviewerNameAttribute(): string
    {
        return $this->reviewer_name ?? $this->user->username ?? 'Anonymous';
    }

    /**
     * Check if the review can be edited.
     */
    public function canBeEdited(): bool
    {
        return $this->created_at->gt(now()->subHours(24));
    }

    /**
     * Approve the review.
     */
    public function approve(): bool
    {
        return $this->update(['is_approved' => true]);
    }

    /**
     * Disapprove the review.
     */
    public function disapprove(): bool
    {
        return $this->update(['is_approved' => false]);
    }
}