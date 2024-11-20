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
            'user_id' => User::factory(), // Genera un usuario ficticio
            'book_id' => Book::factory(), // Genera un libro ficticio
            'start_date' => $this->faker->dateTimeBetween('-1 month', 'now'), // Fecha de inicio ficticia
            'end_date' => $this->faker->dateTimeBetween('now', '+1 month'), // Fecha de fin ficticia
        ];
    }
}
