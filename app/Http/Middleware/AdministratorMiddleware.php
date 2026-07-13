<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministratorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->guard('member')->user();

        if (! $user) {
            return redirect()->route('staff.login');
        }

        if (! in_array(strtolower((string) $user->account_type), ['administrator', 'admin'], true)) {
            return redirect()->route('librarian.dashboard')
                ->with('error', 'Administrator access is required for that page.');
        }

        return $next($request);
    }
}
