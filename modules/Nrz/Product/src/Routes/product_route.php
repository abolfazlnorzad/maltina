<?php

use Illuminate\Support\Facades\Route;


// create product
Route::post('product/create', [\Nrz\Product\Http\Controllers\ProductController::class, 'store'])
    ->middleware(["auth:api", 'isAdmin'])->name('product.store');


//get all products
Route::get("/products", [\Nrz\Product\Http\Controllers\ProductController::class, 'index'])
    ->middleware('auth:api');


