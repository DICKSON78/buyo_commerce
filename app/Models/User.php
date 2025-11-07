<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'password', 'role', 'avatar', 'email_verified_at', 'phone_verified_at', 'is_active', 'language'];
    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    public function sellerProfile()
    {
        return $this->hasOne(SellerProfile::class);
    }

    public function otpVerifications()
    {
        return $this->hasMany(OtpVerification::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, SellerProfile::class, 'user_id', 'seller_id', 'id', 'id');
    }

    public function conversationsAsBuyer()
    {
        return $this->hasMany(Conversation::class, 'buyer_id', 'id');
    }

    public function conversationsAsSeller()
    {
        return $this->hasMany(Conversation::class, 'seller_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id', 'id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }

    public function productViews()
    {
        return $this->hasMany(ProductView::class, 'user_id', 'id');
    }

    public function ordersAsBuyer()
    {
        return $this->hasMany(Order::class, 'buyer_id', 'id');
    }

    public function ordersAsSeller()
    {
        return $this->hasMany(Order::class, 'seller_id', 'id');
    }

    public function orderHistories()
    {
        return $this->hasMany(OrderHistory::class, 'created_by', 'id');
    }

    public function reportsAsReporter()
    {
        return $this->hasMany(Report::class, 'reporter_id', 'id');
    }

    public function reportsAsReportedUser()
    {
        return $this->hasMany(Report::class, 'reported_user_id', 'id');
    }

    public function reportsAsResolver()
    {
        return $this->hasMany(Report::class, 'resolved_by', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }
}
