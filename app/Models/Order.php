<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'subtotal', 'shipping_cost', 'tax_amount',
        'total_amount', 'status', 'payment_status', 'payment_method',
        'shipping_address', 'billing_address', 'customer_notes', 'paid_at', 'delivered_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Relationships
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopePending($query) {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query) {
        return $query->where('payment_status', 'paid');
    }

    // Methods
    public function markAsPaid() {
        $this->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function updateStatus($status) {
        $this->update(['status' => $status]);

        if ($status === 'delivered') {
            $this->update(['delivered_at' => now()]);
        }
    }
}
