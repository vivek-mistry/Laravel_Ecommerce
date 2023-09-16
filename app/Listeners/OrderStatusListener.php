<?php

namespace App\Listeners;

use App\Events\OrderStatusProcessed;
use App\Models\OrderStatusHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderStatusListener
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
     * @param  \App\Events\OrderStatusProcessed  $event
     * @return void
     */
    public function handle(OrderStatusProcessed $event)
    {
        $order_status = $this->createOrderStatus($event->order_id, $event->order_status);

        return $order_status;
    }

    public function createOrderStatus($order_id, $order_status)
    {
        return OrderStatusHistory::create([
            'order_id' => $order_id,
            'status' => $order_status
        ]);
    }
}
