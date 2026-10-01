@extends('layouts.app')

@section('title', __('ui.blog.title').' — CertiTest')
@section('description', __('ui.blog.meta_description'))

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
                <a href="{{ \App\Support\LocaleUrls::url('home') }}" class="mb-6 inline-flex items-center gap-1 text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]">
                    ← {{ __('ui.blog.back_home') }}
                </a>

                <div class="mb-12">
                    <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.blog.title') }}</h1>
                    <p class="mt-4 max-w-3xl text-[#3f3f3a] dark:text-[#A1A09A]">{{ __('ui.blog.subtitle') }}</p>
                </div>

                @if ($posts->isEmpty())
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.blog.empty') }}</p>
                @else
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($posts as $post)
                            <article class="glass-card flex flex-col p-6 transition hover:-translate-y-1">
                                <h2 class="mb-3 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $post->title }}</h2>
                                @if ($post->published_at)
                                    <time datetime="{{ $post->published_at->toDateString() }}" class="mb-3 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                        {{ $post->published_at->translatedFormat('d M Y') }}
                                    </time>
                                @endif
                                <p class="mb-6 flex-1 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ $post->excerpt }}</p>
                                <a
                                    href="{{ \App\Support\LocaleUrls::url('blog.show', ['slug' => $post->slug]) }}"
                                    class="mt-auto inline-flex w-full items-center justify-center rounded-lg bg-[#1b1b18] py-2.5 text-sm font-semibold text-white transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                                >
                                    {{ __('ui.blog.read_more') }}
                                </a>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
