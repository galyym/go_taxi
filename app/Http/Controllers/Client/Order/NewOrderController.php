<?php

namespace App\Http\Controllers\Client\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Order\NewOrderRequest;
use App\Http\Requests\Client\Order\SelectOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Client\Order\NewOrderService;

class NewOrderController extends Controller
{
    protected $service;

    public function __construct(NewOrderService $service){
        $this->service = $service;
    }

    public function newOrder(NewOrderRequest $request){
        return $this->service->newOrder($request->validated());
    }

    public function selectOrder(SelectOrderRequest $request){
        return $this->service->selectOrders($request->validated());
    }

    public function show($lang, $id){
        return $this->service->show($id);
    }
}
