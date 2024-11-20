<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationTest extends TestCase
{
    use RefreshDatabase; // Cleans the database after each test

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_reservation()
    {
        // Create a user and a book
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // Create a reservation
        $reservation = Reservation::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);

        // Assert that the reservation exists in the database
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }
}
