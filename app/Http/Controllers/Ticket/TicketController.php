<?php

namespace App\Http\Controllers\Ticket;

use App\DTO\TicketDTO\IndexTicketDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\Ticket\TicketResource;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TicketController extends Controller
{
    public function __construct(private readonly TicketService $service)
    {
    }

    public function indexTicket(int $page): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexTicketDTO(['page' => $page]);

        try {
            $tickets = $this->service->indexTicket($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return TicketResource::collection($tickets);
    }
}
