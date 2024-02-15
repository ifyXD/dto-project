<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'cash', 'total', 'balance', 'date'];

    // Relationship with Sale model
    public function sales()
    {
        return $this->hasMany(Sale::class, 'reports_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'reports_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
