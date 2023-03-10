<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Responders\Responder;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    protected $service;
    public function __construct(AuthService $service){
        $this->service = $service;
    }

    /**
     * @throws GuzzleException
     */
    public function refreshToken(Request $request){

        return $this->service->refreshToken($request->refreshToken);
    }

    /**
     * Register a new user.
     * @param AuthRequest $request
     * @return JsonResponse
     */
    public function register(AuthRequest $request)
    {
        return $this->service->register($request->validated());
    }

    /**
     * Logout the user.
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $response = ["message" => "Successfully logged out"];
        return response($response, 200);
    }
}
