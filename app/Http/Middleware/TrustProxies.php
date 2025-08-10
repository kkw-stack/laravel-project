<?php
 
namespace App\Http\Middleware;
 
use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;
 
class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var string|array
     */
    protected $proxies = '*';
 
    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_TRAEFIK | Request::HEADER_X_FORWARDED_PROTO;
}