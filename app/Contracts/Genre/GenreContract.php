<?php

namespace App\Contracts\Genre;

use App\DTO\GenreDTO\IndexGenreDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface GenreContract
{
    public function indexGenre(IndexGenreDTO $data): LengthAwarePaginator;
}
