<?php

namespace App\Services\Listener;

use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\Enums\Payment\PaymentStatusEnum;
use App\Services\Event\PaymentFailure;
use App\Services\Event\PaymentSuccess;
use App\Services\PaymentService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ChangePaymentStatus implements ShouldQueue
{
    private PaymentService $service;
    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     */
    public function handle(PaymentSuccess|PaymentFailure $event): void
    {
        $payment = null;

        try {
            $payment = $this->service->showPayment(new ShowPaymentDTO(['payment_uuid' => $event->getPaymentUuid()]));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

        try {
            $payment->update([
                'status' => $event instanceof PaymentSuccess ? PaymentStatusEnum::success : PaymentStatusEnum::failure
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
