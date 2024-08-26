<?php

namespace App\Services;

use App\Contracts\Genre\GenreContract;
use App\DTO\GenreDTO\IndexGenreDTO;
use App\Models\Genre;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

readonly class GenreService
{
    public function __construct(private GenreContract $repository)
    {
    }

    public function indexGenre(IndexGenreDTO $data): LengthAwarePaginator
    {
        try {
            return $this->repository->indexGenre($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }
}
