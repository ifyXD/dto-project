<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtLog extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'debt_info_id', 'amount', 'date', 'log_status'];

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }
}
