<?php

use Illuminate\Support\Facades\Route;

Route::prefix('payment_methods')->group(function() {
    Route::get('/', [\App\Http\Controllers\PaymentMethod\PaymentMethodController::class, 'index']);
});
