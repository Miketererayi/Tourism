<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class CacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$response->isSuccessful() || $request->method() !== 'GET') {
            return $response;
        }

        $path = ltrim($request->path(), '/');

        // Admin and Filament paths
        if (Str::startsWith($path, ['admin', 'filament'])) {
            $response->headers->set('Cache-Control', 'no-store, no-cache');
            return $response;
        }

        // Sitemap routes
        if (Str::startsWith($path, 'sitemap')) {
            $response->headers->set('Cache-Control', 'public, max-age=86400'); // 24 hours
            return $response;
        }

        // Default public pages
        $response->headers->set('Cache-Control', 'public, max-age=3600'); // 1 hour
        $response->headers->set('Vary', 'Accept-Encoding');

        return $response;
    }
}
