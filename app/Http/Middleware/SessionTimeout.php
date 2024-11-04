<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Verifica el tiempo de inactividad
            if (session('lastActivity') && (time() - session('lastActivity')) > config('session.lifetime') * 60) {
                Auth::logout(); // Cerrar sesión
                $request->session()->invalidate(); // Invalidar la sesión
                return redirect('/login')->with('message', 'Your session has expired due to inactivity.
');
            }

            // Actualiza el tiempo de última actividad
            session(['lastActivity' => time()]);
        }

        return $next($request);
    }
}
