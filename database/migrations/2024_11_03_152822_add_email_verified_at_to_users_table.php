<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * AddEmailVerifiedAtToUsersTable Migration: Adds 'email_verified_at' column to 'users' table.
 */
class AddEmailVerifiedAtToUsersTable extends Migration
{
    /**
     * Runs the migration to add the column.
     */
    public function up()
    {
        // Modifies 'users' table adding 'email_verified_at' column
        Schema::table('users', function (Blueprint $table) {
            // Adds 'email_verified_at' timestamp column allowing null values
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverts the migration by dropping the column.
     */
    public function down()
    {
        // Modifies 'users' table dropping 'email_verified_at' column
        Schema::table('users', function (Blueprint $table) {
            // Drops 'email_verified_at' column
            $table->dropColumn('email_verified_at');
        });
    }
}
