<?php

namespace App\Repository\Ticket;

use App\Contracts\Author\AuthorContract;
use App\Contracts\Ticket\TicketContract;
use App\DTO\MovieDTO\ShowMovieDTO;
use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\DTO\TicketDTO\IndexTicketDTO;
use App\DTO\TicketDTO\ShowTicketDTO;
use App\Models\Author;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository implements TicketContract
{

    public function indexTicket(IndexTicketDTO $data): LengthAwarePaginator
    {
        return Ticket::query()->paginate(10, ['*'], 'page', $data->page);
    }

    public function showTicketByUUID(ShowTicketDTO $data): Ticket
    {
        return Ticket::query()->where('uuid', $data->ticket_uuid)->first();
    }

    public function showTicket(ShowTicketDTO $data): Ticket
    {
        return Ticket::query()->findOrFail($data->ticket_id);
    }


}
