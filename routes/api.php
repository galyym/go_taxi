<?php
declare(strict_types=1);

use App\Http\Controllers\Reference\CityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PhoneController;
use App\Http\Controllers\Client\Order\NewOrderController;



Route::group(['prefix' => '{lang}', 'where' => ['kk|ru']], function (){
    //register
    Route::post('user/register', [AuthController::class, 'register']);

    //login
    Route::post('login/phone', [PhoneController::class, 'login']);

    //verification
    Route::post("login/phone/verification", [PhoneController::class, 'verification']);

    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::group(['prefix' => 'client'], function (){
            Route::group(['prefix' => 'new/order'], function (){
                Route::post('create', [NewOrderController::class, 'newOrder']); // создать заказа
                Route::post('{id}/update', [NewOrderController::class, 'updateOrder']); // обновить заказ
                Route::delete('{id}/delete', [NewOrderController::class, 'deleteOrder']); // удалить заказ

                Route::get('{id}', [NewOrderController::class, 'show']); // выбрать заказ для показа на мобильке

                Route::post('select/order', [NewOrderController::class, 'selectOrder']); // выбрать заказ водителем для отправки предложение
                Route::post('select/driver', [NewOrderController::class, 'selectOrder']); // выбор водителя клиентом
            });
        });

        Route::group(['prefix' => 'reference'], function (){
            Route::get('/cities', [CityController::class, 'index']);
        });
    });
});
