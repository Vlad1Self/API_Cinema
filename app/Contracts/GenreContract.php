<?php

namespace App\Contracts;

use App\DTO\GenreDTO\IndexGenreDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GenreContract
{
    public function indexGenre(IndexGenreDTO $data): LengthAwarePaginator;
}
