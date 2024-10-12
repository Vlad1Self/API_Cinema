<?php

namespace App\Http\Controllers\Movie;

use App\DTO\MovieDTO\IndexMovieDTO;
use App\DTO\MovieDTO\ShowMovieDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\Movie\MovieResource;
use App\Http\Resources\Ticket\TicketResource;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @OA\PathItem(path="/api/movies")
 */
class MovieController extends Controller
{
    public function __construct(private readonly MovieService $movieService)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/client/movies",
     *     summary="Получение списка фильмов",
     *     tags={"movies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Номер страницы",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список фильмов",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/MovieResource"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Ошибка")
     *         )
     *     )
     * )
     */
    public function indexMovie(Request $request): JsonResponse|AnonymousResourceCollection
    {
        $page = $request->query('page', 1);

        $data = new IndexMovieDTO(['page' => $page]);

        try {
            $movies = $this->movieService->indexMovie($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return MovieResource::collection($movies);
    }

    /**
     * @OA\Get(
     *     path="/api/client/movies/{id}",
     *     summary="Получение информации о фильме",
     *     tags={"movies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID фильма",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о фильме",
     *         @OA\JsonContent(ref="#/components/schemas/MovieResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Фильм не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Ошибка")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Ошибка")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/client/movies/{id}/tickets",
     *     summary="Получение билетов для фильма",
     *     tags={"movies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID фильма",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список билетов",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TicketResource"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Фильм не найден",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Ошибка")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Ошибка сервера",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", description="Ошибка")
     *         )
     *     )
     * )
     */
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
