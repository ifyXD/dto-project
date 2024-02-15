<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'product_name',
        'product_description',
        'stock',
        'price',
        'unit',
        'image',
    ];

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relationship with the Category model
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }
}
