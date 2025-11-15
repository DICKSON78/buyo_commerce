<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id', 'category_id', 'name', 'name_sw', 'slug', 'description', 'description_sw',
        'price', 'compare_price', 'quantity', 'sku', 'condition', 'status', 'is_featured',
        'is_approved', 'approved_by', 'approved_at', 'view_count', 'location', 'latitude', 'longitude'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    // Relationship with seller
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    // Relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship with product images - FIXED NAME
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Relationship with favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Relationship with cart items
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    // Relationship with order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Get primary image
    public function getPrimaryImageAttribute()
    {
        $primaryImage = $this->productImages()->where('is_primary', true)->first();
        return $primaryImage ? $primaryImage->image_path : null;
    }

    // Get all images
    public function getAllImagesAttribute()
    {
        return $this->productImages()->orderBy('is_primary', 'desc')->get();
    }

    // Check if product is in stock
    public function getInStockAttribute()
    {
        return $this->quantity > 0;
    }

    // Calculate discount percentage
    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }
}