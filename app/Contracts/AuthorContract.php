<?php

namespace App\Contracts;

use App\DTO\AuthorDTO\IndexAuthorDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AuthorContract
{
    public function indexAuthor(IndexAuthorDTO $data): LengthAwarePaginator;
}
