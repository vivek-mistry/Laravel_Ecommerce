<?php

namespace App\Listeners;

use App\Events\CheckoutProcessed;
use App\Events\OrderStatusProcessed;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\UsedCoupon;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutListener
{

    protected $couponRepository;

    public function __construct(
        CouponRepositoryInterface $couponRepository
    )
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * Handle the event.
     * 
     * @param  \App\Events\CheckoutProcessed  $event
     * @return void
     */
    public function handle(CheckoutProcessed $event)
    {
        $user_id = $event->user_id;

        $user_cart = $event->user_cart;

        $user_address = $event->user_address;

        $coupon_id = $event->coupon_id;

        Log::info("Initialize create order");

        try{
            DB::beginTransaction();

            // Manage Discount if available
            $coupon_discount_amount = 0;
            if($coupon_id)
            {
                Log::info("Coupon event inside if");
                // $coupon_discount_amount = $this->calculateCouponDiscountAmount($user_cart, $coupon_id);
                $coupon_discount_amount = $this->couponRepository->calculateCouponDiscountAmount($coupon_id,$user_cart['total_sale_price']);
            }

            // Create Order
            $order = $this->createOrder($user_id, $user_cart, $user_address, $coupon_discount_amount);

            // Store Coupon if exist
            if($coupon_id)
            {
                $this->saveUsedCoupon($user_id, $order->id, $coupon_id);
            }

            // Order Status Event Call (TODO : Mail Functionality)
            event(new OrderStatusProcessed($order->id, OrderStatusHistory::ORDER_STATUS_PENDING));

            DB::commit();

            return $order;
        }
        catch(Exception $ex)
        {
            DB::rollBack();
            return false;
        }
    }

    public function saveUsedCoupon($user_id, $order_id, $coupon_id)
    {
        return UsedCoupon::create([
            'user_id' => $user_id,
            'order_id' => $order_id,
            'coupon_id' => $coupon_id
        ]);
    }

    // COUPON CODE MANAGE
    public function calculateCouponDiscountAmount($user_carts, $coupon_id)
    {
        $coupon = Coupon::find($coupon_id);
        $total_discount = number_format(0, 2);
        if($coupon->discount_type === Coupon::DISCOUNT_TYPE_PER)
        {
            $total_discount = number_format(($user_carts['total_sale_price'] * $coupon->discount) / 100, 2);
            
            if($total_discount > $coupon->max_discount_amount){
                $total_discount = $coupon->max_discount_amount;
            }   
        }

        if($coupon->discount_type === Coupon::DISCOUNT_TYPE_AMOUNT)
        {
            $total_discount = $coupon->discount;
        }
        Log::info("Coupon discount amount => ".$total_discount);
        return $total_discount;
    }

    /**
     * Create Order
     *
     * @param [type] $user_id
     * @param [type] $user_cart
     * @param [type] $user_address
     * @return void
     */
    public function createOrder($user_id, $user_cart, $user_address, $coupon_discount_amount)
    {
        $data = [
            'user_id' => $user_id,
            'order_number' => generateOrderNumber(),
            'full_name' => $user_address->full_name,
            'email' => $user_address->email,
            'phone_number' => $user_address->phone_number,
            'shipping_address' => $user_address->address,
            'shipping_pin_code' => $user_address->pin_code,
            'shipping_city' => $user_address->city,
            'shipping_state' => $user_address->state,
            'total_amount' => $user_cart['total_sale_price'],
            'tax_amount' => 0,
            'coupon_discount_amount' => $coupon_discount_amount,
            'net_amount' => $user_cart['total_sale_price'] - $coupon_discount_amount
        ];

        $order = Order::create($data);

        // Log::info('create order'. print_r($order, true));

        $this->createOrderItem($user_id, $user_cart['cart'], $order);

        return $order;
    }

    /**
     * Create Order Item
     *
     * @param [type] $user_id
     * @param [type] $carts
     * @param [type] $order
     * @return void
     */
    public function createOrderItem($user_id, $carts, $order)
    {
        $order_item= [];
        // dd($order->toArray());
        foreach($carts as $key => $cart)
        {
            $data = [
                'user_id' => $user_id,
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'product_amount' => $cart->per_unit_price, 
                'total_amount' => $cart->total_price,
                'shipping_cost' => 0
            ];
            // dd($data);
            $order_item[] = OrderItem::create($data);
        }
        // Log::info('create order item'. print_r($order_item, true));
        $this->removeCart($user_id);
        return $order_item;
    }

    /**
     * Remove from cart
     *
     * @param [type] $user_id
     * @return void
     */
    public function removeCart($user_id)
    {
        return Cart::where('user_id', '=', $user_id)->delete();
    }
}
