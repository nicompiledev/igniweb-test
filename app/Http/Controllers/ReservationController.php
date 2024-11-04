<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Importar Carbon para manejar las fechas

class ReservationController extends Controller
{

    public function store(Request $request, $bookId)
{
    // Validar la solicitud
    $request->validate([
        'start_date' => 'required|date|after_or_equal:today', // Asegurarse de que la fecha de inicio sea hoy o futura
        'end_date' => 'required|date|after:start_date', // Asegurarse de que la fecha de fin sea después de la fecha de inicio
    ]);

    // Obtener el libro
    $book = Book::findOrFail($bookId);

    // Obtener las fechas de inicio y fin
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    // Verificar si el libro ya está reservado en las fechas solicitadas
    $isReserved = Reservation::where('book_id', $bookId)
        ->where(function ($query) use ($startDate, $endDate) {
            // Verificar si hay una intersección en las fechas
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->where('start_date', '<=', $endDate)
                  ->where('end_date', '>=', $startDate);
            });
        })
        ->exists();

    if ($isReserved) {
        return response()->json(['success' => false, 'message' => 'The book is already reserved for the selected dates.'], 409);
    }

    // Crear la reserva
    $reservation = Reservation::create([
        'user_id' => Auth::id(), // ID del usuario logueado
        'book_id' => $bookId,
        'start_date' => $startDate,
        'end_date' => $endDate,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Book reserved successfully!',
        'reservation' => $reservation,
    ]);
}

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['success' => true]);
    }
}
