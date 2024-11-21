<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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

        // Verify that the reservation exists in the database
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }

    // Validation test to ensure 'user_id' is required
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_requires_a_user_id()
    {
        $book = Book::factory()->create();

        // Data without 'user_id'
        $data = [
            'book_id' => $book->id,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ];

        // Perform validation with Validator
        $validator = Validator::make($data, Reservation::rules());

        // Ensure that validation fails
        $this->assertTrue($validator->fails());
    }

    // Validation test to ensure 'book_id' is required
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_requires_a_book_id()
    {
        $user = User::factory()->create();

        // Data without 'book_id'
        $data = [
            'user_id' => $user->id,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ];

        // Perform validation with Validator
        $validator = Validator::make($data, Reservation::rules());

        // Ensure that validation fails
        $this->assertTrue($validator->fails());
    }

    // Validation test to ensure the dates are valid (start_date before end_date)
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_requires_valid_start_and_end_dates()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // 'start_date' after 'end_date', should fail
        $data = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(3),
        ];

        // Perform validation with Validator
        $validator = Validator::make($data, Reservation::rules());

        // Ensure that validation fails
        $this->assertTrue($validator->fails());
    }

    // Validation test to ensure the dates are valid
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_requires_start_and_end_dates_to_be_dates()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // Pass invalid data for the dates
        $data = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'start_date' => 'invalid-date',
            'end_date' => 'invalid-date',
        ];

        // Perform validation with Validator
        $validator = Validator::make($data, Reservation::rules());

        // Ensure that validation fails
        $this->assertTrue($validator->fails());
    }

    // Test to ensure a reservation can be created with valid data
    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_a_reservation_with_valid_data()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $data = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ];

        // Validation should pass correctly
        $reservation = Reservation::create($data);

        // Verify that the reservation was created in the database
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_deletes_reservations_when_user_is_deleted()
    {
        // Create a user and a book
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // Create a reservation associated with the user and book
        $reservation = Reservation::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);

        // Verify that the reservation has been created
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        // Delete the user
        $user->delete();

        // Verify that the reservation has been deleted as well
        $this->assertDatabaseMissing('reservations', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_deletes_reservations_when_book_is_deleted()
    {
        // Create a user and a book
        $user = User::factory()->create();
        $book = Book::factory()->create();

        // Create a reservation associated with the user and book
        $reservation = Reservation::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'start_date' => now(),
            'end_date' => now()->addDays(7),
        ]);

        // Verify that the reservation has been created
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        // Delete the book
        $book->delete();

        // Verify that the reservation has been deleted as well
        $this->assertDatabaseMissing('reservations', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }
}
