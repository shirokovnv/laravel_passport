<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'auth'], function() {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/logout', [AuthController::class, 'logout']);
    });

    Route::group(['prefix' => 'tokens'], function() {
        Route::post('/create', [TokenController::class, 'createAccessToken']);

        Route::group(['middleware' => 'auth:api'], function(){
            Route::get('/revoke', [TokenController::class, 'revokeToken']);
            Route::get('/revoke_all', [TokenController::class, 'revokeAllTokens']);
        });
    });
});

