<?php

namespace App\Services;

use App\Contracts\Ticket\TicketContract;
use App\DTO\TicketDTO\IndexTicketDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

readonly class TicketService
{
    public function __construct(private TicketContract $repository)
    {
    }

    public function indexTicket(IndexTicketDTO $data): LengthAwarePaginator
    {
        try {
            return $this->repository->indexTicket($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }
}
