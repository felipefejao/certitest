<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * @var array<int, string>
     */
    public const SUPPORTED = ['pt_BR', 'en', 'de', 'fr'];

    private const DEFAULT_LOCALE = 'pt_BR';

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeLocale = $request->route('locale');

        if (is_string($routeLocale) && in_array($routeLocale, self::SUPPORTED, true)) {
            $request->session()->put('locale', $routeLocale);
            app()->setLocale($routeLocale);

            if (str_starts_with($request->route()?->getName() ?? '', 'localized.')) {
                $request->route()?->forgetParameter('locale');
            }

            return $next($request);
        }

        $route = $request->route();
        $name = $route?->getName();
        $localizable = is_string($name)
            && ! str_starts_with($name, 'localized.')
            && Route::has('localized.'.$name);

        $locale = $request->session()->get('locale');
        $explicit = is_string($locale) && in_array($locale, self::SUPPORTED, true);

        if (! $explicit) {
            // Public localizable pages always render in the default locale:
            // a canonical URL must map to a single language for crawlers.
            $locale = $localizable ? self::DEFAULT_LOCALE : $this->detectLocale($request);
        }

        app()->setLocale($locale);

        if ($localizable && $explicit && $locale !== self::DEFAULT_LOCALE && $request->isMethod('GET')) {
            return redirect()->route('localized.'.$name, ['locale' => $locale] + $route->parameters());
        }

        return $next($request);
    }

    private function detectLocale(Request $request): string
    {
        $preferred = $request->getPreferredLanguage([...self::SUPPORTED, 'pt']);

        return match ($preferred) {
            'pt' => 'pt_BR',
            default => in_array($preferred, self::SUPPORTED, true) ? $preferred : 'pt_BR',
        };
    }
}
