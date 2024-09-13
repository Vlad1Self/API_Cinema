<?php

namespace App\Services\PaymentMethods;

use App\Contracts\PaymentMethod\PaymentMethodContract;
use App\DTO\PaymentMethodDTO\ShowPaymentMethodDTO;
use App\Models\PaymentMethod;
use App\Services\PaymentMethods\Driver\PaymentDriver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

readonly class PaymentMethodService
{

    public function __construct(private PaymentMethodContract $paymentMethodRepository)
    {
    }

    public function index(): Collection
    {
        try {
            return $this->paymentMethodRepository->index();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function showPaymentMethod(ShowPaymentMethodDTO $data): PaymentMethod
    {
        try {
            return $this->paymentMethodRepository->showPaymentMethod($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function getDriver(string $paymentDriver): PaymentDriver
    {
        try {
            return $this->paymentMethodRepository->getDriver($paymentDriver);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
