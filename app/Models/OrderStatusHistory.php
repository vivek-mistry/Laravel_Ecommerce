<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatusHistory extends Model
{
    use HasFactory, SoftDeletes;

    const ORDER_STATUS_PENDING = 'Pending';
    const ORDER_STATUS_CONFIRMED = 'Confirmed';
    const ORDER_STATUS_CANCELLED = 'Cancelled';
    const ORDER_STATUS_SHIPPED = 'Shipped';
    const ORDER_STATUS_DELIVERED = 'Delivered';

    /**
     * Set Table name
     *
     * @var string
     */
    protected $table = 'order_status_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'status'
    ];
}
