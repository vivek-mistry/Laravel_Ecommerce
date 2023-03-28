<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CartController extends Controller
{

    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @var CouponRepositoryInterface
     */
    protected $couponRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        CouponRepositoryInterface $couponRepository
    )
    {
        $this->cartRepository = $cartRepository;
        $this->couponRepository = $couponRepository;
    }

    /**
     * TODO : Move to functionality code to events & listner
     */

    /**
     * @param [type] $quantity
     * @param [type] $per_unit_price
     * @return float
     */
    public function calculateTotalPrice($quantity, $per_unit_price) : float
    {
        return number_format(($quantity * $per_unit_price), 2);
    }

    /**
     * Store cart 
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $user_id = Auth::user()->id;
        $check = Cart::where('user_id', $user_id)->where('product_id', $request->product_id)->get();

        if(count($check) > 0)
        {
            return response()->json(['status' => false,'message' => 'Already added in cart.'], 200);
        }
        
        $data = [
            'user_id' => Auth::user()->id, 
            'product_id' => $request->product_id, 
            'quantity' => $request->quantity, 
            'per_unit_price' => $request->price, 
            'total_price' => $this->calculateTotalPrice($request->quantity, $request->price)
        ];

        Cart::create($data);

        return response()->json(['status' => true,'data' => $data], 200);
    }

    /**
     * Get Cart List
     *
     * @return JsonResponse
     */
    public function getUserCart() : JsonResponse
    {
        $user_cart_list = $this->cartRepository->getUserCartList();

        // Log::info('cart list => '.print_r($user_cart_list['tota_actual_price'], false));

        $html = view('components.front-end.common.cart-dropdown')->with(['cart_products' => $user_cart_list['cart']])->render();

        return response()->json([
            'html_view' => $html, 
            'cart_counter' => $user_cart_list['cart_counter'],
            'total_actual_price' => $user_cart_list['total_actual_price'],
            'total_sale_price' => $user_cart_list['total_sale_price']
        ], 200);
    }

    public function removecart($cart_id)
    {
        Cart::destroy($cart_id);

        return response()->json([true], 200);
    }

    public function cartList(): View
    {
        $user_carts = $this->cartRepository->getUserCartList();
        
        return view('components.front-end.pages.cart-list')->with($user_carts);
    }

    public function cartJson(Request $request)
    {
        $user_carts = $this->cartRepository->getUserCartList();

        // COUPON CODE MANAGE
        $coupon_id = $request->get('coupon_id', null);
        if($coupon_id)
        {
            $total_discount_amount = $this->couponRepository->calculateCouponDiscountAmount($coupon_id, $user_carts['total_sale_price']);
            $user_carts['total_sale_price'] = number_format(($user_carts['total_sale_price'] - $total_discount_amount), 2);
        }
        
        return response()->json($user_carts, 200);
    }

    /**
     * Update Quantity
     *
     * @param Request $request
     * @return void
     */
    public function updateCartQuantity(Request $request)
    {
        $user_id = isset(Auth::user()->id) ? Auth::user()->id : null;
        $product_id = $request->product_id;
        $cart = Cart::where('user_id', $user_id)->where('product_id', $product_id)->first();

        if(!isset($cart->id))
        {
            return response()->json(['status' => false,'message' => 'This item is not added to cart.'], 200);
        }

        $cart->quantity = $request->quantity;
        $cart->total_price = number_format(($request->quantity * $cart->per_unit_price), 2);
        $cart->save();
        return response()->json(['status' => true,'message' => 'Quantity Updated.'], 200);
    }
}
