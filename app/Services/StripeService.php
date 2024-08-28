<?php

namespace App\Services;


use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Payment;
use App\Services\Event\PaymentFailure;
use App\Services\Event\PaymentSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;
use Stripe\Stripe;
use Stripe\Webhook;

readonly class StripeService
{
    public function createSession(Payment $payment): Session
    {
        if ($payment->status != PaymentStatusEnum::created) {
            throw new \Exception('Payment is already paying');
        }

        \Stripe\Stripe::setApiKey(config()->get('services.stripe.secret_key'));

        return Session::create([
            'mode' => 'payment',
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'unit_amount' => $payment->amount * 100,
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Ticket',
                    ]
                ]
            ]],
            'payment_intent_data' => ['metadata' => ['payment_uuid' => $payment->uuid, 'customer_email' => $payment->user->email]],
            'success_url' => url('api/payments/success/' . $payment->uuid),
            'cancel_url' => url('api/payments/failure/' . $payment->uuid),

        ]);
    }

    public function callback(Request $request): void
    {
        Stripe::setApiKey(config()->get('services.stripe.secret_key'));

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('stripe-signature'),
                config()->get('services.stripe.webhook_secret')
            );

        } catch (SignatureVerificationException|UnexpectedValueException $e) {
            Log::error($e->getMessage());
            throw $e;
        }

        $payment_uuid = $event->data->object->metadata->payment_uuid;

        $customer_email = $event->data->object->metadata->customer_email;

        match ($event->type) {
            'payment_intent.succeeded' => PaymentSuccess::dispatch($payment_uuid, $customer_email),
            'payment_intent.cancelled' => PaymentFailure::dispatch($payment_uuid),
            default => Log::error('Unknown event type ' . $event->type),
        };

    }
}
