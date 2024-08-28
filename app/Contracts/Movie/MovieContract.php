<?php

namespace App\Contracts\Movie;

use App\DTO\MovieDTO\IndexMovieDTO;
use App\DTO\MovieDTO\ShowMovieDTO;
use App\Models\Movie;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface MovieContract
{
    public function indexMovie(IndexMovieDTO $data): LengthAwarePaginator;
    public function showMovie(ShowMovieDTO $data): Movie;
    public function getTicketsForMovie(ShowMovieDTO $data): Collection;
}
