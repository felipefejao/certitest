@extends('layouts.app')

@section('title', __('ui.privacy.meta_title'))
@section('description', __('ui.privacy.meta_description'))

@section('content')
    <main class="min-h-screen">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#fff0ed] via-[#fffaf6] to-[#f0f9ff] dark:from-[#1a0a05] dark:via-[#0a0a0a] dark:to-[#0a0a0a]"></div>

        <div class="absolute right-6 top-4">
            <x-language-selector />
        </div>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-3xl">
                <a href="{{ \App\Support\LocaleUrls::url('home') }}" class="mb-6 inline-flex items-center gap-1 text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]">
                    ← {{ __('ui.exam.back') }}
                </a>

                <div class="glass-card p-8 lg:p-12">
                    <h1 class="mb-2 text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.privacy.title') }}</h1>
                    <p class="mb-10 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.privacy.updated') }}</p>

                    <div class="space-y-8 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                        <section>
                            <h2 class="mb-2 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.privacy.data_title') }}</h2>
                            <p>{{ __('ui.privacy.data_text') }}</p>
                        </section>

                        <section>
                            <h2 class="mb-2 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.privacy.analytics_title') }}</h2>
                            <p>{{ __('ui.privacy.analytics_text') }}</p>
                        </section>

                        <section>
                            <h2 class="mb-2 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.privacy.ads_title') }}</h2>
                            <p>{{ __('ui.privacy.ads_text') }}</p>
                        </section>

                        <section>
                            <h2 class="mb-2 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.privacy.suggestions_title') }}</h2>
                            <p>{{ __('ui.privacy.suggestions_text') }}</p>
                        </section>

                        <section>
                            <h2 class="mb-2 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.privacy.rights_title') }}</h2>
                            <p class="mb-4">{{ __('ui.privacy.rights_text') }}</p>
                            <button
                                type="button"
                                data-consent-reset
                                class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] bg-white/80 px-6 py-2.5 text-sm font-semibold text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
                            >
                                {{ __('ui.consent.preferences') }}
                            </button>
                        </section>

                        <section class="rounded-xl border border-dashed border-[#e3e3e0] bg-white/40 p-6 dark:border-[#3E3E3A] dark:bg-[#161615]/40">
                            <p class="italic">{{ __('ui.privacy.legal_placeholder') }}</p>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
