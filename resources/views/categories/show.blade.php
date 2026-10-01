@extends('layouts.app')

@section('title', $metaTitle ?? $category->name.' — CertiTest')
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
            <div class="mx-auto max-w-6xl">
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

                <div class="mb-12">
                    <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $category->name }}</h1>
                    @if ($category->description)
                        <div class="mt-4 max-w-3xl space-y-4 text-[#3f3f3a] dark:text-[#A1A09A]">
                            {!! nl2br(e($category->description)) !!}
                        </div>
                    @endif
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($exams as $exam)
                        <article class="glass-card flex flex-col p-6 transition hover:-translate-y-1">
                            <div class="mb-4 flex items-center justify-between gap-3">
                                <h2 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $exam->name }}</h2>
                                <span class="shrink-0 rounded-full bg-[#f53003]/10 px-2.5 py-0.5 text-xs font-medium text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                                    {{ trans_choice('ui.home.questions_count', $exam->questions_count) }}
                                </span>
                            </div>
                            <p class="mb-6 flex-1 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ $exam->description }}</p>
                            <a
                                href="{{ \App\Support\LocaleUrls::url('exams.show', ['slug' => $exam->slug]) }}"
                                class="mt-auto inline-flex w-full items-center justify-center rounded-lg bg-[#1b1b18] py-2.5 text-sm font-semibold text-white transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                            >
                                {{ __('ui.home.start_exam') }}
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection
