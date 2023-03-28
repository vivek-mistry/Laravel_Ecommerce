<?php

namespace App\Repositories\Respository;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Filtered Prduct Data
     *
     * @param [type] $category_id
     * @param [type] $limit
     * @param [type] $start
     * @param array $filter
     * @return void
     */
    public function getFilterProductByCatgoryId($category_id = null, $limit = null, $start = null, $search = null, array $filter = [])
    {
        $product = Product::with(['product_images']);

        if($category_id)
        {
            $product->where('category_id', '=', $category_id);
        }

        if($search)
        {
            $product->where('product_name', 'like', '%' . $search . '%');
            $product->orWhere('brand_name', 'like', '%' . $search . '%');
        }

        $clone_product = clone $product;
        $totalRecords = $clone_product->count();
        
        if(isset($filter['price_filter']) && $filter['price_filter'] == 'low_to_high')
        {
            $product->orderBy('product_sale_price', 'ASC');
        }

        if(isset($filter['price_filter']) && $filter['price_filter'] == 'high_to_low')
        {
            $product->orderBy('product_sale_price', 'DESC');
        }

        if ($limit) {
            $product->take($limit)->skip($start);
        }
        $result = $product->get();
        return ['total' => $totalRecords, 'data' => $result];
    }

    /**
     * Get Product By id
     *
     * @param [type] $product_id
     * @param array $with
     * @return void
     */
    public function getProductById($product_id, $with = [])
    {
        $product = Product::where('id', '=', $product_id);

        if($with)
        {
            $product->with($with);
        }

        return $product->first();
    }
}
