<?php

namespace App\Http\Middleware;

use App\Models\Country;
use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DetectCountry
{
    /**
     * URI path prefixes that bypass country detection entirely.
     * Covers the admin panel and any future Filament installation.
     *
     * @var array<int, string>
     */
    private const array EXCLUDED_PREFIXES = ['admin', 'filament'];

    /**
     * Handle an incoming request.
     *
     * Resolves the current Country from the request's domain TLD, binds it
     * throughout the application, then continues the pipeline.  Page-view
     * logging happens *after* $next($request) so it never delays the response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip country detection entirely for admin / panel routes
        if ($this->isExcluded($request)) {
            return $next($request);
        }

        $country = $this->resolveCountry($request);

        // Bind into the service container for the entire request lifecycle
        app()->instance(Country::class, $country);

        // Store the code in the session (useful for redirects / stateless reads)
        session(['current_country' => $country->code]);

        // Share with every Blade view
        view()->share('currentCountry', $country);

        // Merge onto the request so controllers can do $request->country
        $request->merge(['country' => $country]);

        // Continue the pipeline first — page-view logging comes afterwards
        $response = $next($request);

        $this->logPageView($request, $country);

        return $response;
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Resolve the active Country from the incoming host's TLD.
     *
     * Given a host like "example.co.zw" this extracts "co.zw" and looks it up
     * in the countries table.  Aborts with 404 when no active match is found.
     */
    private function resolveCountry(Request $request): Country
    {
        $host = $request->getHost();               // e.g. "example.co.zw"

        // Everything after the first dot is the TLD portion (e.g. "co.zw")
        $tld = substr($host, strpos($host, '.') + 1);

        // On localhost / bare IP addresses there is no meaningful TLD.
        // Fall back to the first active country so local dev works out-of-the-box.
        $isLocal = in_array($host, ['localhost', '127.0.0.1', '::1'])
            || str_ends_with($host, '.test')
            || str_ends_with($host, '.local');

        $country = Country::where('is_active', true)
            ->when(! $isLocal, fn ($q) => $q->where('domain', $tld))
            ->first();

        if ($country === null) {
            abort(404, "No active country found for domain: {$tld}");
        }

        return $country;
    }

    /**
     * Insert a page-view record after the response has been prepared.
     *
     * Wrapped in try/catch so any DB hiccup is silently logged and
     * never propagates to the user.
     */
    private function logPageView(Request $request, Country $country): void
    {
        try {
            PageView::create([
                'country_code' => $country->code,
                'url'          => $request->fullUrl(),
                'ip_hash'      => hash('sha256', $request->ip() ?? ''),
                'user_agent'   => $request->userAgent(),
                'visited_at'   => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('PageView logging failed: ' . $e->getMessage(), [
                'url' => $request->fullUrl(),
            ]);
        }
    }

    /**
     * Determine whether the request targets a path that should bypass
     * country detection (e.g. admin panel, Filament).
     */
    private function isExcluded(Request $request): bool
    {
        $path = ltrim($request->path(), '/');

        foreach (self::EXCLUDED_PREFIXES as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        return false;
    }
}

