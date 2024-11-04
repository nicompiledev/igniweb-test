<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Cambiar la ruta del dashboard para usar el controlador
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    // Aquí se maneja la verificación del correo electrónico
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    // Aquí se maneja el reenvío de la notificación de verificación
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Rutas de libros
Route::get('/books', [BookController::class, 'index'])->name('book.list');
Route::get('/books/filter', [BookController::class, 'filter'])->name('books.filter'); // Ruta para el filtrado AJAX
Route::post('/books/{book}/reserve', [ReservationController::class, 'store'])->middleware('auth');


Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');



require __DIR__.'/auth.php';
