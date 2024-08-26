<?php

namespace App\Http\Controllers\Genre;

use App\Contracts\Genre\GenreContract;
use App\DTO\GenreDTO\IndexGenreDTO;
use App\Exceptions\GenreException\IndexGenreException;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest\IndexGenreRequest;
use App\Http\Resources\Genre\GenreResource;
use App\Services\GenreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GenreController extends Controller
{
    public function __construct(private readonly GenreService $service)
    {
    }

    public function indexGenre(int $page): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexGenreDTO(['page' => $page]);

        try {
            $genres = $this->service->indexGenre($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return GenreResource::collection($genres);
    }
}
