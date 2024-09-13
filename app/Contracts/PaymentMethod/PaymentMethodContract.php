<?php

namespace App\Contracts\PaymentMethod;

use Illuminate\Database\Eloquent\Collection;

interface PaymentMethodContract
{
    public function index(): Collection;
}
