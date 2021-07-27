<?php

namespace Nrz\Order\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangeOrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $status;
    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $status)
    {
        $this->status = $status;
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("تغیر وضعیت سفارش")
            ->line("{$this->order->products[0]->pivot->product->name} تغغیر وضعیت سفارش")
            ->action('Notification Action', url('/'))
            ->line(  "تغغیر یافت{$this->status} وضعیت سفارش شما به" );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
