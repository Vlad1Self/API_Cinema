<?php

namespace App\Services;

use App\Contracts\MovieContract;
use App\DTO\MovieDTO\IndexMovieDTO;
use App\Models\Movie;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class MovieService implements MovieContract
{
    public function indexMovie(IndexMovieDTO $data): LengthAwarePaginator
    {
        return Movie::with(['authors', 'genres'])
            ->paginate($data->per_page, ['*'], 'page', $data->page);
    }

    public function showMovie(int $id): Model
    {
        return Movie::query()->findOrFail($id);
    }
}
