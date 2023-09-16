<?php

use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Get Categories from cache
 */
if (! function_exists('getCategories')) {
    function getCategories() {
        return Cache::rememberForever('cache-categories', function () {
            $Category = Category::all();
            return $Category;
        });
    }
}

/**
 * Calculate Discount with percentage
 */
if (! function_exists('calculateDiscountPercentage')) {
    function calculateDiscountPercentage($actual_price, $selling_price) {
        if($actual_price != $selling_price)
        {
            $disocunt = ($actual_price - $selling_price) * 100 / $actual_price;
            return number_format($disocunt, 2);
        }
        return 0;
    }
}

/**
 * Set Default Date format for all displaying format
 */
if (! function_exists('setDateFormat')) {
    function setDateFormat($date) {
        return Carbon::parse($date)->format('M d, Y');
    }   
}

/**
 * Generate Order number with particular format
 */
if (! function_exists('generateOrderNumber')) {
    function generateOrderNumber() {
        $today_date = Carbon::now();
        $total_orders = Order::count() + 1;
        $format = str_pad($total_orders, 4, '0', STR_PAD_LEFT);
        $unique_id = $today_date->format('Y').$today_date->format('m').$format;
        return $unique_id;
    }
}