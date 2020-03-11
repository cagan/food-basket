<?php

namespace App\Events;

use Exception;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Uuid;

class OrderCreated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $order;
    public $user;

    /**
     * Create a new event instance.
     *
     * @param $order
     * @param $user
     */
    public function __construct($order, $user)
    {
        $this->order = $order;
        $this->user = $user;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     * @throws Exception
     */
    public function broadcastOn()
    {
        $uuid = Uuid::uuid4();

        return new Channel("user-order-${$uuid}-created");
    }
}
