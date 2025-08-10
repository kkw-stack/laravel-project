<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated extends \Illuminate\Auth\Middleware\RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guard) : Response
    {
        if ($request->routeIs('admin.*') && Auth::guard('admin')->check()) {
            return to_route('admin.home');
        }

        return parent::handle($request, $next, ...$guard);
    }
}
