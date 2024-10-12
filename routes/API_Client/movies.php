<?php

use Illuminate\Support\Facades\Route;

Route::middleware('jwt.auth')->prefix('movies')->group(function () {
    Route::get('/', [\App\Http\Controllers\Movie\MovieController::class, 'indexMovie']);
    Route::get('/show/{id}', [\App\Http\Controllers\Movie\MovieController::class, 'showMovie']);
    Route::get('/tickets/{id}', [\App\Http\Controllers\Movie\MovieController::class, 'getTickets']);
});
