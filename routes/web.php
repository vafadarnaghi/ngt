<?php

use App\Http\Controllers\GamesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'register']);
Route::post('users/register', [UserController::class, 'create']);

Route::controller(GamesController::class)->group(function () {
    Route::get('games/{gameUrl}', 'index')->name('game.index');
    Route::post('games/{gameUrl}/create', 'create')->name('game.create');
    Route::delete('games/{gameUrl}/deactivate', 'deactivate')->name('game.deactivate');
    Route::post('games/{gameUrl}/play', 'play')->name('game.play');
    Route::get('games/{gameUrl}/results/{resultId}', 'result')->name('game.result');
    Route::get('games/{gameUrl}/history', 'history')->name('game.history');
});
