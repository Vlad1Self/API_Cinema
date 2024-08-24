<?php

namespace App\Services;

use App\Contracts\AuthorContract;
use App\DTO\AuthorDTO\IndexAuthorDTO;
use App\Exceptions\AuthorException\IndexAuthorException;
use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class AuthorService implements AuthorContract
{
    public function indexAuthor(IndexAuthorDTO $data): LengthAwarePaginator
    {
        return Author::paginate(10, ['*'], 'page', $data->page);
    }
}
