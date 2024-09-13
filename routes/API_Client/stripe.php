<?php
use Illuminate\Support\Facades\Route;

Route::prefix('stripe')->group(function() {
    Route::post('callback', [ \App\Http\Controllers\Stripe\StripeController::class, 'callback']);
});
