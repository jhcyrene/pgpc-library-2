<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'administrator' => \App\Http\Middleware\AdministratorMiddleware::class,
            'librarian' => \App\Http\Middleware\LibrarianMiddleware::class,
            'student' => \App\Http\Middleware\StudentAuthMiddleware::class,
        ]);

        $middleware->redirectUsersTo(function (Request $request): string {
            $user = auth()->guard('member')->user();
            $accountType = strtolower((string) ($user?->account_type ?? ''));

            return match (true) {
                in_array($accountType, ['member', 'student'], true) => route('student.dashboard'),
                $accountType === 'librarian' => route('librarian.dashboard'),
                default => route('admin.dashboard'),
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
