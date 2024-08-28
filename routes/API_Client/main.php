<?php

use Illuminate\Support\Facades\Route;

Route::prefix('client')->group(function () {
    require __DIR__ . '/authors.php';
    require __DIR__ . '/genres.php';
    require __DIR__ . '/movies.php';
    require __DIR__ . '/tickets.php';
    require __DIR__ . '/payments.php';
});
