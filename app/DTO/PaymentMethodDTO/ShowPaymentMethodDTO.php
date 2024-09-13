<?php

namespace App\DTO\PaymentMethodDTO;

use Spatie\DataTransferObject\DataTransferObject;

class ShowPaymentMethodDTO extends DataTransferObject
{
    public int $payment_method_id;
}
