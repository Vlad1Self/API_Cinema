<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/social/{driver}/redirect', [\App\Http\Controllers\Social\SocialController::class, 'redirect']);
Route::get('/social/{driver}/callback', [\App\Http\Controllers\Social\SocialController::class, 'callback']);
