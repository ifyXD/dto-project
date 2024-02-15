<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    protected $fillable = [
        'store_id',
        'reseller_name',
        'contact_number',
        'location',
        'image',
    ];

    use HasFactory;

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
