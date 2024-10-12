<?php

namespace App\Http\Resources\Movie;

use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Genre\GenreResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="MovieResource",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="title", type="string"),
 *     @OA\Property(property="description", type="string"),
 *     @OA\Property(property="release_date", type="string", format="date"),
 *     @OA\Property(property="duration", type="integer"),
 *     @OA\Property(property="rating", type="number", format="float")
 * )
 */
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
