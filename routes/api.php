<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MealController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('checkIfCustomer')->group(function () {
        Route::get('/list_menu_items', [MealController::class, 'listMenuItems']);
        Route::get('/check_availability', [ReservationController::class, 'checkAvailability']);
        Route::post('/reserve_table', [ReservationController::class, 'reserveTable']);
        Route::post('/pay', [OrderController::class, 'pay']);
    });

    Route::middleware('checkIfWaiter')->group(function () {
        Route::post('/place_order', [OrderController::class, 'placeOrder']);
    });
});
