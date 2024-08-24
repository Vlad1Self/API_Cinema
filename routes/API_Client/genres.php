<?php

use Illuminate\Support\Facades\Route;

Route::prefix('genres')->group(function () {
    Route::get('/', [\App\Http\Controllers\GenreController::class, 'indexGenre']);
});
