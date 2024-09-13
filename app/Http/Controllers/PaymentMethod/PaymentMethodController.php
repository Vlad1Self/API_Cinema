<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethod\PaymentMethodResource;
use App\Services\PaymentMethods\PaymentMethodService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentMethodController extends Controller
{
    public function __construct(private PaymentMethodService $paymentMethodService)
    {
    }

    public function index(): JsonResponse|AnonymousResourceCollection
    {
        try {
            $methods = $this->paymentMethodService->index();
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return PaymentMethodResource::collection($methods);
    }
}
