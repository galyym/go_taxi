<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    protected $service;
    public function __construct(AuthService $service){
        $this->service = $service;
    }

    public function refreshToken(Request $request){

        return $this->service->refreshToken($request->refreshToken);
    }

    /**
     * Register a new user.
     * @param AuthRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function register(AuthRequest $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        return $this->service->register($name, $email, $password);
    }

     /**
     * Logout the user.
     * @param Request $request
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $response = ["message" => "Successfully logged out"];
        return response($response, 200);
    }
}
