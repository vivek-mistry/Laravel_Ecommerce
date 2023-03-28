<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\returnSelf;

class CouponController extends Controller
{
    /**
     * @var CouponRepositoryInterface
     */
    protected $couponRepository;

    /**
     * @var CartRepositoryInterface 
     */
    protected $cartRepository;
    
    /**
     * @param CouponRepositoryInterface $couponRepository
     */
    public function __construct(
        CouponRepositoryInterface $couponRepository,
        CartRepositoryInterface $cartRepository
    )
    {
        $this->couponRepository = $couponRepository;
        $this->cartRepository = $cartRepository;
    }

    /**
     * Applied Coupon Code
     *
     * @param Request $request
     * @param [type] $coupon_id
     * @return void
     */
    public function applyCoupon(Request $request, $coupon_id)
    {
        $coupon = $this->couponRepository->getById($coupon_id);

        $cart = $this->cartRepository->getUserCartList();

        if($coupon->min_order_amount > $cart['total_sale_price'])
        {
            return response()->json([
                'status' => false,
                'message' => 'Minimum required amount '.$coupon->min_order_amount
            ], 200);
        }

        /**
         * Check coupon is used or not
         */
        if(isset(Auth::user()->id))
        {
            $used_coupon_count = $this->couponRepository->getCountOfCouponUsedByUser(Auth::user()->id, $coupon_id);
            if($used_coupon_count == $coupon->number_of_time_used)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'You have already used this coupon'
                ], 200);
            }
        }

        /**
         * Discount Type
         */
        // COUPON CODE MANAGE
        $total_discount = $this->couponRepository->calculateCouponDiscountAmount($coupon_id,$cart['total_sale_price']);

        return response()->json([
            'status' => true,
            'message' => 'Congratulation, you saved $'.$total_discount,
            'total_discount' => $total_discount,
            'pay_amount' => number_format(($cart['total_sale_price'] - $total_discount), 2)
        ], 200);
    }


    
}
