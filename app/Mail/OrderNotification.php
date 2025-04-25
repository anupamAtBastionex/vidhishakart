<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $product;
    public $thankData;

    public function __construct($order, $product, $thankData)
    {
        $this->order = $order;
        $this->product = $product;
        $this->thankData = $thankData;
    }

    public function build()
    {
        return $this->subject('New Order Notification - Order #'.$this->order->order_number)
                    ->view('emails.order_notification'); // Create this view
    }
}