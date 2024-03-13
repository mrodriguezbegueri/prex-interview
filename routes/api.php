<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Gift\GiftController;
use Illuminate\Http\Request;
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


Route::prefix('gifts')->group(function () {
    Route::group([
        'middleware' => 'auth:api'
      ], function() {
          Route::get('/', [GiftController::class, 'index'])->name('gifts');
          Route::get('/{giftId}', [GiftController::class, 'show'])->name('gift');
      });
});