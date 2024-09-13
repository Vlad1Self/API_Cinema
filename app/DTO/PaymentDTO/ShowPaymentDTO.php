<?php

namespace App\DTO\PaymentDTO;

use Spatie\DataTransferObject\DataTransferObject;

class ShowPaymentDTO extends DataTransferObject
{
    public ?string $payment_uuid;

    public ?int $ticket_id;
}
