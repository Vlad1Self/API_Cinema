<?php

namespace App\Services\PaymentMethods\Driver;

use App\Models\Payment;
use App\DTO\PaymentDTO\RedirectPaymentDTO;
use Illuminate\Support\Env;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeDriver extends PaymentDriver
{

    public function createPayment(string $payment_uuid): Payment
    {
        Stripe::setApiKey(config('services.stripe.secret_key'));

        /** @var Payment $payment */
        $payment = Payment::query()->where('uuid', $payment_uuid)->first();

        $checkout_session = Session::create([
            'mode' => 'payment',
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'unit_amount' => $payment->amount * 100,
                    'currency' => 'rub',
                    'product_data' => [
                        'name' => ucfirst($payment->payable_type) . ' for site ' . Env::get('APP_NAME'),
                    ]
                ]
            ]],
            'payment_intent_data' => ['metadata' => ['payment_uuid' => $payment_uuid]],
            'success_url' => url('api/client/payments/success/' . $payment_uuid),
            'cancel_url' => url('api/client/payments/failure/' . $payment_uuid),
        ]);

        $payment->driver_payment_id = $checkout_session->id;
        $payment->save();

        session()->put('redirect_url', $checkout_session->url);

        return $payment;
    }

    public function redirect(Payment $payment): RedirectPaymentDTO
    {
        $url = session()->get('redirect_url');

        return new RedirectPaymentDTO(['url' => $url, 'driver_payment_uuid' => $payment->driver_payment_id, 'payment_uuid' => $payment->uuid]);
    }
}
