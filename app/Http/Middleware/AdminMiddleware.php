<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // For PGPC Library System, we assume standard auth check with an admin role.
        // Adjust the role check as necessary based on the actual User model structure.
        if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->is_admin)) {
            return $next($request);
        }

        // For now, redirect to home if not admin to prevent unauthorized access
        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
