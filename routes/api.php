<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\TsumiageItemsController;

Route::middleware('auth:api')->group(function(){
    Route::get('auth-user', [AuthUserController::class, 'show']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('/items/{item}', [TsumiageItemsController::class, 'update']);
});