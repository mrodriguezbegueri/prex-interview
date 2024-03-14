<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Gif\GifController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthController::class, 'signUp'])->name('signUp');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::group([
        'middleware' => 'auth:api'
      ], function() {
          Route::get('logout', [AuthController::class, 'logout'])->name('logout');
      });
});


Route::prefix('gifs')->group(function () {
    Route::group([
        'middleware' => 'auth:api'
      ], function() {
          Route::get('/', [GifController::class, 'index'])->name('gifs');
          Route::get('/{gifId}', [GifController::class, 'show'])->name('gif');
          Route::post('/', [GifController::class, 'create'])->name('gif');
      });
});