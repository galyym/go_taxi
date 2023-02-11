<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PhoneController;
use App\Http\Controllers\Client\Order\NewOrderController;



Route::group(['prefix' => '{lang}', 'where' => ['kk|ru']], function (){
    //register
    Route::post('register', [AuthController::class, 'register']);

    //login
    Route::post('login/phone', [PhoneController::class, 'login']);

    //verification
    Route::post("login/phone/verification", [PhoneController::class, 'verification']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::group(['prefix' => 'client'], function (){
            Route::post('create/new/order', [NewOrderController::class, 'newOrder']);
        });
    });
});
