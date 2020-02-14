<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Notifications\OrderCreateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUser implements ShouldQueue
{
    public $queue = 'orders';
    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
//        \App\Jobs\NotifyUser::dispatch($event->order, $event->user);
        $event->user->notify(
            new OrderCreateNotification($event->order, $event->user)
        );
    }
}
