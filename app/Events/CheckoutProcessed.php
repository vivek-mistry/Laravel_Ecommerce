<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckoutProcessed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id; 

    public $user_cart;

    public $user_address;

    public $coupon_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $user_cart,$user_address, $coupon_id = null)
    {
        $this->user_id = $user_id;
        $this->user_cart = $user_cart;
        $this->user_address = $user_address;
        $this->coupon_id = $coupon_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
