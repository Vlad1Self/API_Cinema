<?php

namespace App\Contracts\Ticket;

use App\DTO\AuthorDTO\IndexAuthorDTO;
use App\DTO\TicketDTO\IndexTicketDTO;
use App\DTO\TicketDTO\ShowTicketByUUIDDTO;
use App\DTO\TicketDTO\ShowTicketDTO;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TicketContract
{
    public function indexTicket(IndexTicketDTO $data): LengthAwarePaginator;

    public function showTicketByUUID(ShowTicketDTO $data): Ticket;
}

