<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountRange extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_days',
        'to_days',
        'code',
        'discount',
        'discount_id'
    ];
}
