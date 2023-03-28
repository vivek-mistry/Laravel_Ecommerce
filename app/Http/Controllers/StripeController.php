<?php

namespace App\Http\Controllers;

use App\Services\StripeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StripeController extends Controller
{
    /**
     * @var StripeService
     */
    protected $stripeService;

    /**
     * @param StripeService $stripeService
     */
    public function __construct(
        StripeService $stripeService
    )
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Load Stripe checkout view
     *
     * @return void
     */
    public function stripeCheckout(Request $request)
    {
        $data['applied_coupon_id'] = $request->get('applied_coupon_id', null); 
        return view('components.front-end.pages.stripe-checkout')->with($data);
    }
    
    /**
     * Generate Payment Intent
     *
     * @return JsonResponse
     */
    public function generatePaymentIntent() : JsonResponse
    {
        $payment_intent = $this->stripeService->createPaymentIntent();
        
        if(!isset($payment_intent['error']))
        {
            return response()->json($payment_intent, 200);
        }

        return response()->json($payment_intent, 500);
    }
    
    /**
     * Return success call of stripe
     *
     * @return View
     */
    public function success() : View
    {
        return view('components.front-end.pages.payment-success');
    }
    
    /**
     * Return Failure call of stripe
     *
     * @return View
     */
    public function failure() : View
    {
        return view('components.front-end.pages.payment-failure');
    }
}
