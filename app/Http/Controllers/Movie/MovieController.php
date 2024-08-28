<?php

namespace App\Http\Controllers\Movie;

use App\Contracts\Movie\MovieContract;
use App\DTO\MovieDTO\IndexMovieDTO;
use App\DTO\MovieDTO\ShowMovieDTO;
use App\Exceptions\MovieException\FindMovieException;
use App\Exceptions\MovieException\IndexMovieException;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest\IndexMovieRequest;
use App\Http\Resources\Movie\MovieResource;
use App\Http\Resources\Ticket\TicketResource;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieController extends Controller
{
    public function __construct(private readonly MovieService $movieService)
    {
    }

    public function indexMovie(int $page): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexMovieDTO(['page' => $page]);

        try {
            $movies = $this->movieService->indexMovie($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return MovieResource::collection($movies);
    }

    public function showMovie(int $id): JsonResponse|MovieResource
    {
        $data = new ShowMovieDTO(['id' => $id]);

        try {
            $movie = $this->movieService->showMovie($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return new MovieResource($movie);
    }

    public function getTickets(int $id): JsonResponse|AnonymousResourceCollection
    {
        $data = new ShowMovieDTO(['id' => $id]);

        try {
            $tickets = $this->movieService->getTicketsForMovie($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return TicketResource::collection($tickets);
    }
}
