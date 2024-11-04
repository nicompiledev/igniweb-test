<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * CreatePasswordResetsTable Migration: Creates table for password reset tokens.
 */
class CreatePasswordResetsTable extends Migration
{
    /**
     * Runs the migration to create the table.
     *
     * @return void
     */
    public function up()
    {
        // Creates 'password_reset_tokens' table with specified columns
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            // User email (indexed)
            $table->string('email')->index();

            // Password reset token
            $table->string('token');

            // Creation timestamp (nullable)
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverts the migration by dropping the table.
     *
     * @return void
     */
    public function down()
    {
        // Drops 'password_reset_tokens' table
        Schema::dropIfExists('password_reset_tokens');
    }
}
