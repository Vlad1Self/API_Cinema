<?php

namespace App\Services;

use App\Contracts\Payment\PaymentContract;
use App\DTO\PaymentDTO\ChangePaymentStatusDTO;
use App\DTO\PaymentDTO\IndexPaymentDTO;
use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\DTO\PaymentDTO\StorePaymentDTO;
use App\Enums\Ticket\TicketStatusEnum;
use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

readonly class PaymentService
{
    public function __construct(private PaymentContract $paymentRepository)
    {
    }

    public function indexPayment(IndexPaymentDTO $data): LengthAwarePaginator
    {
        try {
            return $this->paymentRepository->indexPayment($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function showPayment(ShowPaymentDTO $data): Payment
    {
        try {
            return $this->paymentRepository->showPayment($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function storePayment(StorePaymentDTO $data): Payment
    {
        if ($data->ticket->status != TicketStatusEnum::created) {
            throw new \Exception('Ticket is already reserved');
        }

        $payment = null;

        DB::transaction(function() use ($data, &$payment) {
            try {
                $payment =  $this->paymentRepository->storePayment($data);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                throw $e;
            }
        });

        return $payment;
    }

    public function changePaymentStatus(ChangePaymentStatusDTO $data): Payment
    {
        try {
            return $this->paymentRepository->changePaymentStatus($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
