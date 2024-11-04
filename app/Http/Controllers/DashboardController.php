<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation; // Asegúrate de que el modelo de reservas esté creado

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        $reservations = Reservation::where('user_id', $user->id)->get(); // Obtener las reservas del usuario

        return view('dashboard', compact('user', 'reservations')); // Pasar los datos a la vista
    }
}
