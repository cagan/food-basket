<?php

namespace App\Notifications;

use App\Order;
use App\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreateNotification extends Notification
{
    protected $order;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param  Order  $order
     * @param  User  $user
     */
    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->greeting("Hello, {$this->user->name}")
            ->line("Your order:{$this->order->order_code} is preparing.")
            ->action('Go To Website', url('/'))
            ->line('We will inform you as soon as possible')
            ->greeting('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
