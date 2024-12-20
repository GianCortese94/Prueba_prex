<?php

use App\Http\Controllers\GifFavoriteController;
use App\Http\Controllers\GiphyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {
    Route::get('/giphy/gifs', [GiphyController::class, 'search'])->name('giphy.search');
    Route::get('/giphy/gif/{id}', [GiphyController::class, 'show'])->name('giphy.show');
    Route::post('/gif/favorite', [GifFavoriteController::class, 'store'])->name('gif.favorite');
});
