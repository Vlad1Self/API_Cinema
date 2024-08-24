<?php

namespace App\Contracts;

use App\DTO\MovieDTO\IndexMovieDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface MovieContract
{
    public function indexMovie(IndexMovieDTO $data): LengthAwarePaginator;
    public function showMovie(int $id): Model;
}
