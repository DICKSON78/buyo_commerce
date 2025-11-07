<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['reporter_id', 'reported_user_id', 'reported_product_id', 'report_type', 'reason', 'status', 'admin_notes', 'resolved_by', 'resolved_at'];
    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id', 'id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id', 'id');
    }

    public function reportedProduct()
    {
        return $this->belongsTo(Product::class, 'reported_product_id', 'id');
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by', 'id');
    }
}
