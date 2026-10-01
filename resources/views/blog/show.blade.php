@extends('layouts.app')

@section('title', $metaTitle ?? $post->title.' — CertiTest')
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

        <article class="px-6 py-20">
            <div class="mx-auto max-w-3xl">
                <nav aria-label="breadcrumb" class="mb-8">
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

                <h1 class="text-4xl font-bold tracking-tight text-[#1b1b18] dark:text-[#EDEDEC]">{{ $post->title }}</h1>

                @if ($post->published_at)
                    <time datetime="{{ $post->published_at->toDateString() }}" class="mt-4 block text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        {{ __('ui.blog.published_on', ['date' => $post->published_at->translatedFormat('d M Y')]) }}
                    </time>
                @endif

                <div class="prose mt-10 max-w-none text-[#3f3f3a] dark:text-[#A1A09A]">
                    {!! Illuminate\Support\Str::markdown($post->body) !!}
                </div>
            </div>
        </article>
    </main>
@endsection
