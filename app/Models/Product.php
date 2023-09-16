<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Set Table name
     *
     * @var string
     */
    protected $table = 'products';

    // protected $casts = [
    //     'product_image_urls' => 'array',
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'brand_name',
        'product_name',
        'product_price',
        'product_sale_price',
        'description',
        'product_url',
        'color_name',
        'product_size',
        // 'product_image_urls'
    ];

    /*public function setProductImageUrlsAttribute($value)
    {
       
        $this->attributes['product_image_urls'] = json_encode($value);
    }

    public function getProductImageUrlsAttribute()
    {
        return json_decode($this->attributes['product_image_urls']);
    }*/

    public function setProductSizeAttribute($value)
    {
        $this->attributes['product_size'] = json_encode($value);
    }

    /**
     * product_images has many loaded
     *
     * @return HasMany
     */
    public function product_images() : HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * categories relation load
     *
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
