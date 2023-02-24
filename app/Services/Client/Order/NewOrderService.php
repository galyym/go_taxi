<?php

namespace App\Services\Client\Order;

use App\Events\Client\Order\OrderEvent;
use App\Events\ClientOrderEvent;
use App\Models\Order;
use App\Http\Responders\Responder;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Broadcasting\Broadcasters\UsePusherChannelConventions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

class NewOrderService
{
    protected $responder;
    public function __construct(Responder $responder){
        $this->responder = $responder;
    }

    public function newOrder(array $request): \Illuminate\Http\JsonResponse
    {
        $create = Order::create([
            'from_address' => $request["from_address"],
            'to_address' => $request["to_address"],
            'price' => $request["price"],
            'user_id' => Auth::id(),
            'departure_time' => $request["departure_time"] ?? null,
            'passenger_count' => $request["passenger_count"] ?? null,
            'salon' => $request["salon"] ?? null,
            'round_trip' => $request["round_trip"] ?? null,
            'luggage' => $request["luggage"] ?? null,
            'for_another_client' => $request["for_another_client"] ?? null,
            'comment' => $request["comment"] ?? null
        ])->toArray();

        OrderEvent::dispatch($create);
        ClientOrderEvent::dispatch($create);

        return $this->responder->success('success', $create);
    }


    public function selectOrders($request){
        ClientOrderEvent::dispatch($request);

        $driver =  Broadcast::connection();

        return $this->responder->success("success", $request);
    }

}
