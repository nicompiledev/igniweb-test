<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Book;

/**
 * PopulateBooks Command: Populate database with books from Google Books API.
 */
class PopulateBooks extends Command
{
    /**
     * Command signature.
     *
     * @var string
     */
    protected $signature = 'books:populate';

    /**
     * Command description.
     *
     * @var string
     */
    protected $description = 'Populate the database with books from Google Books API';

    /**
     * Execute the command.
     */
    public function handle()
    {
        // Initialize HTTP client
        $client = new Client();

        // Book categories
        $categories = ['fiction', 'non-fiction', 'science', 'history', 'fantasy', 'mystery', 'romance'];

        // Track added books
        $booksAdded = 0;

        // Store books before insertion
        $booksToInsert = [];

        // Continue until 200 books are added
        while ($booksAdded < 200) {
            // Select random category
            $category = $categories[array_rand($categories)];

            // 5 API calls per category
            for ($i = 0; $i < 5; $i++) {
                // Get books from Google Books API
                $response = $client->get("https://www.googleapis.com/books/v1/volumes?q={$category}&maxResults=40&startIndex=" . ($i * 40));

                // Decode JSON response
                $data = json_decode($response->getBody(), true);

                // Process each book
                foreach ($data['items'] as $item) {
                    // Stop if 200 books reached
                    if ($booksAdded >= 200) {
                        break 2;
                    }

                    // Extract volume info
                    $volumeInfo = $item['volumeInfo'];

                    // Store book in array
                    $booksToInsert[] = [
                        'title' => $volumeInfo['title'],
                        'author' => implode(', ', $volumeInfo['authors'] ?? []),
                        'description' => $volumeInfo['description'] ?? null,
                        'cover_book_url' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
                        'category' => $volumeInfo['categories'][0] ?? $category,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Increment added books count
                    $booksAdded++;
                }
            }
        }

        // Insert all books at once
        Book::insert($booksToInsert);

        // Display success message
        $this->info("{$booksAdded} books have been populated successfully!");
    }
}
