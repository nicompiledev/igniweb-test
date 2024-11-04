<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Book;

class PopulateBooks extends Command
{
    protected $signature = 'books:populate';
    protected $description = 'Populate the database with books from Google Books API';

    public function handle()
    {
        $client = new Client();
        $categories = ['fiction', 'non-fiction', 'science', 'history', 'fantasy', 'mystery', 'romance'];
        $booksAdded = 0;
        $booksToInsert = []; // Arreglo para almacenar libros antes de insertarlos

        while ($booksAdded < 200) {
            // Selecciona una categoría aleatoria
            $category = $categories[array_rand($categories)];

            for ($i = 0; $i < 5; $i++) { // 5 llamadas por categoría
                $response = $client->get("https://www.googleapis.com/books/v1/volumes?q={$category}&maxResults=40&startIndex=" . ($i * 40));
                $data = json_decode($response->getBody(), true);

                foreach ($data['items'] as $item) {
                    if ($booksAdded >= 200) {
                        break 2; // Sale del bucle exterior si ya se han añadido 200 libros
                    }

                    $volumeInfo = $item['volumeInfo'];

                    // Almacena el libro en el arreglo
                    $booksToInsert[] = [
                        'title' => $volumeInfo['title'],
                        'author' => implode(', ', $volumeInfo['authors'] ?? []),
                        'description' => $volumeInfo['description'] ?? null,
                        'cover_book_url' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
                        'category' => $volumeInfo['categories'][0] ?? $category, // Usar la categoría de la API o la categoría seleccionada
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $booksAdded++;
                }
            }
        }

        // Inserta todos los libros de una sola vez
        Book::insert($booksToInsert);

        $this->info("{$booksAdded} books have been populated successfully!");
    }
}
