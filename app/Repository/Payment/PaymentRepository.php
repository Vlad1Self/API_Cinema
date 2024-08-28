<?php

namespace App\Repository\Payment;

use App\Contracts\Payment\PaymentContract;
use App\DTO\PaymentDTO\ChangePaymentStatusDTO;
use App\DTO\PaymentDTO\IndexPaymentDTO;
use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\DTO\PaymentDTO\StorePaymentDTO;
use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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

    public function storePayment(StorePaymentDTO $data): Payment
    {
        return Payment::query()->create([
            'user_id' => $data->user_id,
            'ticket_id' => $data->ticket->id,
            'amount' => $data->ticket->price,
            'status' => PaymentStatusEnum::created
        ]);
    }

    public function changePaymentStatus(ChangePaymentStatusDTO $data): Payment
    {
        $data->payment->status = $data->status;
        $data->payment->save();

        return $data->payment;
    }
}
