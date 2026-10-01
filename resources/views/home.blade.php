@extends('layouts.app')

@section('title', __('ui.home.meta_title'))
@section('description', __('ui.home.meta_description'))

@push('head')
    <script type="application/ld+json">
        @json($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    </script>
@endpush

@section('content')
    <main class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#fff0ed] via-[#fffaf6] to-[#f0f9ff] dark:from-[#1a0a05] dark:via-[#0a0a0a] dark:to-[#0a0a0a]"></div>

        <nav class="px-6 py-4">
            <div class="mx-auto flex max-w-6xl items-center justify-between">
                <img src="{{ asset('images/logo.png') }}" alt="CertiTest" class="h-10 w-auto">
                <div class="flex items-center gap-4">
                    <button
                        type="button"
                        onclick="openSuggestionModal()"
                        class="text-sm font-medium text-[#1b1b18] hover:text-[#f53003] dark:text-[#EDEDEC] dark:hover:text-[#FF4433]"
                    >
                        {{ __('ui.nav.suggest_theme') }}
                    </button>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-[#1b1b18] hover:text-[#f53003] dark:text-[#EDEDEC] dark:hover:text-[#FF4433]">{{ __('ui.nav.dashboard') }}</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-[#1b1b18] hover:text-[#f53003] dark:text-[#EDEDEC] dark:hover:text-[#FF4433]">{{ __('ui.nav.logout') }}</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-[#1b1b18] hover:text-[#f53003] dark:text-[#EDEDEC] dark:hover:text-[#FF4433]">{{ __('ui.nav.login') }}</a>
                        <a href="{{ route('register') }}" class="rounded-lg bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white">{{ __('ui.nav.register') }}</a>
                    @endauth
                    <x-language-selector />
                </div>
            </div>
        </nav>

        <section class="px-6 pt-12 pb-24 lg:pt-24 lg:pb-40">
            <div class="mx-auto max-w-6xl">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#f53003]/20 bg-[#f53003]/5 px-4 py-1.5 text-sm font-medium text-[#f53003] dark:bg-[#f53003]/10 dark:text-[#FF4433]">
                            <span class="h-2 w-2 rounded-full bg-[#f53003]"></span>
                            {{ __('ui.home.badge') }}
                        </div>

                        <h1 class="text-5xl font-bold tracking-tight text-[#1b1b18] dark:text-[#EDEDEC] lg:text-7xl">
                            {{ __('ui.home.hero_line1') }}<br />
                            <span class="text-[#f53003] dark:text-[#FF4433]">{{ __('ui.home.hero_line2') }}</span>
                        </h1>

                        <p class="max-w-lg text-lg leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            {{ __('ui.home.hero_subtitle') }}
                        </p>

                        <div class="flex flex-col gap-4 sm:flex-row">
                            <a
                                href="{{ Route::has('register') ? route('register') : url('/register') }}"
                                class="inline-flex items-center justify-center rounded-lg bg-[#1b1b18] px-8 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                            >
                                {{ __('ui.home.cta_start') }}
                            </a>
                            <a
                                href="#exams"
                                class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] bg-white/80 px-8 py-3.5 text-sm font-semibold text-[#1b1b18] backdrop-blur transition hover:border-[#f53003]/30 hover:bg-white dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC] dark:hover:bg-[#1a1a19]"
                            >
                                {{ __('ui.home.cta_explore') }}
                            </a>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -inset-4 -z-10 rounded-full bg-[#f53003]/10 blur-3xl dark:bg-[#f53003]/15"></div>

                        <div class="glass-card p-8 lg:p-10">
                            <div class="mb-6 flex items-center justify-between">
                                <span class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.demo_status') }}</span>
                                <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ __('ui.home.demo_done') }}</span>
                            </div>

                            <div class="space-y-4">
                                <p class="text-lg font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.demo_question') }}</p>

                                <div class="space-y-3">
                                    <div class="flex items-center gap-3 rounded-lg border border-[#e3e3e0] bg-white/50 p-3 dark:border-[#3E3E3A] dark:bg-[#161615]/50">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full border border-[#e3e3e0] text-xs font-semibold dark:border-[#3E3E3A]">A</span>
                                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.demo_option_a') }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 rounded-lg border border-[#f53003] bg-[#f53003]/5 p-3 dark:border-[#FF4433] dark:bg-[#FF4433]/10">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#f53003] text-xs font-semibold text-white dark:bg-[#FF4433]">B</span>
                                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.demo_option_b') }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 rounded-lg border border-[#e3e3e0] bg-white/50 p-3 dark:border-[#3E3E3A] dark:bg-[#161615]/50">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full border border-[#e3e3e0] text-xs font-semibold dark:border-[#3E3E3A]">C</span>
                                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.demo_option_c') }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 rounded-lg border border-[#e3e3e0] bg-white/50 p-3 dark:border-[#3E3E3A] dark:bg-[#161615]/50">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full border border-[#e3e3e0] text-xs font-semibold dark:border-[#3E3E3A]">D</span>
                                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.demo_option_d') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="mb-2 flex items-center justify-between text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    <span>{{ __('ui.home.demo_progress') }}</span>
                                    <span>{{ __('ui.home.demo_question_count') }}</span>
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-[#e3e3e0] dark:bg-[#3E3E3A]">
                                    <div class="h-full w-[24%] rounded-full bg-[#f53003] dark:bg-[#FF4433]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-6xl">
                <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.how_title') }}</h2>
                    <p class="mt-3 text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.how_subtitle') }}</p>
                </div>

                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="glass-card p-8 text-center">
                        <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#f53003]/10 text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125V9.375m-7.5 10.5V6.375a1.125 1.125 0 011.125-1.125h6.375c.621 0 1.125.504 1.125 1.125v11.25" /></svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.step1_title') }}</h3>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.step1_text') }}</p>
                    </div>

                    <div class="glass-card p-8 text-center">
                        <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#f53003]/10 text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.step2_title') }}</h3>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.step2_text') }}</p>
                    </div>

                    <div class="glass-card p-8 text-center">
                        <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#f53003]/10 text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.step3_title') }}</h3>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.step3_text') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-6xl">
                <div class="grid gap-12 lg:grid-cols-2">
                    <div>
                        <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.why_title') }}</h2>
                        <p class="mt-3 text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.why_subtitle') }}</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.feature_practical_title') }}</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.feature_practical_text') }}</p>
                        </div>
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.feature_instant_title') }}</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.feature_instant_text') }}</p>
                        </div>
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.feature_history_title') }}</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.feature_history_text') }}</p>
                        </div>
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.feature_focused_title') }}</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.feature_focused_text') }}</p>
                        </div>
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.feature_responsive_title') }}</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.feature_responsive_text') }}</p>
                        </div>
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.feature_sharing_title') }}</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.feature_sharing_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="exams" class="px-6 py-20">
            <div class="mx-auto max-w-6xl">
                <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.exams_title') }}</h2>
                    <p class="mt-3 text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.exams_subtitle') }}</p>
                </div>

                @if ($categories->isNotEmpty())
                    <div class="mb-10 flex justify-center">
                        <select
                            id="exam-category-filter"
                            class="rounded-lg border border-[#e3e3e0] bg-white/80 px-4 py-2.5 text-sm font-medium text-[#1b1b18] outline-none transition focus:border-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC] dark:focus:border-[#FF4433]"
                        >
                            <option value="">{{ __('ui.home.all_categories') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if ($exams->isNotEmpty())
                    <div id="exams-grid" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($exams as $exam)
                            <article data-category="{{ $exam['category_slug'] }}" class="glass-card flex flex-col p-6 transition hover:-translate-y-1">
                                <div class="mb-4 flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $exam['name'] }}</h3>
                                    <span class="rounded-full bg-[#f53003]/10 px-2.5 py-0.5 text-xs font-medium text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                                        {{ trans_choice('ui.home.questions_count', $exam['questions_count']) }}
                                    </span>
                                </div>
                                @if ($exam['category'])
                                    <a href="{{ route('categories.show', $exam['category_slug']) }}" class="mb-3 inline-flex w-fit rounded-full border border-[#e3e3e0] px-2.5 py-0.5 text-xs font-medium text-[#706f6c] transition hover:border-[#f53003]/40 hover:text-[#1b1b18] dark:border-[#3E3E3A] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]">
                                        {{ $exam['category'] }}
                                    </a>
                                @endif
                                <p class="mb-6 flex-1 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ $exam['description'] }}</p>
                                <a
                                    href="{{ Route::has('exams.show') ? route('exams.show', $exam['slug']) : url('/exams/'.$exam['slug']) }}"
                                    class="mt-auto inline-flex w-full items-center justify-center rounded-lg bg-[#1b1b18] py-2.5 text-sm font-semibold text-white transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                                >
                                    {{ __('ui.home.start_exam') }}
                                </a>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="glass-card py-16 text-center">
                        <p class="text-lg font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.no_exams') }}</p>
                        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.no_exams_sub') }}</p>
                    </div>
                @endif

                <div class="mt-12 text-center">
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.missing_theme') }}</p>
                    <button
                        type="button"
                        onclick="openSuggestionModal()"
                        class="mt-3 inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] bg-white/80 px-6 py-2.5 text-sm font-semibold text-[#1b1b18] backdrop-blur transition hover:border-[#f53003]/30 hover:bg-white dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC] dark:hover:bg-[#1a1a19]"
                    >
                        {{ __('ui.home.suggest_theme_cta') }}
                    </button>
                </div>
            </div>
        </section>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-6xl">
                <div class="grid gap-8 text-center sm:grid-cols-3">
                    <div class="glass-card p-8">
                        <p class="text-4xl font-bold text-[#f53003] dark:text-[#FF4433]">+{{ \Illuminate\Support\Number::format($stats->questions, locale: app()->getLocale()) }}</p>
                        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.stats_questions') }}</p>
                    </div>
                    <div class="glass-card p-8">
                        <p class="text-4xl font-bold text-[#f53003] dark:text-[#FF4433]">+{{ \Illuminate\Support\Number::format($stats->exams, locale: app()->getLocale()) }}</p>
                        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.stats_exams') }}</p>
                    </div>
                    <div class="glass-card p-8">
                        <p class="text-4xl font-bold text-[#f53003] dark:text-[#FF4433]">+{{ \Illuminate\Support\Number::format($stats->attempts, locale: app()->getLocale()) }}</p>
                        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.stats_candidates') }}</p>
                    </div>
                </div>
            </div>
        </section>

        @if (is_array($faqs) && count($faqs) > 0)
            <section class="px-6 py-20">
                <div class="mx-auto max-w-4xl">
                    <div class="mb-12 text-center">
                        <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.faq.title') }}</h2>
                    </div>
                    <div class="space-y-3">
                        @foreach ($faqs as $faq)
                            <details class="glass-card group p-5">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC] [&::-webkit-details-marker]:hidden">
                                    {{ $faq['q'] }}
                                    <svg class="h-5 w-5 shrink-0 text-[#706f6c] transition group-open:rotate-180 dark:text-[#A1A09A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </summary>
                                <p class="mt-3 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ $faq['a'] }}</p>
                            </details>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="px-6 py-20">
            <div class="mx-auto max-w-4xl">
                <div class="glass-card p-10 text-center lg:p-16">
                    <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.cta_title') }}</h2>
                    <p class="mx-auto mt-4 max-w-xl text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.cta_subtitle') }}</p>
                    <a
                        href="{{ Route::has('register') ? route('register') : url('/register') }}"
                        class="mt-8 inline-flex items-center justify-center rounded-lg bg-[#f53003] px-10 py-4 text-base font-semibold text-white shadow-lg transition hover:bg-[#d62b04] dark:bg-[#FF4433] dark:hover:bg-[#f53003]"
                    >
                        {{ __('ui.home.cta_start') }}
                    </a>
                </div>
            </div>
        </section>

        <footer class="border-t border-[#e3e3e0] px-6 py-10 dark:border-[#3E3E3A]">
            <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 text-sm text-[#706f6c] dark:text-[#A1A09A] sm:flex-row">
                <p>&copy; {{ date('Y') }} CertiTest. {{ __('ui.home.footer_rights') }}</p>
                <div class="flex gap-6">
                    <a href="#" class="transition hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">{{ __('ui.home.footer_terms') }}</a>
                    <a href="{{ route('privacy') }}" class="transition hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">{{ __('ui.home.footer_privacy') }}</a>
                    <button type="button" data-consent-reset class="transition hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">{{ __('ui.consent.preferences') }}</button>
                    <a href="https://dev7.com.br" target="_blank" rel="noopener noreferrer" class="transition hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">{{ __('ui.home.footer_dev7') }}</a>
                </div>
            </div>
        </footer>

        @if (session('suggestion_success'))
            <div class="fixed bottom-6 right-6 z-50 rounded-lg bg-green-600 px-5 py-3 text-sm font-medium text-white shadow-lg">
                {{ session('suggestion_success') }}
            </div>
        @endif

        <div id="suggestion-modal" data-auto-open="{{ session('suggestion_success') ? '0' : '1' }}" class="{{ $errors->hasAny(['theme', 'email', 'captcha', 'website']) ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-gradient-to-br from-[#f53003]/30 via-black/40 to-black/50 backdrop-blur-sm" onclick="closeSuggestionModal()"></div>

            <div class="glass-card relative w-full max-w-md p-8 shadow-2xl ring-2 ring-[#f53003]/40 dark:ring-[#FF4433]/40">
                <div class="mb-6 flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.modal_title') }}</h3>
                        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.home.modal_subtitle') }}</p>
                    </div>
                    <button type="button" onclick="closeSuggestionModal()" class="text-[#706f6c] transition hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('suggestions.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="suggestion-theme" class="mb-1.5 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.modal_theme') }}</label>
                        <input
                            type="text"
                            id="suggestion-theme"
                            name="theme"
                            value="{{ old('theme') }}"
                            required
                            maxlength="255"
                            placeholder="{{ __('ui.home.modal_theme_placeholder') }}"
                            class="w-full rounded-lg border border-[#e3e3e0] bg-white/70 px-3.5 py-2.5 text-sm text-[#1b1b18] outline-none transition placeholder:text-[#A1A09A] focus:border-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615]/70 dark:text-[#EDEDEC] dark:focus:border-[#FF4433]"
                        >
                        @error('theme')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="suggestion-email" class="mb-1.5 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.home.modal_email') }}</label>
                        <input
                            type="email"
                            id="suggestion-email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            maxlength="255"
                            placeholder="{{ __('ui.home.modal_email_placeholder') }}"
                            class="w-full rounded-lg border border-[#e3e3e0] bg-white/70 px-3.5 py-2.5 text-sm text-[#1b1b18] outline-none transition placeholder:text-[#A1A09A] focus:border-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615]/70 dark:text-[#EDEDEC] dark:focus:border-[#FF4433]"
                        >
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="suggestion-captcha" class="mb-1.5 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $captchaQuestion }}</label>
                        <input
                            type="number"
                            id="suggestion-captcha"
                            name="captcha"
                            required
                            class="w-full rounded-lg border border-[#e3e3e0] bg-white/70 px-3.5 py-2.5 text-sm text-[#1b1b18] outline-none transition focus:border-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615]/70 dark:text-[#EDEDEC] dark:focus:border-[#FF4433]"
                        >
                        @error('captcha')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                    @error('website')
                        <p class="text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                        {!! __('ui.home.modal_privacy_notice', ['link' => '<a href="'.route('privacy').'" class="font-medium underline underline-offset-2 transition hover:text-[#f53003] dark:hover:text-[#FF4433]">'.__('ui.home.footer_privacy').'</a>']) !!}
                    </p>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeSuggestionModal()" class="rounded-lg px-4 py-2.5 text-sm font-medium text-[#706f6c] transition hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]">
                            {{ __('ui.home.modal_cancel') }}
                        </button>
                        <button type="submit" class="rounded-lg bg-[#f53003] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#d62b04] dark:bg-[#FF4433] dark:hover:bg-[#f53003]">
                            {{ __('ui.home.modal_submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const categoryFilter = document.getElementById('exam-category-filter');

            if (categoryFilter) {
                categoryFilter.addEventListener('change', function () {
                    const selected = this.value;

                    document.querySelectorAll('#exams-grid [data-category]').forEach(function (card) {
                        card.classList.toggle('hidden', selected !== '' && card.dataset.category !== selected);
                    });
                });
            }

            const suggestionModal = document.getElementById('suggestion-modal');

            function openSuggestionModal() {
                suggestionModal.classList.remove('hidden');
            }

            function closeSuggestionModal() {
                suggestionModal.classList.add('hidden');
            }

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeSuggestionModal();
                }
            });

            if (suggestionModal.dataset.autoOpen === '1') {
                openSuggestionModal();
            }
        </script>
    </main>
@endsection
