<?php

namespace App\Http\Middleware;

use App\Models\TrackVisitor;
use Closure;
use Illuminate\Http\Request;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) : Response
    {
        $crawler = new CrawlerDetect();

        if (! $crawler->isCrawler() && ! $request->routeIs('admin.*') && ! $request->is('up') && ! $request->routeIs('api.*')) {
            $visitor = new TrackVisitor();
            $visitor->user_id = $request->user()?->id ?? 0;
            $visitor->ip = $request->ip();
            $visitor->user_agent = $request->header('User-Agent');
            $visitor->url = $request->url();
            $visitor->referer = $request->headers->get('referer');
            $visitor->save();
        }

        return $next($request);
    }
}
