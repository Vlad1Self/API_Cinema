<?php

namespace App\Http\Resources\Ticket;

use App\Http\Resources\Movie\MovieResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'price' => $this->price,
            'seat' => $this->seat,
            'status' => $this->status->label(),
            'movie' => new MovieResource($this->movie)
        ];
    }
}
