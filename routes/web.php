<?php

use App\Http\Controllers\GamesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'register']);
Route::post('users/register', [UserController::class, 'create']);

Route::controller(GamesController::class)->group(function () {
    Route::get('games/{accessToken}', 'index')->name('game.index');
    Route::post('games/{accessToken}/create', 'create')->name('game.create');
    Route::delete('games/{accessToken}/deactivate', 'deactivate')->name('game.deactivate');
    Route::post('games/{accessToken}/play', 'play')->name('game.play');
    Route::get('games/{accessToken}/results/{resultId}', 'result')->name('game.result');
    Route::get('games/{accessToken}/history', 'history')->name('game.history');
});
