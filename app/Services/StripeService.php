<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\StripeClient;

class StripeService
{
    const STRIPE_PUB_KEY = 'pk_test_51Lp40ISApArrs11VNVo5TtfxDAY5NT9cZdfIzBV7Z4bYgdOvfR6MDlGKONxX3uKtJSpgRa9atISVyn1fW2cvzhod00pOIedFTh';
    const STRIPE_SECRET_KEY = 'sk_test_51Lp40ISApArrs11VwfFKizSNuiaKqwsfqkn6VQN0Gu58uiUAIp9Yuswffj9HOZEhsG3CoaxnpJVuYDos3DT0cDML00N131oamg';

    protected $stripe;

    public function __construct()
    {
        // $this->stripe = Stripe::setApiKey(self::STRIPE_SECRET_KEY);
    }

    public function createPaymentIntent()
    {
        // dd(self::STRIPE_SECRET_KEY);
        Stripe::setApiKey(self::STRIPE_SECRET_KEY);
        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            // Log::info('Object stripe => '. print_r($jsonObj, true));

            // Create a PaymentIntent with amount and currency
            $paymentIntent = PaymentIntent::create([
                'amount' => ($jsonObj->total_sale_price * 100),
                'currency' => 'inr',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            // Response of payment intent
            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            // Finale return
            return $output;
        } catch (Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function getPaymentRecordsFromtOntentId($payment_intent_id)
    {
        /** 
         * Steps
         * 1. GetPayment intent record from stripe
         * 2. Check condition success. failure. pending
         * 3. According to them entry the records of that URL
         * 
         * $this->successCall
         * $this->failureCall
         * $this->pendingCall
         *
         */
    }

    public function successCall()
    {
    }

    public function failureCall()
    {
    }

    public function pendingCall()
    {
    }

    /**
     * Cancel Payment Intent
     *
     * @param [type] $payment_intent_id
     * @return void
     */
    public function cancelPaymentIntent($payment_intent_id)
    {
        Stripe::setApiKey(self::STRIPE_SECRET_KEY);

        $stripe = new StripeClient(self::STRIPE_SECRET_KEY);
        $cancel = $stripe->paymentIntents->cancel(
            $payment_intent_id,
            []
        );
        return $cancel;
    }
}
