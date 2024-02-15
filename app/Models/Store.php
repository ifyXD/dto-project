<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['user_id','store_name', 'location', 'image'];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); // 'user_id' is the custom foreign key
    }
    public function reseller()
    {
        return $this->hasOne(Reseller::class, 'store_id', 'id');
    }
}
