<?php

namespace App\Services;

use App\Contracts\Movie\MovieContract;
use App\DTO\MovieDTO\IndexMovieDTO;
use App\DTO\MovieDTO\ShowMovieDTO;
use App\Models\Movie;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

readonly class MovieService
{
    public function __construct(private MovieContract $movieRepository)
    {
    }

    public function indexMovie(IndexMovieDTO $data): LengthAwarePaginator
    {
        try {
            return $this->movieRepository->indexMovie($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function showMovie(ShowMovieDTO $data): Movie
    {
        try {
            return $this->movieRepository->showMovie($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function getTicketsForMovie(ShowMovieDTO $data): Collection
    {
        try {
            return $this->repository->getTicketsForMovie($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
