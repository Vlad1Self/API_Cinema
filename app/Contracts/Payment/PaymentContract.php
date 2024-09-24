<?php

namespace App\Contracts\Payment;

use App\DTO\PaymentDTO\ChangePaymentStatusDTO;
use App\DTO\PaymentDTO\UpdatePaymentStatusDTO;
use App\DTO\PaymentDTO\IndexPaymentDTO;
use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\DTO\PaymentDTO\StorePaymentDTO;
use App\DTO\PaymentDTO\SuccessPaymentDTO;
use App\DTO\PaymentMethodDTO\UpdatePaymentMethodDTO;
use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PaymentContract
{
    public function indexPayment(IndexPaymentDTO $data): LengthAwarePaginator;
    public function showPayment(ShowPaymentDTO $data): Payment;
    public function processPayment(ShowPaymentDTO $data): Payment;
    public function storePayment(StorePaymentDTO $data): Payment;
    public function updatePaymentMethod(UpdatePaymentMethodDTO $data): Payment;
    public function updatePaymentStatus(UpdatePaymentStatusDTO $data): Payment;

}
