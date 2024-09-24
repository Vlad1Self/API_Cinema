<?php

namespace App\Http\Controllers\Payment;

use App\DTO\PaymentDTO\UpdatePaymentStatusDTO;
use App\DTO\PaymentDTO\SuccessPaymentDTO;
use App\DTO\PaymentDTO\IndexPaymentDTO;
use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\DTO\PaymentDTO\StorePaymentDTO;
use App\DTO\PaymentMethodDTO\ShowPaymentMethodDTO;
use App\DTO\PaymentMethodDTO\UpdatePaymentMethodDTO;
use App\DTO\TicketDTO\ShowTicketDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\CancelPaymentRequest;
use App\Http\Requests\Payment\CompletePaymentRequest;
use App\Http\Requests\Payment\SuccessPaymentRequest;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentMethodRequest;
use App\Http\Resources\Payment\PaymentResource;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Ticket;
use App\Repository\PaymentMethod\Factory\PaymentDriverFactory;
use App\Services\PaymentMethods\PaymentMethodService;
use App\Services\PaymentService;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

 class PaymentController extends Controller
{
    private PaymentService $paymentService;
    private TicketService $ticketService;
    private PaymentMethodService $paymentMethodService;


    public function __construct(PaymentService $paymentService, TicketService $ticketService, PaymentMethodService $paymentMethodService, PaymentDriverFactory $paymentDriverFactory)
    {
        $this->paymentService = $paymentService;
        $this->ticketService = $ticketService;
        $this->paymentMethodService = $paymentMethodService;
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

    public function processPayment(string $payment_uuid): JsonResponse
    {
        /** @var \App\Models\PaymentMethod $paymentMethod */

        $data = new ShowPaymentDTO(['payment_uuid' => $payment_uuid]);

        try {
            $payment = $this->paymentService->processPayment($data);

            $paymentMethod = $payment->paymentMethod;

            $driver = $this->paymentMethodService->getDriver($paymentMethod->driver);

            $driver->createPayment($payment_uuid);

            $redirectData = $driver->redirect($payment);

            return response()->json(['redirect_url' => $redirectData->url]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function completePayment(CompletePaymentRequest $request, string $payment_uuid): JsonResponse|RedirectResponse
    {
        $data = new ShowPaymentDTO(['payment_uuid' => $payment_uuid, $request->validated()]);

        try {
            $this->paymentService->completePaymentStatus($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return redirect()->route('successPayment', ['payment_uuid' => $payment_uuid]);
    }

    public function successPayment(string $payment_uuid): JsonResponse
    {
        return response()->json(['data' => 'Payment successful']);
    }


    public function cancelPayment(CancelPaymentRequest $request, string $payment_uuid): JsonResponse|RedirectResponse
    {
        $data = new ShowPaymentDTO(['payment_uuid' => $payment_uuid, $request->validated()]);

        try {
            $this->paymentService->cancelPaymentStatus($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return redirect()->route('failurePayment', ['payment_uuid' => $payment_uuid]);
    }

    public function failurePayment(string $payment_uuid): JsonResponse
    {
        return response()->json(['data' => 'Payment failed'], 500);
    }


    public function updatePaymentMethod(UpdatePaymentMethodRequest $request): JsonResponse|PaymentResource
    {
        $data = new UpdatePaymentMethodDTO($request->validated());

        try {
            $paymentMethod = $this->paymentService->updatePaymentMethod($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
        return new PaymentResource($paymentMethod);
    }


    public function storePayment(StorePaymentRequest $request): JsonResponse|PaymentResource
    {
        try {
            $ticket = $this->fetchTicket($request->validated('ticket_id'));

            $payment_method = $this->fetchPaymentMethod($request->validated('payment_method_id'));

            $payment = $this->dataForPayment($ticket, $payment_method, $request->validated('user_id'));

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

    private function fetchPaymentMethod(int $paymentMethodId): PaymentMethod
    {
        $data_for_payment_method = new ShowPaymentMethodDTO(['payment_method_id' => $paymentMethodId]);

        return $this->paymentMethodService->showPaymentMethod($data_for_payment_method);
    }

    private function dataForPayment(Ticket $ticket, PaymentMethod $payment_method, int $userId): Payment
    {
        $data_for_store = new StorePaymentDTO(['ticket' => $ticket, 'payment_method' => $payment_method, 'user_id' => $userId]);

        return $this->paymentService->storePayment($data_for_store);
    }



}
