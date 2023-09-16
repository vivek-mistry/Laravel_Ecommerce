<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    const COUPON_TYPE_PERSONALIZED = 'Personalized';
    const COUPON_TYPE_GENERALIZED = 'Generalized';

    const DISCOUNT_TYPE_PER = 'Percentage';
    const DISCOUNT_TYPE_AMOUNT = 'Amount';

    /**
     * Set Table name
     *
     * @var string
     */
    protected $table = 'coupons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'coupon_code',
        'description',
        'coupon_type', #(Personalized, Generalized)
        'discount_type', #(Percentage, Amount)
        'discount',
        'min_order_amount',
        'max_discount_amount',
        'expired_at',
        'number_of_time_used',
        'is_active'
    ];
}
