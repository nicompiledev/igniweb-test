<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * CreateReservationsTable Migration: Creates the reservations table.
 */
class CreateReservationsTable extends Migration
{
    /**
     * Run the migration to create the reservations table.
     */
    public function up()
    {
        // Create the reservations table with specified columns
        Schema::create('reservations', function (Blueprint $table) {
            // Auto-incrementing primary key
            $table->id();

            // Foreign key referencing the user
            $table->foreignId('user_id')
                ->constrained() // Establish relationship with users table
                ->onDelete('cascade'); // Delete reservation when user is deleted

            // Foreign key referencing the book
            $table->foreignId('book_id')
                ->constrained() // Establish relationship with books table
                ->onDelete('cascade'); // Delete reservation when book is deleted

            // Reservation start date
            $table->date('start_date');

            // Reservation end date
            $table->date('end_date');

            // Timestamps for created/updated records
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration to drop the reservations table.
     */
    public function down()
    {
        // Drop the reservations table
        Schema::dropIfExists('reservations');
    }
}
