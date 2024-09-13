<?php

namespace Database\Seeders;

use App\Enums\PaymentMethods\PaymentDriverEnum;
use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->create_testRUB_payment();
        $this->create_testUSD_payment();
        $this->create_stripe_payment();
    }

    private function create_testRUB_payment(): void
    {
        PaymentMethod::query()->firstOrCreate([
            'name' => 'testRUB',
        ], [
            'driver' => PaymentDriverEnum::test,
        ]);
    }

    private function create_testUSD_payment(): void
    {
        PaymentMethod::query()->firstOrCreate([
            'name' => 'testUSD',
        ], [
            'driver' => PaymentDriverEnum::test,
        ]);
    }

    private function create_stripe_payment(): void
    {
        PaymentMethod::query()->firstOrCreate([
            'name' => 'stripe',
        ], [
            'driver' => PaymentDriverEnum::stripe,
        ]);
    }
}
