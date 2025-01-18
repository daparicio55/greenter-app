<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 */

 Route::post('/register',[RegisterController::class,'store']);

 Route::post('login', [AuthController::class,'login']);
 Route::post('logout',[AuthController::class,'logout'])
 ->middleware('auth:api');
 Route::post('refresh',[AuthController::class,'refresh'])
 ->middleware('auth:api');
 Route::post('me',[AuthController::class,'me'])
 ->middleware('auth:api');