@extends('layouts.app')

@section('title', $metaTitle ?? $exam['name'].' — CertiTest')
@section('description', $metaDescription)

@push('head')
    <script type="application/ld+json">
        @json($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    </script>
@endpush

@section('content')
    <main class="min-h-screen">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#fff0ed] via-[#fffaf6] to-[#f0f9ff] dark:from-[#1a0a05] dark:via-[#0a0a0a] dark:to-[#0a0a0a]"></div>

        <div class="absolute right-6 top-4">
            <x-language-selector />
        </div>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-2xl">
                <nav aria-label="breadcrumb" class="mb-6">
                    <ol class="flex flex-wrap items-center gap-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        @foreach ($breadcrumbs as $index => $breadcrumb)
                            <li class="flex items-center gap-1">
                                @if ($index > 0)
                                    <span aria-hidden="true">›</span>
                                @endif
                                @if ($loop->last)
                                    <span aria-current="page" class="text-[#1b1b18] dark:text-[#EDEDEC]">{{ $breadcrumb['name'] }}</span>
                                @else
                                    <a href="{{ $breadcrumb['url'] }}" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">{{ $breadcrumb['name'] }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>

                <div class="glass-card p-8">
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                        <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $exam['name'] }}</h1>
                        <span class="rounded-full bg-[#f53003]/10 px-3 py-1 text-sm font-medium text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                            {{ trans_choice('ui.home.questions_count', $exam['questions_count']) }}
                        </span>
                    </div>

                    @if ($exam['category'])
                        <p class="-mt-4 mb-6 text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">{{ $exam['category'] }}</p>
                    @endif

                    <p class="mb-8 text-[#706f6c] dark:text-[#A1A09A]">{{ $exam['description'] }}</p>

                    @if ($exam['intro'])
                        <div class="mb-8 space-y-4 text-[#3f3f3a] dark:text-[#A1A09A]">
                            {!! nl2br(e($exam['intro'])) !!}
                        </div>
                    @endif

                    <div class="mb-8 rounded-xl border border-[#e3e3e0] bg-white/50 p-6 dark:border-[#3E3E3A] dark:bg-[#161615]/50">
                        <h2 class="mb-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.exam.before_start') }}</h2>
                        <ul class="space-y-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#f53003]"></span>
                                {{ __('ui.exam.rule_navigate') }}
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#f53003]"></span>
                                {{ __('ui.exam.rule_time') }}
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#f53003]"></span>
                                {{ __('ui.exam.rule_unanswered') }}
                            </li>
                        </ul>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row">
                        @auth
                            <form method="POST" action="{{ route('exams.start', $exam['slug']) }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-lg bg-[#1b1b18] px-8 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                                >
                                    {{ __('ui.home.start_exam') }}
                                </button>
                            </form>
                            <a
                                href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] bg-white/80 px-8 py-3.5 text-sm font-semibold text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
                            >
                                {{ __('ui.exam.cancel') }}
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center justify-center rounded-lg bg-[#1b1b18] px-8 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                            >
                                {{ __('ui.exam.login_cta') }}
                            </a>
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] bg-white/80 px-8 py-3.5 text-sm font-semibold text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
                            >
                                {{ __('ui.exam.register_cta') }}
                            </a>
                        @endauth
                    </div>

                    <x-share-result
                        :title="$exam['name'].' — CertiTest'"
                        :description="__('ui.exam.share_description', ['exam' => $exam['name']])"
                        :url="\App\Support\LocaleUrls::url('exams.show', ['slug' => $exam['slug']])"
                    />
                </div>

                @if ($relatedExams->isNotEmpty())
                    <section class="mt-12">
                        <h2 class="mb-6 text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.exam.related') }}</h2>
                        <div class="grid gap-4 sm:grid-cols-3">
                            @foreach ($relatedExams as $related)
                                <a href="{{ \App\Support\LocaleUrls::url('exams.show', ['slug' => $related->slug]) }}" class="glass-card block p-4 transition hover:-translate-y-1">
                                    <p class="font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $related->name }}</p>
                                    <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ trans_choice('ui.home.questions_count', $related->questions_count) }}</p>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
        </section>
    </main>
@endsection
