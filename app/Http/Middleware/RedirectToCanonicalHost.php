<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToCanonicalHost
{
    /**
     * Redirect requests on non-canonical hosts (www/apex/herokuapp) to the
     * host configured in APP_URL. Production only: locally the app is
     * reachable through aliases like certitest.test on purpose.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->isProduction()) {
            return $next($request);
        }

        $canonicalHost = parse_url((string) config('app.url'), PHP_URL_HOST);

        if (! is_string($canonicalHost) || $canonicalHost === '' || $this->isPrivateHost($canonicalHost)) {
            return $next($request);
        }

        if (strcasecmp($canonicalHost, $request->getHost()) === 0) {
            return $next($request);
        }

        $scheme = parse_url((string) config('app.url'), PHP_URL_SCHEME) ?: 'https';
        $port = parse_url((string) config('app.url'), PHP_URL_PORT);
        $port = $port && ! in_array($port, [80, 443], true) ? ':'.$port : '';

        $target = $scheme.'://'.$canonicalHost.$port.$request->getRequestUri();

        // 301 for idempotent requests, 308 preserves method/body otherwise.
        $status = $request->isMethodCacheable() ? 301 : 308;

        return redirect()->to($target, $status);
    }

    /**
     * A localhost/private canonical host means APP_URL was never configured
     * for this environment — redirecting to it would take the site down.
     */
    private function isPrivateHost(string $host): bool
    {
        return filter_var($host, FILTER_VALIDATE_IP) !== false
            || str_ends_with(strtolower($host), '.test')
            || in_array(strtolower($host), ['localhost', 'localhost.localdomain'], true);
    }
}
