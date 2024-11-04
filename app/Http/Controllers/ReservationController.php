<?php

/**
 * ReservationController: Handles book reservation functionality.
 */
namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Import Carbon for date management

class ReservationController extends Controller
{
    /**
     * Store a new book reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $bookId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $bookId)
    {
        // Validate the request data
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today', // Ensure start date is today or future
            'end_date' => 'required|date|after:start_date', // Ensure end date is after start date
        ]);

        // Retrieve the book instance
        $book = Book::findOrFail($bookId);

        // Extract start and end dates from request
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Check if book is already reserved for requested dates
        $isReserved = Reservation::where('book_id', $bookId)
            ->where(function ($query) use ($startDate, $endDate) {
                // Check date intersection
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $endDate)
                      ->where('end_date', '>=', $startDate);
                });
            })
            ->exists();

        // Return error if book is reserved
        if ($isReserved) {
            return response()->json([
                'success' => false,
                'message' => 'The book is already reserved for the selected dates.'
            ], 409);
        }

        // Create the reservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(), // Authenticated user's ID
            'book_id' => $bookId,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        // Return success response with reservation data
        return response()->json([
            'success' => true,
            'message' => 'Book reserved successfully!',
            'reservation' => $reservation,
        ]);
    }

    /**
     * Delete a reservation by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Retrieve and delete the reservation
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        // Return success response
        return response()->json(['success' => true]);
    }
}
