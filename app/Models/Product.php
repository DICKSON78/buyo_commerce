<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id', 'category_id', 'name', 'name_sw', 'slug', 'description', 'description_sw', 'price', 'compare_price', 'quantity', 'sku', 'condition', 'status', 'is_featured', 'is_approved', 'approved_by', 'approved_at', 'view_count', 'location', 'latitude', 'longitude'];
    protected $casts = [
        'price' => 'decimal:10,2',
        'compare_price' => 'decimal:10,2',
        'quantity' => 'integer',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
        'latitude' => 'decimal:10,8',
        'longitude' => 'decimal:11,8',
    ];

    public function seller()
    {
        return $this->belongsTo(SellerProfile::class, 'seller_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'product_id', 'id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'product_id', 'id');
    }

    public function productViews()
    {
        return $this->hasMany(ProductView::class, 'product_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id', 'id');
    }
}
