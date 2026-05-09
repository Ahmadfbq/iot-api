<?php

use App\Http\Controllers\DeliveryController;
use App\Models\User;

Route::prefix("delivery")->group(function () {
    Route::get('/user/{id}', fn($id) => User::find($id)); // web
    Route::get('/', [DeliveryController::class, 'index']); // web
    Route::post('/info', [DeliveryController::class, 'receiveInfo']); // from the esp32 device
    Route::get('/info', [DeliveryController::class, 'listInfo']); // web
    Route::get('/info/{id}', [DeliveryController::class,'displayInfo']); // web
});