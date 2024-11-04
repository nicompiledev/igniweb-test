<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

/**
 * DashboardController: Handles dashboard-related functionality.
 */
class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Fetch user's reservations
        $reservations = Reservation::where('user_id', $user->id)->get();

        // Pass user and reservation data to the dashboard view
        return view('dashboard', compact('user', 'reservations'));
    }
}
