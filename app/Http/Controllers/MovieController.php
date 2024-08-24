<?php

namespace App\Http\Controllers;

use App\Contracts\MovieContract;
use App\DTO\MovieDTO\IndexMovieDTO;
use App\Exceptions\MovieException\FindMovieException;
use App\Exceptions\MovieException\IndexMovieException;
use App\Http\Requests\MovieRequest\IndexMovieRequest;
use App\Http\Resources\MovieResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieController extends Controller
{
    public function __construct(private MovieContract $MovieContract)
    {
    }

    public function indexMovie(IndexMovieRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexMovieDTO($request->validated());

        try {
            $movies = $this->MovieContract->indexMovie($data);
        } catch (IndexMovieException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return MovieResource::collection($movies);
    }

    public function showMovie(int $id): JsonResponse|MovieResource
    {
        try {
            $movies = $this->MovieContract->showMovie($id);
        } catch (FindMovieException $e) {
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return new MovieResource($movies);
    }
}
