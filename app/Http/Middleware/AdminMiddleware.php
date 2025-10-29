<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Ensures that only authenticated users with admin privileges
     * can access admin-protected routes. Non-admin users are
     * redirected to the homepage with an error message.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to access the admin panel.');
        }

        // Check if authenticated user is an admin
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access the admin panel.');
        }

        // User is authenticated and is an admin, proceed
        return $next($request);
    }
}


