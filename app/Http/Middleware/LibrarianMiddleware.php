<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LibrarianMiddleware
{
    /**
     * Account types allowed to access librarian-scoped routes.
     *
     * Administrators have full system access, so they may also reach
     * any page behind this middleware.
     */
    private const ALLOWED_TYPES = ['librarian', 'administrator', 'admin'];

    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->guard('member')->check()) {
            return redirect()->route('staff.login');
        }

        $user = auth()->guard('member')->user();
        $type = strtolower((string) $user->account_type);

        if (! in_array($type, self::ALLOWED_TYPES, true)) {
            return redirect()->route('home')->with('error', 'Staff access is required for that page.');
        }

        if (strtolower((string) $user->account_status) !== 'active') {
            auth()->guard('member')->logout();
            $request->session()->invalidate();

            return redirect()->route('staff.login')->withErrors([
                'login' => 'Your account is currently unavailable. Please contact the library administrator.',
            ]);
        }

        return $next($request);
    }
}
