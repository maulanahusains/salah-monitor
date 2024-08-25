<?php

use App\Http\Controllers\JenisController;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    Route::post('login', [LoginController::class, 'login'])->withoutMiddleware('auth:sanctum');
    Route::post('reset-password', [LoginController::class, 'resetPassword']);
    Route::get('logout', [LoginController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('jenis')->group(function () {
        Route::get('/', [JenisController::class, 'index']);
        Route::post('/', [JenisController::class, 'store']);
        Route::get('/{id}', [JenisController::class, 'show']);
        Route::put('/{id}', [JenisController::class, 'update']);
        Route::delete('/{id}', [JenisController::class, 'destroy']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('monitor')->group(function() {
        Route::get('/', [MonitorController::class, 'index']);
        Route::post('/', [MonitorController::class, 'store']);
        Route::get('/{id}', [MonitorController::class, 'show']);
        Route::put('/{id}', [MonitorController::class, 'update']);
        Route::delete('/{id}', [MonitorController::class, 'destroy']);
    });
});
