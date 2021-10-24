<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\TodoController;
use App\Http\Controllers\Api\User\UserController;

Route::group(['middleware' => 'api'], function() {

    Route::group(['prefix' => 'auth'], function() {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('profile', UserController::class);
    });

    Route::apiResource('todos', TodoController::class);
 
});