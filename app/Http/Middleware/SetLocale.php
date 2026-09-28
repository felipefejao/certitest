<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * @var array<int, string>
     */
    public const SUPPORTED = ['pt_BR', 'en', 'de', 'fr'];

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale');

        if (! is_string($locale) || ! in_array($locale, self::SUPPORTED, true)) {
            $locale = $this->detectLocale($request);
            $request->session()->put('locale', $locale);
        }

        app()->setLocale($locale);

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
