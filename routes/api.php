<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResultadosController;
use App\Http\Controllers\BridgeController;

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

// Public Authentication Routes
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

// Patient Routes (Protected by JWT)
Route::middleware('auth:api')->group(function () {
    Route::get('/resultados', [ResultadosController::class, 'index']);
});

// Internal Bridge Routes (Protected by API Key)
Route::group(['prefix' => 'internal', 'middleware' => ['auth.bridge']], function () {
    Route::post('/resultados', [BridgeController::class, 'storeBatch']);
});
