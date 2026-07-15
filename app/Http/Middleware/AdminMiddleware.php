<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Account types that can access the admin panel.
     *
     * Both administrators and librarians share the same back-office layout,
     * with administrator-only pages further restricted by the separate
     * AdministratorMiddleware.
     */
    private const STAFF_TYPES = ['administrator', 'admin', 'librarian'];

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->guard('member')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('staff.login');
        }

        $user = auth()->guard('member')->user();
        $type = strtolower((string) $user->account_type);

        if (in_array($type, self::STAFF_TYPES, true)) {
            if (strtolower($user->account_status) === 'active') {
                return $next($request);
            } else {
                auth()->guard('member')->logout();
                $request->session()->invalidate();

                return redirect()->route('staff.login')->withErrors(['login' => 'Your account is currently unavailable. Please contact the library administrator.']);
            }
        }

        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}
