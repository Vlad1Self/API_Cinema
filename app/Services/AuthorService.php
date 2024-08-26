<?php

namespace App\Services;

use App\Contracts\Author\AuthorContract;
use App\DTO\AuthorDTO\IndexAuthorDTO;
use App\Exceptions\AuthorException\IndexAuthorException;
use App\Http\Requests\AuthorRequest\IndexAuthorRequest;
use App\Http\Resources\Author\AuthorResource;
use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

readonly class AuthorService
{
    public function __construct(private AuthorContract $repository)
    {
    }

    public function indexAuthor(IndexAuthorDTO $data): LengthAwarePaginator
    {
        try {
            return $this->repository->indexAuthor($data);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }
}
