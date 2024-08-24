<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authors')->group(function () {
    Route::get('/', [\App\Http\Controllers\AuthorController::class, 'indexAuthor']);
});

