<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Set default order by
     *
     * @return void
     */
    protected static function booted()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    /**
     * Set Table name
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 
        'order_number', 
        'full_name',
        'email',
        'phone_number',
        'shipping_address', 
        'shipping_pin_code', 
        'shipping_city',
        'shipping_state',
        'total_amount',
        'tax_amount',
        'coupon_discount_amount',
        'net_amount',
        // 'payment_type', 
        // 'payment_status',
    ];

    /**
     * order items relation load
     *
     * @return HasMany
     */
    public function items() : HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * From order histories get current_order_status
     *
     * @return HasOne
     */
    public function current_order_status() : HasOne
    {
        return $this->hasOne(OrderStatusHistory::class, 'order_id');
    }

    /**
     * payment relation load
     *
     * @return HasOne
     */
    public function payment() : HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
