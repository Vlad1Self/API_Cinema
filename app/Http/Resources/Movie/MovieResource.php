<?php

namespace App\Http\Resources\Movie;

use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Genre\GenreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'authors' => AuthorResource::collection($this->authors),
            'genres' => GenreResource::collection($this->genres),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
