<?php

use Illuminate\Support\Facades\Route;

Route::prefix('payments')->group(function () {
    Route::get('/{page}', [\App\Http\Controllers\Payment\PaymentController::class, 'indexPayment']);
    Route::get('/show/{payment_uuid}', [\App\Http\Controllers\Payment\PaymentController::class, 'showPayment']);
    Route::post('/store', [\App\Http\Controllers\Payment\PaymentController::class, 'storePayment']);
    Route::put('/update', [\App\Http\Controllers\Payment\PaymentController::class, 'updatePaymentMethod']);


    Route::get('/process/{payment_uuid}', [\App\Http\Controllers\Payment\PaymentController::class, 'processPayment']);
    Route::post('/complete/{payment_uuid}', [\App\Http\Controllers\Payment\PaymentController::class, 'completePayment']);
    Route::get('/success/{payment_uuid}', [\App\Http\Controllers\Payment\PaymentController::class, 'successPayment'])->name('successPayment');

    Route::post('/cancel/{payment_uuid}', [\App\Http\Controllers\Payment\PaymentController::class, 'cancelPayment']);
    Route::get('/failure/{payment_uuid}', [\App\Http\Controllers\Payment\PaymentController::class, 'failurePayment'])->name('failurePayment');
});
