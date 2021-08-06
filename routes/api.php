<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\TsumiageItemController;
use App\Http\Controllers\TsumiageController;
use App\Http\Controllers\UserTsumiageController;

Route::middleware('auth:api')->group(function(){
    Route::get('auth-user', [AuthUserController::class, 'show']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/items/{item}', [TsumiageItemController::class, 'show']);
    Route::patch('/items/{item}', [TsumiageItemController::class, 'update']);
    Route::post('/tsumiage', [TsumiageController::class, 'store']);
    Route::patch('/tsumiage/{tsumiage}', [TsumiageController::class, 'update']);
    Route::post('/user-tsumiage', [UserTsumiageController::class, 'show']);
});

