<?php

use Illuminate\Support\Facades\Route;

Route::prefix('movies')->group(function () {
    Route::get('/', [\App\Http\Controllers\MovieController::class, 'indexMovie']);
    Route::get('/{id}', [\App\Http\Controllers\MovieController::class, 'showMovie']);
});
