<?php

namespace App\Services;

use App\Contracts\GenreContract;
use App\DTO\GenreDTO\IndexGenreDTO;
use App\Models\Genre;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GenreService implements GenreContract
{
    public function indexGenre(IndexGenreDTO $data): LengthAwarePaginator
    {
        return Genre::paginate(10, ['*'], 'page', $data->page);
    }
}
