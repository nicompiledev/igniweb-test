<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Book;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Generates a fake user
            'book_id' => Book::factory(), // Generates a fake book
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'), // Fake start date
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month'), // Fake end date
        ];
    }
}

