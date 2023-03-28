<?php

namespace App\Listeners;

use App\Events\PaymentEvent;
use App\Models\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PaymentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PaymentEvent  $event
     * @return void
     */
    public function handle(PaymentEvent $event)
    {
        // Log::info("Payment Event Call");
        switch($event->payment_parameter['payment_type']){
            case(Payment::PAYMENT_TYPE_STRIPE):
                $payment = $this->makeStripePayment($event->order_id, $event->payment_parameter);
                break;
            case(Payment::PAYMENT_TYPE_RAZORPAY):
                $payment = $this->makeRazorPayment($event->order_id, $event->payment_parameter);
                break;
        }
        return $payment;
    }

    public function makeStripePayment($order_id, $payment_parameter)
    {
        $data = [];
        // Log::info("make Stripe PAyment");
        if($payment_parameter['redirect_status'] === 'succeeded')
        {
            $data['payment_status'] = Payment::PAYMENT_STATUS_COMPLETED;
        }else if($payment_parameter['redirect_status'] === 'processing'){
            $data['payment_status'] = Payment::PAYMENT_STATUS_PROCESSING;
        }else{
            $data['payment_status'] = Payment::PAYMENT_STATUS_FAILED;
        }
        $data['payment_type'] = $payment_parameter['payment_type'];
        $data['order_id'] = $order_id;
        $data['payment_id'] = $payment_parameter['payment_intent'];
        
        $payment = Payment::create($data);
        // Log::info("Payment respone=> ". print_r($payment, true));;
        return $payment;
    }

    public function makeRazorPayment($order_id, $payment_parameter)
    {

    }
}
