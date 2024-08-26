<?php

namespace App\Repository\Author;

use App\Contracts\Author\AuthorContract;
use App\DTO\AuthorDTO\IndexAuthorDTO;
use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AuthorRepository implements AuthorContract
{

    public function indexAuthor(IndexAuthorDTO $data): LengthAwarePaginator
    {
        return Author::query()->paginate(10, ['*'], 'page', $data->page);
    }
}
