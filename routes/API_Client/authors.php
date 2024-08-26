<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authors')->group(function () {
    Route::get('/{page}', [\App\Http\Controllers\Author\AuthorController::class, 'indexAuthor']);
});

