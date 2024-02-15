<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'debtor_name',
        'debtor_number',
        'debtor_location',
        'product_id',
        'product_name',
        'product_price',
        'product_qty',
        'debt_amount',
        'description',
        'issue_date',
        'due_date',
        'status',
        'debt_log_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function debtLog()
    {
        return $this->belongsTo(DebtLog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
