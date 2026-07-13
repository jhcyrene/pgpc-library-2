<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LibrarianMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->guard('member')->check()) {
            return redirect()->route('staff.login');
        }

        $user = auth()->guard('member')->user();

        if (strtolower((string) $user->account_type) !== 'librarian') {
            $route = in_array(strtolower((string) $user->account_type), ['administrator', 'admin'], true)
                ? 'admin.dashboard'
                : 'home';

            return redirect()->route($route)->with('error', 'Librarian access is required for that page.');
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
