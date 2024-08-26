<?php

namespace App\Http\Controllers\Author;

use App\DTO\AuthorDTO\IndexAuthorDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\Author\AuthorResource;
use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    public function __construct(private readonly AuthorService $service)
    {
    }

    public function indexAuthor(int $page): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexAuthorDTO(['page' => $page]);

        try {
            $authors = $this->service->indexAuthor($data);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return AuthorResource::collection($authors);
    }
}
