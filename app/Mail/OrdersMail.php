<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrdersMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $order;
    public $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $order, $payment = null)
    {
        $this->user = $user;
        $this->order = $order;
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "FIMA : Order placed successfully";
        $data['title'] = 'Order Placed';
        $data['user'] = $this->user;
        $data['order'] = $this->order;
        $data['payment'] = $this->payment;
        return $this->subject($subject)->view('components.mails.order')->with($data);
    }
}
