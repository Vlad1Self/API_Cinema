<?php

namespace App\Http\Resources\Payment;

use App\Http\Resources\Ticket\TicketResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'status' => $this->status,
            'amount' => $this->amount,
            'user' => new UserResource($this->user),
            'ticket' => new TicketResource($this->ticket),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
