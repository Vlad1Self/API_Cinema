<?php

namespace App\Services;

use App\Contracts\Ticket\TicketContract;
use App\DTO\TicketDTO\IndexTicketDTO;
use App\DTO\TicketDTO\ShowTicketByUUIDDTO;
use App\DTO\TicketDTO\ShowTicketDTO;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

readonly class TicketService
{
    public function __construct(private TicketContract $ticketRepository)
    {
    }

    public function indexTicket(IndexTicketDTO $data): LengthAwarePaginator
    {
        try {
            return $this->ticketRepository->indexTicket($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function showTicketByUUID(ShowTicketDTO $data): Ticket
    {
        try {
            return $this->ticketRepository->showTicketByUUID($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function showTicket(ShowTicketDTO $data): Ticket
    {
        try {
            return $this->ticketRepository->showTicket($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
