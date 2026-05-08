<?php

use App\Http\Controllers\HomeController;

Route::prefix("home")->group(function () {
    Route::get('/', [HomeController::class, 'index']); // web
    Route::post('/info', [HomeController::class, 'receiveInfo']); // from the esp32 device
    Route::get('/info/{id}', [HomeController::class,'displayInfo']); // web
});