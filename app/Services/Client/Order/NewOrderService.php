<?php

namespace App\Services\Client\Order;

use App\Events\Client\Order\OrderEvent;
use App\Events\ClientOrderEvent;
use App\Models\Client\CompletedOrder;
use App\Models\Order;
use App\Http\Responders\Responder;
use App\Models\Reference\City;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Broadcasting\Broadcasters\UsePusherChannelConventions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;
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
            'comment' => $request["comment"] ?? null,
            'from_city_id' => $request["from_city_id"] ?? null,
            'to_city_id' => $request["to_city_id"] ?? null,
            'order_status_id' => 1
        ])->toArray();

        $city_id = City::find($request["from_city_id"])->id;


        OrderEvent::dispatch($create, $city_id);
        ClientOrderEvent::dispatch($create);

        return $this->responder->success('success', $create);
    }

    public function updateOrder($id, array $request): \Illuminate\Http\JsonResponse {

        $request += ["order_status_id" => 2];
        $order = Order::find($id);
        $query = $order->update($request);
        if ($query) {
            $city_id = City::find($request["from_city_id"])->id;
            OrderEvent::dispatch($order->toArray(), $city_id);
            return $this->responder->success('success', $order);
        }
        return $this->responder->error("error", "Order not found or not updated");
    }

    public function deleteOrder($id): \Illuminate\Http\JsonResponse {
        $order = Order::find($id);
        if (!$order) {
            return $this->responder->error("error", "Order not found or not deleted");
        }

        $exception = DB::transaction(function () use ($order) {
            try {
                CompletedOrder::create($order->toArray());
                $order->delete();
                return true;
            }catch (\Exception $e){
                return false;
            }
        });

        if ($exception) {
            $city_id = City::find($order->from_city_id)->id;
            OrderEvent::dispatch([
                "id" => $id,
                "order_status_id" => 3
            ], $city_id);
            return $this->responder->success("success", $exception);
        }
        return $this->responder->error("error", "Order not found or not deleted");
    }


    public function selectOrders($request){
        ClientOrderEvent::dispatch($request);

        $driver =  Broadcast::connection();

        return $this->responder->success("success", $request);
    }

    public function show($id): \Illuminate\Http\JsonResponse {
        $order = Order::find($id);

        if ($order){
            return $this->responder->success('success', $order);
        }
        return $this->responder->error('error', 'Order not found');
    }

}
