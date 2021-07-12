<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/stats/{id?}', [LinkController::class, 'stats'])->name('links.stats');
Route::get('/{id}', [LinkController::class, 'show'])->name('links.redirect');
Route::delete('/urls/{id}', [LinkController::class, 'destroy'])->name('links.destroy');

Route::group(['prefix' => '/users'], function () {
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::delete('/{user_id}/', [UserController::class, 'destroy'])->name('links.destroy');
    Route::post('/{user_id}/urls', [LinkController::class, 'store'])->name('links.store');
    Route::get('/{user_id}/stats', [UserController::class, 'stats'])->name('users.stats');
});

