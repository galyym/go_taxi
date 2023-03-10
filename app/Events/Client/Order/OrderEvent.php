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
    protected $city_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $city_id)
    {
        $this->order = $order;
        $this->city_id = $city_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        return new Channel($this->city_name);
        return ["newOrder_".$this->city_id];
    }

    public function broadcastAs(){
        return 'newOrders';
    }
    public function broadcastWith(){
        return $this->order;
    }
}
