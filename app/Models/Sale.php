<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

   protected $fillable = [
        'user_id',
        'product_id',
        'reports_id',
        'name',
        'quantity',
        'price',
        'stock',
        'subtotal',
    ];

    // Relationship with SalesReport model
    public function salesReport()
    {
        return $this->belongsTo(SalesReport::class, 'reports_id');
    }
}
