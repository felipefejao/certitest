<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <meta name="description" content="@yield('description', 'Teste seus conhecimentos e prepare-se para certificações com o CertiTest.')">
        <meta name="robots" content="@yield('meta_robots', 'index, follow')">
        @if (config('services.google.site_verification'))
        <meta name="google-site-verification" content="{{ config('services.google.site_verification') }}">
        @endif
        <link rel="canonical" href="@yield('canonical', url()->current())">

        @php($localeAlternates = \App\Support\LocaleUrls::alternates())
        @foreach ($localeAlternates as $alternateLocale => $alternateUrl)
        <link rel="alternate" hreflang="{{ str_replace('_', '-', $alternateLocale) }}" href="{{ $alternateUrl }}">
        @endforeach
        @if ($localeAlternates)
        <link rel="alternate" hreflang="x-default" href="{{ $localeAlternates['pt_BR'] }}">
        @endif

        <meta property="og:locale" content="{{ app()->getLocale() }}">
        @foreach (\App\Http\Middleware\SetLocale::SUPPORTED as $supportedLocale)
            @if ($supportedLocale !== app()->getLocale())
        <meta property="og:locale:alternate" content="{{ $supportedLocale }}">
            @endif
        @endforeach

        <meta property="og:title" content="@yield('title', config('app.name', 'Laravel'))">
        <meta property="og:description" content="@yield('description', 'Teste seus conhecimentos e prepare-se para certificações com o CertiTest.')">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="@yield('og_image', asset('images/og-default.png'))">
        <meta property="og:image:type" content="@yield('og_image_type', 'image/png')">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('title', config('app.name', 'Laravel'))">
        <meta name="twitter:description" content="@yield('description', 'Teste seus conhecimentos e prepare-se para certificações com o CertiTest.')">
        <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.png'))">

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        @stack('head')
    </head>
    <body class="min-h-screen bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] antialiased">
        @yield('content')

        <x-cookie-consent ga-id="G-XCHXPC53GX" :adsense-client="config('services.adsense.client')" />
    </body>
</html>
