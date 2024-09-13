<?php

namespace App\Http\Controllers\Ticket;

use App\DTO\TicketDTO\IndexTicketDTO;
use App\DTO\TicketDTO\ShowTicketByUUIDDTO;
use App\DTO\TicketDTO\ShowTicketDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\Payment\PaymentResource;
use App\Http\Resources\Ticket\TicketResource;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TicketController extends Controller
{
    public function __construct(private readonly TicketService $ticketService)
    {
    }

    public function indexTicket(int $page): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexTicketDTO(['page' => $page]);

        try {
            $tickets = $this->ticketService->indexTicket($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return TicketResource::collection($tickets);
    }

    public function showTicketByUUID(string $ticket_uuid): JsonResponse|TicketResource
    {
        $data = new showTicketDTO(['ticket_uuid' => $ticket_uuid]);

        try {
            $payment = $this->ticketService->showTicketByUUID($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return new TicketResource($payment);
    }
}
