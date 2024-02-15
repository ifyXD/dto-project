<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'category_name',
        'description',
        'image',
    ];

    // Ensure that the 'user_id' attribute is cast to an integer
    protected $casts = [
        'user_id' => 'integer',
    ];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function products() {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
