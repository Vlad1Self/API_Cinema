<?php declare(strict_types=1);

namespace App\Enums\Payment;

use BenSampo\Enum\Enum;

final class PaymentStatusEnum extends Enum
{
    const created = 'created';
    const pending = 'pending';
    const success = 'success';
    const failure = 'failure';

    public function label(): string
    {
        return match ($this->value) {
            self::created => 'Платеж создан',
            self::pending => 'В процессе оплаты',
            self::success => 'Платеж оплачен',
            self::failure => 'Платеж отменен',
        };
    }
}
