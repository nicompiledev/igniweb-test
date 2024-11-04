<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * AddUserProfileImage Migration: Adds profile image column to users table.
 */
return new class extends Migration
{
    /**
     * Runs the migration to add the profile image column.
     */
    public function up()
    {
        // Modifies 'users' table adding 'profile_image' column
        Schema::table('users', function (Blueprint $table) {
            // Adds 'profile_image' string column allowing null values
            $table->string('profile_image')->nullable();
        });
    }

    /**
     * Reverts the migration by dropping the profile image column.
     */
    public function down()
    {
        // Modifies 'users' table dropping 'profile_image' column
        Schema::table('users', function (Blueprint $table) {
            // Drops 'profile_image' column
            $table->dropColumn('profile_image');
        });
    }
};
