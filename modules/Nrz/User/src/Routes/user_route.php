<?php

use Illuminate\Support\Facades\Route;

Route::post('/login',[\Nrz\User\Http\Controller\Auth\LoginController::class,'login']);
Route::post('/register',[\Nrz\User\Http\Controller\Auth\RegisterController::class,"register"]);
