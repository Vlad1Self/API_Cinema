<?php

namespace App\DTO\PaymentDTO;

use App\Models\Ticket;
use Spatie\DataTransferObject\DataTransferObject;

class StorePaymentDTO extends DataTransferObject
{
    public int $user_id;
    public Ticket $ticket;
}
