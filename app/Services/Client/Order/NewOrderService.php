<?php

namespace App\Services\Client\Order;

use App\Events\Client\Order\OrderEvent;
use App\Models\Order;
use App\Http\Responders\Responder;
use Illuminate\Support\Facades\Auth;

class NewOrderService
{
    protected $responder;
    public function __construct(Responder $responder){
        $this->responder = $responder;
    }

    public function newOrder($request): \Illuminate\Http\JsonResponse
    {
        $create = Order::create([
            'from_address' => $request->from_address,
            'to_address' => $request->to_address,
            'price' => $request->price,
            'user_id' => Auth::id(),
            'departure_time' => $request->departure_time ?? null,
            'passenger_count' => $request->passenger_count ?? null,
            'salon' => $request->salon ?? null,
            'round_trip' => $request->round_trip ?? null,
            'luggage' => $request->luggage ?? null,
            'for_another_client' => $request->for_another_client ?? null,
            'comment' => $request->comment ?? null
        ]);

        event(new OrderEvent($create));

        return $this->responder->success('success', $create);
    }
}
