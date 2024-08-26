<?php declare(strict_types=1);

namespace App\Enums\Ticket;

use BenSampo\Enum\Enum;

final class TicketStatusEnum extends Enum
{
    const created = 'created';

    const processing = 'processing';
    const paid = 'paid';

    public function label(): string
    {
        return match ($this->value) {
            self::created => 'Свободный билет',
            self::processing => 'В процессе оплаты',
            self::paid => 'Оплачен',
        };
    }
}
