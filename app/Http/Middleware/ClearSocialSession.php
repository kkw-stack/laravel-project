<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearSocialSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!$request->routeIs('*.auth.register') && !$request->routeIs('*.auth.register.*') && !$request->routeIs('ko.auth.callback.nice')) {
            $request->session()->forget(['kakao_id', 'naver_id', 'google_id', 'social_email']);
        }
    

        return $next($request);
    }
}