<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwitterLoginController;
use App\Http\Controllers\AppController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// ログインURL
Route::get('auth/twitter/login', [TwitterLoginController::class, 'redirectToProvider']);
// コールバックURL
Route::get('auth/twitter/callback',[TwitterLoginController::class, 'handleProviderCallback']);
// ログアウトURL
Route::get('auth/twitter/logout', [TwitterLoginController::class, 'logout']);
// TODO Auth系のルートはスーパーアドミン以外アクセス不可とする
Auth::routes();

Route::get('{any}', [AppController::class, 'index'])
    ->where('any', '.*')
    ->middleware('auth')
    ->name('home');
