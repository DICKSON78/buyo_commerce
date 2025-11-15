<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerStat extends Model
{
    protected $fillable = [
        'seller_id', 'stat_date', 'orders_count', 'revenue',
        'products_added', 'page_views'
    ];

    protected $casts = [
        'stat_date' => 'date',
        'revenue' => 'decimal:2',
    ];

    public function seller() {
        return $this->belongsTo(Seller::class);
    }
}
