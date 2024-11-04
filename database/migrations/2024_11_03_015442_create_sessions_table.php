<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create Sessions Table Migration: Creates the sessions table.
 */
return new class extends Migration
{
    /**
     * Run the migration to create the sessions table.
     */
    public function up(): void
    {
        // Create the sessions table with specified columns
        Schema::create('sessions', function (Blueprint $table) {
            // Primary key (session ID)
            $table->string('id')->primary();

            // Foreign key referencing the user (nullable)
            $table->foreignId('user_id')
                ->nullable() // Allow null values
                ->index(); // Create index for efficient queries

            // IP address (nullable, 45 characters)
            $table->string('ip_address', 45)->nullable();

            // User agent (nullable)
            $table->text('user_agent')->nullable();

            // Session payload (long text)
            $table->longText('payload');

            // Last activity timestamp (indexed)
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migration to drop the sessions table.
     */
    public function down(): void
    {
        // Drop the sessions table
        Schema::dropIfExists('sessions');
    }
};
