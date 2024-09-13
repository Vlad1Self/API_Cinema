<?php

namespace Database\Factories;

use App\Enums\Payment\PaymentStatusEnum;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'ticket_id' => Ticket::query()->inRandomOrder()->first()->id,
            'amount' => $this->faker->numberBetween(100, 1000),
            'status' => PaymentStatusEnum::created,

            'driver_payment_id' => $this->faker->uuid,
            'payment_method_id' => PaymentMethod::query()->inRandomOrder()->first()->id,
            'payable_type' => 'Ticket',
            'payable_id' => Ticket::query()->inRandomOrder()->first()->id
        ];
    }
}
