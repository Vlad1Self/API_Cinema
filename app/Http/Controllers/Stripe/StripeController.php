<?php

namespace App\Http\Controllers\Stripe;

use App\DTO\PaymentDTO\ShowPaymentDTO;
use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use Illuminate\Http\JsonResponse;
use Stripe\Exception\UnexpectedValueException;

class StripeController extends Controller
{
    public function __construct(private PaymentService $service)
    {
    }
    public function callback(Request $request): JsonResponse
    {
        Stripe::setApiKey(config()->get('services.stripe.secret_key'));

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('stripe-signature'),
                config()->get('services.stripe.webhook_secret')
            );

        } catch(SignatureVerificationException|UnexpectedValueException $e) {
            Log::error($e->getMessage());
            return response()->json();
        }

        $paymentUuid = $event->data->object->metadata->payment_uuid;

        match ($event->type) {
            'payment_intent.succeeded' => $this->service->completePaymentStatus(new ShowPaymentDTO(['payment_uuid' => $paymentUuid])),
            'payment_intent.payment_failed' => $this->service->cancelPaymentStatus(new ShowPaymentDTO(['payment_uuid' => $paymentUuid])),
            default => Log::error('Unhandled event type: ' . $event->type),
        };

        return response()->json(['status' => 'success'], 200);
    }

}
