<?php

namespace App\Events\Client\Order;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $order;
    protected $city_name;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $city_name)
    {
        $this->order = $order;
        $this->city_name = $city_name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel($this->city_name);
    }

    public function broadcastAs(){
        return 'newOrders';
    }
    public function broadcastWith(){
        return $this->order;
    }
}
