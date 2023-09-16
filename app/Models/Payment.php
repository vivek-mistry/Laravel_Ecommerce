<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    // const PAYMENT_TYPE_INITIATED = 'Initiated';
    const PAYMENT_STATUS_PROCESSING = 'Processing';
    const PAYMENT_STATUS_COMPLETED = 'Completed';
    const PAYMENT_STATUS_FAILED = 'Failed';
    const PAYMENT_STATUS_CANCELLED  = 'Cancelled';

    const PAYMENT_TYPE_STRIPE = 'Stripe';
    const PAYMENT_TYPE_RAZORPAY = 'Razorpay';

    /**
     * Set Table name
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'payment_type',
        'payment_status',
        'payment_id',
        'payment_gateway_response'
    ];
}
