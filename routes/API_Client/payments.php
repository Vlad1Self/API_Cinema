<?php

use Illuminate\Support\Facades\Route;

Route::prefix('payments')->group(function () {
    Route::get('/{page}', [\App\Http\Controllers\Payment\PaymentController::class, 'indexPayment']);
    Route::get('/show/{payment_uuid}', [\App\Http\Controllers\Payment\PaymentController::class, 'showPayment']);
    Route::post('/store', [\App\Http\Controllers\Payment\PaymentController::class, 'storePayment']);
});
