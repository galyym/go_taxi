<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Reference\CityService;

class CityController extends Controller
{
    protected $service;

    public function __construct(CityService $service){
        $this->service = $service;
    }

    public function index(){
        return $this->service->index();
    }
}
