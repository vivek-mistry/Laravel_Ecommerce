<?php

namespace App\Http\Controllers;

use App\Events\CheckoutProcessed;
use App\Events\PaymentEvent;
use App\Mail\OrdersMail;
use App\Models\Payment;
use App\Repositories\Interfaces\CartRepositoryInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Repositories\Interfaces\UserAddressRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @var UserAddressRepositoryInterface
     */
    protected $userAddressRepository;

    /**
     * @var CouponRepositoryInterface
     */
    protected $couponRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        UserAddressRepositoryInterface $userAddressRepository,
        CouponRepositoryInterface $couponRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->userAddressRepository = $userAddressRepository;
        $this->couponRepository = $couponRepository;
    }

    /**
     * Load view
     *
     * @return View
     */
    public function index(): View
    {
        $data = $this->cartRepository->getUserCartList();
        $data['user_default_address'] = $this->userAddressRepository->getDefaultAddress(Auth::user()->id);
        $data['coupons'] = $this->couponRepository->getActiveGeneralizedCoupon();
        
        return view('components.front-end.pages.checkout')->with($data);
    }

    public function makeCheckout(Request $request)
    {
        $user_carts = $this->cartRepository->getUserCartList();
        if($user_carts['total_sale_price'] == 0)
        {
            return redirect('my-orders');
        }

        $user = Auth::user();
        $cart_data = $this->cartRepository->getUserCartList();
        $user_address = $this->userAddressRepository->getDefaultAddress($user->id);
        $coupon_id = $request->get('applied_coupon_id', null);

        /**
         * Create Order
         */
        $order = event(new CheckoutProcessed($user->id, $cart_data, $user_address, $coupon_id));

        $order_id = "";
        if (isset($order[0]->id)) {
            $order_id = $order[0]->id;
        }

        /**
         * Stripe Payment Call
         */
        $payment = null;
        if ($request->get('payment_intent', null)) {
            $stripe_data = $this->prepareStripeData($request);
            $payment = event(new PaymentEvent($order_id, $stripe_data))[0];
        }

        /**
         * Send EMAIL
         */
        Mail::to($user->email)->send(new OrdersMail($user, $order[0], $payment));

        return view('components.front-end.pages.thank-you');
    }

    public function prepareStripeData($request)
    {
        $stripe_data['payment_intent'] = $request->get('payment_intent', null);
        $stripe_data['payment_intent_client_secret'] = $request->get('payment_intent_client_secret', null);
        $stripe_data['redirect_status'] = $request->get('redirect_status', null);
        $stripe_data['payment_type'] = Payment::PAYMENT_TYPE_STRIPE;

        return $stripe_data;
    }
}
