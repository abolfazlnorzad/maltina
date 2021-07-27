<?php

use Illuminate\Support\Facades\Route;


Route::post("/order/create", [\Nrz\Order\Http\Controllers\OrderController::class, 'store'])
    ->middleware('auth:api');


Route::get('/orders', [\Nrz\Order\Http\Controllers\OrderController::class, "index"])->middleware([
    "auth:api"
]);

Route::patch("/order/{order}/cancel",[\Nrz\Order\Http\Controllers\OrderController::class,"cancelOrder"])->middleware([
    "auth:api"
]);


Route::patch("/order/{order}/update",[\Nrz\Order\Http\Controllers\OrderController::class,"update"])->middleware([
    "auth:api"
]);


Route::patch("/order/{order}/update-status",[\Nrz\Order\Http\Controllers\OrderController::class,"updateStatus"])->middleware([
    "auth:api",
    'isAdmin'
]);
