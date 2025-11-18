<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => App\Http\Middleware\EnsureUserHasRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle CSRF token mismatch (419 errors) gracefully
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            // If it's a logout request, just redirect to home (user is already logged out)
            if ($request->is('logout') || $request->routeIs('logout')) {
                return redirect('/')->with('status', 'You have been logged out.');
            }
            
            // For other requests, show the 419 error page
            return response()->view('errors.419', [], 419);
        });
    })->create();
