<?php

namespace App\Services\Event;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $payment_uuid;
    private string $customer_email;
    public function __construct(string $payment_uuid, string $customer_email)
    {
        $this->payment_uuid = $payment_uuid;
        $this->customer_email = $customer_email;
    }

    public function getPaymentUuid(): string
    {
        return $this->payment_uuid;
    }

    public function getCustomerEmail(): string
    {
        return $this->customer_email;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
