<?php

namespace App\Repository\Movie;

use App\Contracts\Movie\MovieContract;
use App\DTO\MovieDTO\ShowMovieDTO;
use App\Models\Movie;
use App\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\DTO\MovieDTO\IndexMovieDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MovieRepository implements MovieContract
{
    public function indexMovie(IndexMovieDTO $data): LengthAwarePaginator
    {
        return Movie::query()->paginate(10, ['*'], 'page', $data->page);
    }

    public function showMovie(ShowMovieDTO $data): Movie
    {
        return Movie::query()->findOrFail($data->id);
    }

    public function getTicketsForMovie(ShowMovieDTO $data): Collection
    {
        return Ticket::query()->where('movie_id', $data->id)->get();
    }
}
