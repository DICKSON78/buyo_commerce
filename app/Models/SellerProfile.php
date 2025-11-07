<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerProfile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'store_name', 'store_slug', 'store_logo', 'bio', 'contact_phone', 'contact_email', 'location', 'address', 'verified_status', 'rating', 'total_sales'];
    protected $casts = [
        'rating' => 'decimal:3,2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id', 'id');
    }
}
