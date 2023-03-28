<?php

namespace App\Repositories\Respository;

use App\Models\Cart;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CartRepository implements CartRepositoryInterface
{
    /**
     * Create or update Cart
     *
     * @param array $data
     * @param string|null $id
     * @return Cart
     */
    public function createOrUpdate(array $data, string $id = null): Cart
    {
        if (!isset($id)) {
            $cart = new Cart($data);
        } else {
            $cart = Cart::find($id);

            foreach ($data as $key => $value) {
                $cart->$key = $value;
            }
        }
        $cart->save();
        return $cart;
    }

    /**
     * Get User Cart list
     *
     * @return array
     */
    public function getUserCartList() : array
    {
        $user_id = isset(Auth::user()->id) ? Auth::user()->id : null;
        $tota_actual_price = 0;
        $total_sale_price = 0;
        $cart = Cart::with(['product', 'product.product_images'])->where('user_id', $user_id)->orderBy('id', 'DESC')->get();

        if($cart->count() > 0)
        {
            $tota_actual_price = number_format(array_sum(array_column(array_column($cart->toArray(), 'product'), 'product_price')), 2);
            // $total_sale_price = number_format(array_sum(array_column(array_column($cart->toArray(), 'product'), 'product_sale_price')), 2);
            $total_sale_price = number_format(array_sum(array_column($cart->toArray(), 'total_price')), 2);
        }

        return [
            'cart' => $cart,
            'cart_counter' => str_pad($cart->count(), 2, '0', STR_PAD_LEFT),
            'total_actual_price' => $tota_actual_price,
            'total_sale_price' => $total_sale_price
        ];
    }

    public function getRowByWhere(array $where)
    {
        return Cart::where($where)->first();
    }
}
