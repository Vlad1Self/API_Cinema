<?php

namespace App\Repository\Payment;

use App\Contracts\Payment\PaymentContract;
use App\DTO\PaymentDTO\ChangePaymentStatusDTO;
use App\DTO\PaymentDTO\UpdatePaymentStatusDTO;
use App\DTO\PaymentDTO\IndexPaymentDTO;
use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\DTO\PaymentDTO\StorePaymentDTO;
use App\DTO\PaymentMethodDTO\UpdatePaymentMethodDTO;
use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Services\Events\PaymentSuccess;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property Payment $payment
 */
class PaymentRepository implements PaymentContract
{

    public function indexPayment(IndexPaymentDTO $data): LengthAwarePaginator
    {
        return Payment::query()->paginate(10, ['*'], 'page', $data->page);
    }

    public function showPayment(ShowPaymentDTO $data): Payment
    {
        return Payment::query()->where('uuid', $data->payment_uuid)->first();
    }

    public function showPaymentByTicketId(ShowPaymentDTO $data): Payment
    {
        return Payment::query()->where('ticket_id', $data->ticket_id)->first();
    }

    public function storePayment(StorePaymentDTO $data): Payment
    {
        return Payment::query()->create([
            'user_id' => $data->user_id,
            'ticket_id' => $data->ticket->id,
            'amount' => $data->ticket->price,
            'status' => PaymentStatusEnum::created,
            'payable_type' => $data->ticket->getMorphClass(),
            'payable_id' => $data->ticket->id,
            'payment_method_id' => $data->payment_method->id,
            'driver_payment_id' => null,
        ]);
    }

    public function updatePaymentMethod(UpdatePaymentMethodDTO $data): Payment
    {
        $payment = Payment::findOrFail($data->id);
        $payment->payment_method_id = $data->payment_method_id;
        $payment->save();
        return $payment;
    }

    public function processPayment(ShowPaymentDTO $data): Payment
    {
        return Payment::with('paymentMethod')->where('uuid', $data->payment_uuid)->firstOrFail();
    }


    public function updatePaymentStatus(UpdatePaymentStatusDTO $data): Payment
    {
        $data->payment->status = $data->status;
        $data->payment->save();
        return $data->payment;
    }


    /* public function changePaymentStatus(ChangePaymentStatusDTO $data): Payment
     {
         $data->payment->status = $data->status;
         $data->payment->save();

         return $data->payment;
     }*/
}
