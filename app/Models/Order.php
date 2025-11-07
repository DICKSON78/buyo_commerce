<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_number', 'buyer_id', 'seller_id', 'product_id', 'quantity', 'unit_price', 'total_price', 'status', 'buyer_note', 'seller_note', 'cancelled_by', 'cancellation_reason'];
    protected $casts = [
        'unit_price' => 'decimal:10,2',
        'total_price' => 'decimal:10,2',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderHistories()
    {
        return $this->hasMany(OrderHistory::class, 'order_id', 'id');
    }
}
