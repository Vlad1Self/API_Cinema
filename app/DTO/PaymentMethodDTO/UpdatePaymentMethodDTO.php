<?php

namespace App\DTO\PaymentMethodDTO;

use Spatie\DataTransferObject\DataTransferObject;

class UpdatePaymentMethodDTO extends DataTransferObject
{
    public int $id;
    public int $payment_method_id;
}
