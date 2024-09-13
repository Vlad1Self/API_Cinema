<?php

namespace App\Services;

use App\Contracts\Payment\PaymentContract;
use App\DTO\PaymentDTO\ChangePaymentStatusDTO;
use App\DTO\PaymentDTO\UpdatePaymentStatusDTO;
use App\DTO\PaymentDTO\SuccessPaymentDTO;
use App\DTO\PaymentDTO\IndexPaymentDTO;
use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\DTO\PaymentDTO\StorePaymentDTO;
use App\DTO\PaymentMethodDTO\UpdatePaymentMethodDTO;
use App\Enums\Payment\PaymentStatusEnum;
use App\Enums\PaymentMethods\PaymentDriverEnum;
use App\Enums\Ticket\TicketStatusEnum;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Services\Events\PaymentFailure;
use App\Services\Events\PaymentSuccess;
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

    public function showPaymentByTicketId(ShowPaymentDTO $data): Payment
    {
        try {
            return $this->paymentRepository->showPaymentByTicketId($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function storePayment(StorePaymentDTO $data): Payment
    {
        try {
            $payment = $this->paymentRepository->storePayment($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        if (!$data->payment_method->active) {
            throw new \Exception('Payment method is not active', 400);
        }



        return $payment;
    }


    public function updatePaymentMethod(UpdatePaymentMethodDTO $data): Payment
    {
        try {
            $payment_method = $this->paymentRepository->updatePaymentMethod($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        if ($payment_method->status != PaymentStatusEnum::created) {
            throw new \Exception('Payment is not created', 404);
        }

        return $payment_method;
    }

    public function processPayment(ShowPaymentDTO $data): Payment
    {
        try {
            return $this->paymentRepository->processPayment($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function completePaymentStatus(ShowPaymentDTO $data): Payment
    {
        DB::transaction(function () use ($data, &$payment) {

            $payment = $this->paymentRepository->processPayment($data);

            if ($payment->status != PaymentStatusEnum::created) {
                throw new \Exception('Payment is not created', 404);
            }

            /*if ($payment->paymentMethod->driver != PaymentDriverEnum::test) {
                throw new \Exception('Payment method is not test method', 400);
            }*/

            try {
                $payment = $this->paymentRepository->updatePaymentStatus(new UpdatePaymentStatusDTO([
                    'payment' => $payment,
                    'status' => PaymentStatusEnum::success
                ]));
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                throw $e;
            }

            PaymentSuccess::dispatch($payment->ticket_id);

        });

        return $payment;
    }

    public function cancelPaymentStatus(ShowPaymentDTO $data): Payment
    {
        DB::transaction(function () use ($data, &$payment) {

        $payment = $this->paymentRepository->processPayment($data);

        if ($payment->status != PaymentStatusEnum::created) {
            throw new \Exception('Payment is not created', 404);
        }

        if ($payment->paymentMethod->driver != PaymentDriverEnum::test) {
            throw new \Exception('Payment method is not test method', 400);
        }

        try {
            $payment = $this->paymentRepository->updatePaymentStatus(new UpdatePaymentStatusDTO([
                'payment' => $payment,
                'status' => PaymentStatusEnum::failure
            ]));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        PaymentFailure::dispatch($payment->ticket_id);

    });

        return $payment;
    }


    /*  public function changePaymentStatus(ChangePaymentStatusDTO $data): Payment
      {
          try {
              return $this->paymentRepository->changePaymentStatus($data);
          } catch (\Exception $e) {
              Log::error($e->getMessage());
              throw $e;
          }
      }*/
}
