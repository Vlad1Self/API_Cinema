<?php

namespace App\Repository\Ticket;

use App\Contracts\Author\AuthorContract;
use App\Contracts\Ticket\TicketContract;
use App\DTO\TicketDTO\IndexTicketDTO;
use App\Models\Author;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TicketRepository implements TicketContract
{

    public function indexTicket(IndexTicketDTO $data): LengthAwarePaginator
    {
        return Ticket::query()->paginate(10, ['*'], 'page', $data->page);
    }
}
