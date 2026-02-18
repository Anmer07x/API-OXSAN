<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login Routes
Route::get('/', [WebController::class, 'showLogin'])->name('login');
Route::post('/login', [WebController::class, 'login'])->name('login.post');

// Protected Routes
Route::middleware('auth:web')->group(function () {
    Route::get('/portal', [WebController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [WebController::class, 'logout'])->name('logout');
});
