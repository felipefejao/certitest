<?php

namespace App\Support;

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

class LocaleUrls
{
    public const DEFAULT_LOCALE = 'pt_BR';

    /**
     * Build the URL for a public named route in the given (or current) locale.
     * pt_BR stays unprefixed; other locales resolve through the localized.* routes.
     */
    public static function url(string $name, array $parameters = [], ?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        if ($locale === self::DEFAULT_LOCALE || ! Route::has('localized.'.$name)) {
            return route($name, $parameters);
        }

        return route('localized.'.$name, ['locale' => $locale] + $parameters);
    }

    /**
     * Alternate URLs (locale => absolute URL) for the current route,
     * or an empty array when the route has no localized variant.
     *
     * @return array<string, string>
     */
    public static function alternates(): array
    {
        $route = request()->route();
        $name = $route?->getName();

        if (! is_string($name)) {
            return [];
        }

        $base = str_starts_with($name, 'localized.') ? substr($name, 10) : $name;

        if (! Route::has('localized.'.$base)) {
            return [];
        }

        $parameters = $route->parameters();
        unset($parameters['locale']);

        $urls = [];

        foreach (SetLocale::SUPPORTED as $locale) {
            $urls[$locale] = self::url($base, $parameters, $locale);
        }

        return $urls;
    }
}
