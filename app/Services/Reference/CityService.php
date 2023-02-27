<?php

namespace App\Services\Reference;

use App\Http\Responders\Responder;
use App\Models\Reference\City;

class CityService
{
    protected $responder;
    public function __construct(Responder $responder){
        $this->responder = $responder;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $cities = City::all();
        return $this->responder->success('success', $cities);
    }

}
