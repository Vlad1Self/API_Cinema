<?php

namespace App\Repository\PaymentMethod\Factory;

use App\Enums\PaymentMethods\PaymentDriverEnum;
use App\Services\PaymentMethods\Driver\PaymentDriver;
use App\Services\PaymentMethods\Driver\StripeDriver;
use App\Services\PaymentMethods\Driver\TestDriver;
use InvalidArgumentException;

class PaymentDriverFactory
{
    public function make(string $paymentDriver): PaymentDriver
    {
        return match ($paymentDriver) {
            PaymentDriverEnum::test => new TestDriver(),
            PaymentDriverEnum::stripe => new StripeDriver(),

            default => throw new InvalidArgumentException('Invalid payment method driver'),
        };
    }
}
