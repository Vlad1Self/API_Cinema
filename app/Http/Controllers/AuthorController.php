<?php

namespace App\Http\Controllers;

use App\Contracts\AuthorContract;
use App\DTO\AuthorDTO\IndexAuthorDTO;
use App\Exceptions\AuthorException\IndexAuthorException;
use App\Http\Requests\AuthorRequest\IndexAuthorRequest;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    public function __construct(private AuthorContract $AuthorContract)
    {
    }

    public function indexAuthor(IndexAuthorRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $data = new IndexAuthorDTO($request->validated());

        try {
            $authors = $this->AuthorContract->indexAuthor($data);
        } catch (IndexAuthorException $e){
            return response()->json(['error' => $e->getMessage()],  $e->getCode());
        }

        return AuthorResource::collection($authors);
    }

}
