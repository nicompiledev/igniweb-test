<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// Root route: display welcome view
Route::get('/', function () {
    return view('welcome');
});

// Change dashboard route to use controller
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified']) // Require authentication and verification
    ->name('dashboard');

// Authenticated routes group
Route::middleware('auth')->group(function () {
    // Edit profile route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Update profile route
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Delete profile route
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Email verification notice route
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

// Email verification route
Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    // Handle email verification logic here
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend verification notification route
Route::post('/email/verification-notification', function (Request $request) {
    // Handle resend verification notification logic here
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Book routes
Route::get('/books', [BookController::class, 'index'])->name('book.list');
Route::get('/books/filter', [BookController::class, 'filter'])->name('books.filter'); // AJAX filtering route
Route::post('/books/{book}/reserve', [ReservationController::class, 'store'])->middleware('auth');

// Delete reservation route
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

// Load authentication routes
require __DIR__.'/auth.php';
