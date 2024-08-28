<?php

namespace App\DTO\PaymentDTO;

use App\Models\Payment;
use Spatie\DataTransferObject\DataTransferObject;

class ChangePaymentStatusDTO extends DataTransferObject
{
    public Payment $payment;
    public string $status;
}
