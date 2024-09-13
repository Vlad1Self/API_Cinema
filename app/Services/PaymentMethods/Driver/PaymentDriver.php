<?php

namespace App\Services\PaymentMethods\Driver;

use App\DTO\PaymentDTO\RedirectPaymentDTO;
use App\Models\Payment;
use Illuminate\Http\Request;

abstract class PaymentDriver
{
    abstract  public function createPayment(string $payment_uuid): Payment;

    abstract  public function redirect(Payment $payment): RedirectPaymentDTO;
}
