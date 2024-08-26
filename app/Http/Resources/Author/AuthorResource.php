<?php

namespace App\Http\Resources\Author;

use App\Http\Resources\MoviesForAuthorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            'movies' => MoviesForAuthorResource::collection($this->movies),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
