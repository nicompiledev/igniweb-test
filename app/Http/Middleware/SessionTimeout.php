<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * SessionTimeout Middleware: Manages session timeouts for authenticated users.
 */
class SessionTimeout
{
    /**
     * Handles incoming requests and checks session timeouts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (Auth::check()) {
            // Verify inactivity period
            if (session('lastActivity') && (time() - session('lastActivity')) > config('session.lifetime') * 60) {
                // Logout due to inactivity
                Auth::logout();
                // Invalidate session
                $request->session()->invalidate();
                // Redirect to login with session expired message
                return redirect('/login')->with('message', 'Your session has expired due to inactivity.');
            }

            // Update last activity timestamp
            session(['lastActivity' => time()]);
        }

        // Continue processing request
        return $next($request);
    }
}
