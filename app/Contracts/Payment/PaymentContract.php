<?php

namespace App\Contracts\Payment;

use App\DTO\PaymentDTO\ChangePaymentStatusDTO;
use App\DTO\PaymentDTO\IndexPaymentDTO;
use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\DTO\PaymentDTO\StorePaymentDTO;
use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PaymentContract
{
    public function indexPayment(IndexPaymentDTO $data): LengthAwarePaginator;
    public function showPayment(ShowPaymentDTO $data): Payment;
    public function storePayment(StorePaymentDTO $data): Payment;
    public function changePaymentStatus(ChangePaymentStatusDTO $data): Payment;
}
