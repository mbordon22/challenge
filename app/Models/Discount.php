<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'priority',
        'active',
        'region_id',
        'brand_id',
        'access_type_code',
        'deleted_at'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class,'region_id');
    }

    public function access_type()
    {
        return $this->belongsTo(AccessType::class,'access_type_code', 'code');
    }

    public function discount_ranges()
    {
        return $this->hasMany(DiscountRange::class);
    }
}
