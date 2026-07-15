<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated via member guard
        if (!Auth::guard('member')->check()) {
            // Save intended URL for redirect after login (especially for OPAC reservations)
            if ($request->isMethod('get') && !$request->ajax()) {
                session()->put('url.intended', $request->fullUrl());
            }
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $user = Auth::guard('member')->user();

        // Ensure the account belongs to a member and is active
        if (!in_array(strtolower((string) $user->account_type), ['member', 'student'], true) || !$user->member_id) {
            Auth::guard('member')->logout();
            $request->session()->invalidate();
            return redirect()->route('login')->withErrors([
                'login' => 'Access denied. Only students can access this area.'
            ]);
        }

        if (strtolower((string) $user->account_status) !== 'active') {
            Auth::guard('member')->logout();
            $request->session()->invalidate();
            return redirect()->route('login')->withErrors([
                'login' => 'Your account is currently unavailable. Please contact the library administrator.'
            ]);
        }

        return $next($request);
    }
}
