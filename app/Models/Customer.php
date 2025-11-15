<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'id',
        'full_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'location',
        'region',
        'address',
        'city',
        'country',
        'total_orders',
        'total_spent',
        'pending_orders',
        'completed_orders',
        'cancelled_orders',
        'support_tickets',
        'preferred_payment_method',
        'preferred_shipping_method',
        'newsletter_subscribed',
        'marketing_emails',
        'sms_notifications',
        'profile_completion',
        'last_login_at',
        'email_verified_at',
        'verification_token',
        'profile_picture',
        'bio',
        'preferences'
    ];

    public $incrementing = false;
    protected $keyType = 'bigint';

    protected $casts = [
        'date_of_birth' => 'date',
        'newsletter_subscribed' => 'boolean',
        'marketing_emails' => 'boolean',
        'sms_notifications' => 'boolean',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'preferences' => 'array',
        'total_spent' => 'decimal:2'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    // Relationship with Orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    // Relationship with Cart
    public function cart()
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }

    // Relationship with Favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }

    // Relationship with Conversations (as customer)
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user_id', 'id');
    }

    // Accessor for profile completion
    public function getProfileCompletionAttribute($value)
    {
        return $value ?? $this->calculateProfileCompletion();
    }

    // Calculate profile completion percentage
    public function calculateProfileCompletion()
    {
        $fields = [
            'full_name' => 20,
            'email' => 15,
            'phone' => 15,
            'date_of_birth' => 10,
            'gender' => 10,
            'location' => 10,
            'address' => 10,
            'profile_picture' => 10
        ];

        $completion = 0;
        foreach ($fields as $field => $weight) {
            if (!empty($this->$field)) {
                $completion += $weight;
            }
        }

        return min($completion, 100);
    }

    // Check if customer has complete profile
    public function hasCompleteProfile()
    {
        return $this->profile_completion >= 80;
    }

    // Get customer's active orders count
    public function getActiveOrdersCount()
    {
        return $this->orders()->whereIn('status', ['pending', 'confirmed', 'shipped'])->count();
    }

    // Get customer's favorite categories
    public function getFavoriteCategories()
    {
        return $this->orders()
            ->with('items.product.category')
            ->get()
            ->pluck('items.*.product.category')
            ->flatten()
            ->unique('id')
            ->values();
    }

    // Update customer stats
    public function updateStats()
    {
        $this->total_orders = $this->orders()->count();
        $this->total_spent = $this->orders()->where('status', 'delivered')->sum('total_amount');
        $this->pending_orders = $this->orders()->where('status', 'pending')->count();
        $this->completed_orders = $this->orders()->where('status', 'delivered')->count();
        $this->cancelled_orders = $this->orders()->where('status', 'cancelled')->count();

        $this->save();
    }

    // Check if email is verified
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    // Mark email as verified
    public function markEmailAsVerified()
    {
        $this->email_verified_at = $this->freshTimestamp();
        $this->verification_token = null;
        $this->save();
    }

    // Get recent orders
    public function recentOrders($limit = 5)
    {
        return $this->orders()
            ->with(['items.product'])
            ->latest()
            ->limit($limit)
            ->get();
    }

    // Get order statistics for dashboard
    public function getOrderStats()
    {
        return [
            'total_orders' => $this->total_orders,
            'pending_orders' => $this->pending_orders,
            'completed_orders' => $this->completed_orders,
            'cancelled_orders' => $this->cancelled_orders,
            'total_spent' => $this->total_spent,
            'active_orders' => $this->getActiveOrdersCount(),
        ];
    }

    // Get support tickets count
    public function getSupportTicketsCount()
    {
        return $this->support_tickets; // This would come from support_tickets table in real app
    }

    // Get unread messages count
    public function getUnreadMessagesCount()
    {
        return Message::whereHas('conversation', function($query) {
            $query->where('user_id', $this->id);
        })
        ->where('user_id', '!=', $this->id)
        ->whereNull('read_at')
        ->count();
    }

    // Get cart items count
    public function getCartItemsCount()
    {
        return $this->cart()->count();
    }

    // Get favorite products count
    public function getFavoritesCount()
    {
        return $this->favorites()->count();
    }
}