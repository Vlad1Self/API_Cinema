<?php

namespace App\Http\Controllers\Payment;

use App\DTO\PaymentDTO\IndexPaymentDTO;
use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\DTO\PaymentDTO\StorePaymentDTO;
use App\DTO\TicketDTO\ShowTicketDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Resources\Payment\PaymentResource;
use App\Models\Payment;
use App\Models\Ticket;
use App\Services\PaymentService;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    private PaymentService $paymentService;
    private TicketService $ticketService;



    public function __construct(PaymentService $paymentService, TicketService $ticketService)
    {
        $this->paymentService = $paymentService;
        $this->ticketService = $ticketService;

    }

    public function indexPayment(int $page): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexPaymentDTO(['page' => $page]);

        try {
            $payments = $this->paymentService->indexPayment($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return PaymentResource::collection($payments);
    }

    public function showPayment(string $payment_uuid): JsonResponse|PaymentResource
    {
        $data = new ShowPaymentDTO(['payment_uuid' => $payment_uuid]);

        try {
            $payment = $this->paymentService->showPayment($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return new PaymentResource($payment);
    }

    public function storePayment(StorePaymentRequest $request): JsonResponse|PaymentResource
    {
        try {
            $ticket = $this->fetchTicket($request->validated('ticket_id'));

            $payment = $this->processPayment($ticket, $request->validated('user_id'));

            return new PaymentResource($payment);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    private function fetchTicket(int $ticketId): Ticket
    {
        $data_for_ticket = new ShowTicketDTO(['ticket_id' => $ticketId]);

        return $this->ticketService->showTicket($data_for_ticket);
    }

    private function processPayment(Ticket $ticket, int $userId): Payment
    {
        $data_for_store = new StorePaymentDTO(['ticket' => $ticket, 'user_id' => $userId]);

        return $this->paymentService->storePayment($data_for_store);
    }
}
