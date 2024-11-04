<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreateUsersTable Migration: Creates the users table.
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migration to create the users table.
     */
    public function up()
    {
        // Create the users table with the specified columns
        Schema::create('users', function (Blueprint $table) {
            // Auto-incrementing primary key
            $table->id();

            // Unique username column
            $table->string('username')->unique();

            // Unique email address column
            $table->string('email')->unique();

            // Password column
            $table->string('password');

            // Optional remember token column
            $table->string('remember_token')->nullable();

            // Timestamp columns for created/updated records
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration to drop the users table.
     */
    public function down()
    {
        // Drop the users table
        Schema::dropIfExists('users');
    }
}
