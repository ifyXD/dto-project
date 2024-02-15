<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtInformation extends Model
{
    protected $fillable = [
        'debtor_name',
        'debtor_number',
        'debtor_location',
        'debt_amount',
        'description',
        'issue_date',
        'due_date',
        'status',
        'user_id',
    ];

    use HasFactory;
}
