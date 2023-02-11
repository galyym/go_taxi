<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\PhoneService;
use GuzzleHttp\Exception\GuzzleException;
use \Illuminate\Http\Client\Request;

class PhoneController extends Controller
{
    protected $service;
    public function __construct(PhoneService $service){
        $this->service = $service;
    }

    public function login(LoginRequest $request){
        return $this->service->login($request);
    }

    /**
     * @throws GuzzleException
     */
    public function verification(LoginRequest $request){
        return $this->service->verification($request);
    }
}
