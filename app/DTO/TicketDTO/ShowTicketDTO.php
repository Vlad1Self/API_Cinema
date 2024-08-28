<?php

namespace App\DTO\TicketDTO;

use Spatie\DataTransferObject\DataTransferObject;

class ShowTicketDTO extends DataTransferObject
{
    public string $ticket_id;
}
