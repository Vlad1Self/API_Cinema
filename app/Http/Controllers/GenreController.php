<?php

namespace App\Http\Controllers;

use App\Contracts\GenreContract;
use App\DTO\GenreDTO\IndexGenreDTO;
use App\Exceptions\GenreException\IndexGenreException;
use App\Http\Requests\GenreRequest\IndexGenreRequest;
use App\Http\Resources\GenreResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GenreController extends Controller
{
    public function __construct(private GenreContract $GenreContract)
    {
    }

    public function indexGenre(IndexGenreRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexGenreDTO($request->validated());

        try {
            $authors = $this->GenreContract->indexGenre($data);
        } catch (IndexGenreException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return GenreResource::collection($authors);
    }
}
