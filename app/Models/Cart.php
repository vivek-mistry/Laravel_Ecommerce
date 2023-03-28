<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    /**
     * Set Table name
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 
        'product_id', 
        'quantity', 
        'per_unit_price', 
        'total_price'
    ];

    /**
     * product relation load
     *
     * @return BelongsTo
     */
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    
}
