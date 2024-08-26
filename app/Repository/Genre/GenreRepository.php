<?php

namespace App\Repository\Genre;

use App\Contracts\Genre\GenreContract;
use App\DTO\GenreDTO\IndexGenreDTO;
use App\Models\Genre;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GenreRepository implements GenreContract
{

    public function indexGenre(IndexGenreDTO $data): LengthAwarePaginator
    {
        return Genre::query()->paginate(10, ['*'], 'page', $data->page);
    }
}
