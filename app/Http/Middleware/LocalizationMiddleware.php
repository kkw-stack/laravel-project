<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) : Response
    {
        if ($request->routeIs('en.*')) {
            app()->setLocale('en');
        }

        // 로케일 변경시 자동 로그아웃 처리
        if (Auth::guard('web')->check()) {
            if (Auth::guard('web')->user()->locale !== app()->getLocale()) {
                Auth::guard('web')->logout();
            }
        }

        return $next($request);
    }
}
