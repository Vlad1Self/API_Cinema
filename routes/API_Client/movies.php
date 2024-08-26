<?php

use Illuminate\Support\Facades\Route;

Route::prefix('movies')->group(function () {
    Route::get('/{page}', [\App\Http\Controllers\Movie\MovieController::class, 'indexMovie']);
    Route::get('/show/{id}', [\App\Http\Controllers\Movie\MovieController::class, 'showMovie']);
    Route::get('/{id}/tickets', [\App\Http\Controllers\Movie\MovieController::class, 'getTickets']);
});
