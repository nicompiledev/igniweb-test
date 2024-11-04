<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateBooksTable Migration: Creates the books table.
 */
class CreateBooksTable extends Migration
{
    /**
     * Run the migration to create the books table.
     */
    public function up()
    {
        // Create the books table with specified columns
        Schema::create('books', function (Blueprint $table) {
            // Auto-incrementing primary key
            $table->id();

            // Book title
            $table->string('title');

            // Book author
            $table->string('author');

            // Optional book description
            $table->text('description')->nullable();

            // Optional book cover image URL
            $table->string('cover_book_url')->nullable();

            // Book category (stored as text)
            $table->string('category');

            // Timestamps for created/updated records
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration to drop the books table.
     */
    public function down()
    {
        // Drop the books table
        Schema::dropIfExists('books');
    }
}
