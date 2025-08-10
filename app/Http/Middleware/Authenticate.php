<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;

class Authenticate extends BaseAuthenticate
{
    public function redirectTo(Request $request)
    {
        if (false === $request->expectsJson()) {
            if ($request->routeIs('admin.*')) {
                return route('admin.auth.login');
            }

            return jt_route('login');
        }

        return parent::redirectTo($request);
    }
}
