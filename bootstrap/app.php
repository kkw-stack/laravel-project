<?php

use App\Http\Middleware\AntispambotEmails;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\LocalizationMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\SetCacheHeaders;
use App\Http\Middleware\TrackVisitorMiddleware;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\ClearSocialSession;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'medongadmin/api/*',
            'reservation',
            'reservation/*/payment',
            'reservation/*/payment/callback',
            'en/reservation',
            'en/reservation/*/payment',
            'en/reservation/*/payment/callback',
        ]);

        $middleware->web(append: [
            TrustProxies::class,
            TrackVisitorMiddleware::class,
            LocalizationMiddleware::class,
            HandleInertiaRequests::class,
            SetCacheHeaders::class,
            ClearSocialSession::class,
        ]);

        $middleware->encryptCookies(['is-foreign']);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($request->routeIs('api.*')) {
                return response()->json(['message' => $e->getMessage()], $e->getStatusCode());
            }

            if (str_starts_with($request->server('REQUEST_URI'), '/en/')) {
                app()->setLocale('en');
            }
        });

        if (config('app.env', 'production') === 'production') {
            $exceptions->render(function (HttpException $e, Request $request) {
                return response()->view('errors.404', ['message' => $e->getMessage()], 404);
            });
        }
    })->create();
