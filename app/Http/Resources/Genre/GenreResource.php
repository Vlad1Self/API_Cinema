<?php

namespace App\Http\Resources\Genre;

use App\Http\Resources\MoviesForGenreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenreResource extends JsonResource
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
            'name' => $this->name,
            'movies' => MoviesForGenreResource::collection($this->movies),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
