<?php

namespace App\Repository\PaymentMethod;

use App\Contracts\PaymentMethod\PaymentMethodContract;
use App\DTO\PaymentMethodDTO\ShowPaymentMethodDTO;
use App\DTO\PaymentMethodDTO\UpdatePaymentMethodDTO;
use App\Models\PaymentMethod;
use App\Repository\PaymentMethod\Factory\PaymentDriverFactory;
use App\Services\PaymentMethods\Driver\PaymentDriver;
use Illuminate\Database\Eloquent\Collection;

class PaymentMethodRepository implements PaymentMethodContract
{
    public function index(): Collection
    {
        return PaymentMethod::query()->get();
    }

    public function showPaymentMethod(ShowPaymentMethodDTO $data): PaymentMethod
    {
        return PaymentMethod::query()->findOrFail($data->payment_method_id);
    }

    public function getDriver(string $paymentDriver): PaymentDriver
    {
        return (new PaymentDriverFactory())->make($paymentDriver);
    }
}
