<?php

namespace App\Services;

use App\Contracts\Ticket\TicketContract;
use App\DTO\TicketDTO\IndexTicketDTO;
use App\DTO\TicketDTO\ShowTicketDTO;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

readonly class TicketService
{
    public function __construct(private TicketContract $tickerRepository)
    {
    }

    public function indexTicket(IndexTicketDTO $data): LengthAwarePaginator
    {
        try {
            return $this->tickerRepository->indexTicket($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }

    public function showTicket(ShowTicketDTO $data): Ticket
    {
        try {
            return $this->tickerRepository->showTicket($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
