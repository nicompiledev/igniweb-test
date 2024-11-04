<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
/**
 * AuthenticatedSessionController class
 *
 * This class handles the authentication session for the application.
 */

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autenticar al usuario usando el LoginRequest
        $request->authenticate();

        // Regenerar la sesión para evitar ataques de fijación de sesión
        $request->session()->regenerate();

        // Redirigir al usuario a la ruta del dashboard
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Cerrar sesión del usuario autenticado
        Auth::guard('web')->logout();

        // Invalidar la sesión del usuario
        $request->session()->invalidate();

        // Regenerar el token de sesión para seguridad
        $request->session()->regenerateToken();

        // Redirigir al usuario a la vista de login
        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
