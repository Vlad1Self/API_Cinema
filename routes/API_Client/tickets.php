<?php

use Illuminate\Support\Facades\Route;

Route::prefix('tickets')->group(function () {
    Route::get('/{page}', [\App\Http\Controllers\Ticket\TicketController::class, 'indexTicket']);
    Route::get('/show/{ticket_uuid}', [\App\Http\Controllers\Ticket\TicketController::class, 'showTicketByUUID']);
});

