<?php

namespace App\Services\Listeners;

use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\DTO\PaymentDTO\UpdatePaymentStatusDTO;
use App\DTO\TicketDTO\ShowTicketDTO;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\Ticket\TicketStatusEnum;
use App\Models\Payment;
use App\Models\Ticket;
use App\Services\Events\PaymentFailure;
use App\Services\Events\PaymentSuccess;
use App\Services\PaymentService;
use App\Services\TicketService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ChangePaymentStatus implements ShouldQueue
{
    private PaymentService $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentSuccess|PaymentFailure $event): void
    {
        try {
            // Получаем платеж по ticket_id
            $payment = $this->paymentService->showPaymentByTicketId(new ShowPaymentDTO(['ticket_id' => $event->getTicketId()]));

            if (!$payment) {
                throw new \Exception('Payment not found');
            }

            // Обновляем статус билета в зависимости от типа события
            Ticket::where('id', $payment->ticket_id)
                ->update(['status' => $event instanceof PaymentSuccess ? TicketStatusEnum::paid : TicketStatusEnum::cancelled]);

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }
}
