<?php

namespace App\Contracts\Ticket;

use App\DTO\AuthorDTO\IndexAuthorDTO;
use App\DTO\TicketDTO\IndexTicketDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TicketContract
{
    public function indexTicket(IndexTicketDTO $data): LengthAwarePaginator;
}

