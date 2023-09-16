<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Set Table name
     *
     * @var string
     */
    protected $table = 'order_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'quantity',
        'product_amount', 
        'total_amount',
        'shipping_cost'
    ];

    /**
     * product relation load
     *
     * @return HasOne
     */
    public function product() : HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
