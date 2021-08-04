<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\TsumiageItemController;

Route::middleware('auth:api')->group(function(){
    Route::get('auth-user', [AuthUserController::class, 'show']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/items/{item}', [TsumiageItemController::class, 'show']);

    Route::patch('/items/{item}', [TsumiageItemController::class, 'update']);
});

