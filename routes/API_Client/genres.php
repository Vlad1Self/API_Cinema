<?php

use Illuminate\Support\Facades\Route;

Route::prefix('genres')->group(function () {
    Route::get('/{page}', [\App\Http\Controllers\Genre\GenreController::class, 'indexGenre']);
});
