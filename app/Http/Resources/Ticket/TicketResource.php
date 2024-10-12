<?php

namespace App\Http\Resources\Ticket;

use App\Http\Resources\Movie\MovieResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="TicketResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="movie_id", type="integer"),
 *     @OA\Property(property="price", type="number", format="float"),
 *     @OA\Property(property="available", type="boolean"),
 *     @OA\Property(property="showtime", type="string", format="date-time")
 * )
 */
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
