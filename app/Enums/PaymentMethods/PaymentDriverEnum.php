<?php declare(strict_types=1);

namespace App\Enums\PaymentMethods;

use BenSampo\Enum\Enum;

final class PaymentDriverEnum extends Enum
{
     const test = 'test';
     const stripe = 'stripe';

    public function label(): string
    {
        return match ($this->value) {
            self::test => 'Тестовый способ оплаты',
            self::stripe => 'Stripe',
        };
    }
}
