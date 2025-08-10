<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SetCacheHeaders
{

    private int $maxAge = 7200;
    private array $excludeCountries = [
        'KR'
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $isDev = config('app.env', 'production') === 'development';
        if ($isDev) {
            return $response;
        }

        if (!($response instanceof Response)) {
            return $response;
        }

        $country = $request->headers->get('CloudFront-Viewer-Country');

        if (in_array($country, $this->excludeCountries, true)) {
            $response->headers->removeCookie('is-foreign');
            return $response;
        }

        $cookie = Cookie::create(
            name: 'is-foreign',
            value: 'true',
            path: "/",
            secure: true,
            expire: time() + 60 * 60 * 24 * 365,
            httpOnly: false
        );

        $response->headers->setCookie($cookie);

        $hasQueryStrings = $request->getQueryString() != null;
        if ($hasQueryStrings) {
            $this->disableCacheHeader($response);
            return $response;
        }
        $this->setCacheHeader($response);

        return $response;
    }

    public function setCacheHeader(Response $response)
    {
        $etag = md5($response->getContent());

        $response->headers->set('Cache-Control', "public, max-age=$this->maxAge");
        $response->headers->set('ETag', $etag);
    }

    public function disableCacheHeader(Response $response)
    {
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
    }
}