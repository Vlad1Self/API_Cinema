<?php

namespace App\Services\Event;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentFailure
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $payment_uuid;
    public function __construct(string $payment_uuid)
    {
        $this->payment_uuid = $payment_uuid;
    }

    public function getPaymentUuid(): string
    {
        return $this->payment_uuid;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
