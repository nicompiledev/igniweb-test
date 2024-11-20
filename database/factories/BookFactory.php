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
            'title' => $this->faker->sentence(3), // Título ficticio
            'author' => $this->faker->name, // Autor ficticio
            'description' => $this->faker->paragraph, // Descripción opcional
            'cover_book_url' => $this->faker->imageUrl(640, 480, 'books', true), // URL de portada opcional
            'category' => $this->faker->word, // Categoría ficticia
        ];
    }
}
