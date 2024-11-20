<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), // Fictional title
            'author' => $this->faker->name, // Fictional author
            'description' => $this->faker->paragraph, // Optional description
            'cover_book_url' => $this->faker->imageUrl(640, 480, 'books', true), // Optional cover URL
            'category' => $this->faker->word, // Fictional category
        ];
    }
}
