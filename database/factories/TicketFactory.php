<?php

namespace Database\Factories;

use App\Enums\Ticket\TicketStatusEnum;
use App\Models\Movie;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;
    public function definition(): array
    {
        return [
            'movie_id' => Movie::query()->inRandomOrder()->first()->id,
            'status' => TicketStatusEnum::created,
            'price' => $this->faker->randomNumber('3', true),
            'seat' => $this->generateSeat()
        ];
    }

    private function generateSeat(): string
    {
        $letters = range('A', 'Z');
        $randomLetter = $letters[array_rand($letters)];
        $randomNumber = mt_rand(1, 99);

        return $randomLetter . $randomNumber;
    }
}
