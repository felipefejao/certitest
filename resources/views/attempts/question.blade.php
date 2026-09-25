@extends('layouts.app')

@section('title', $exam['name'].' — Questão '.($index + 1))

@section('content')
    <main class="min-h-screen">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#fff0ed] via-[#fffaf6] to-[#f0f9ff] dark:from-[#1a0a05] dark:via-[#0a0a0a] dark:to-[#0a0a0a]"></div>

        <nav class="border-b border-[#e3e3e0] bg-white/80 px-6 py-4 backdrop-blur dark:border-[#3E3E3A] dark:bg-[#161615]/80">
            <div class="mx-auto flex max-w-5xl items-center justify-between">
                <div>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ $exam['name'] }}</p>
                    <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Questão {{ $index + 1 }} de {{ $total }}</p>
                </div>
                <a href="{{ route('attempts.confirm', $attempt) }}" class="text-sm font-medium text-[#f53003] hover:underline dark:text-[#FF4433]">Finalizar prova</a>
            </div>
        </nav>

        <section class="px-6 py-10">
            <div class="mx-auto max-w-5xl">
                <div class="mb-6">
                    <div class="mb-2 flex items-center justify-between text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        <span>Progresso</span>
                        <span>{{ round((($index + 1) / $total) * 100) }}%</span>
                    </div>
                    <div class="h-2.5 w-full overflow-hidden rounded-full bg-[#e3e3e0] dark:bg-[#3E3E3A]">
                        <div class="h-full rounded-full bg-[#f53003] transition-all duration-300 dark:bg-[#FF4433]" style="width: {{ (($index + 1) / $total) * 100 }}%"></div>
                    </div>
                </div>

                <details class="group mb-6">
                    <summary class="flex cursor-pointer list-none items-center justify-between rounded-lg border border-[#e3e3e0] bg-white/80 px-4 py-2.5 text-sm font-medium text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC] [&::-webkit-details-marker]:hidden">
                        <span>Visualizar questões</span>
                        <svg class="h-4 w-4 transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </summary>

                    <div class="mt-4 grid grid-cols-4 gap-2 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10">
                        @foreach ($progress as $item)
                            <a
                                href="{{ route('attempts.question', ['attempt' => $attempt, 'index' => $item['index']]) }}"
                                class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-medium transition
                                    {{ $item['index'] === $index ? 'bg-[#f53003] text-white dark:bg-[#FF4433]' : ($item['answered'] ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-white text-[#706f6c] dark:bg-[#161615] dark:text-[#A1A09A]') }}"
                            >
                                {{ $item['index'] + 1 }}
                            </a>
                        @endforeach
                    </div>
                </details>

                <div class="glass-card p-6 lg:p-10">
                    <h1 class="mb-8 text-xl font-semibold leading-relaxed text-[#1b1b18] dark:text-[#EDEDEC]">{{ $question['question'] }}</h1>

                    <form method="POST" action="{{ route('attempts.question', ['attempt' => $attempt, 'index' => $index]) }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $question['id'] }}">

                        @foreach ($question['options'] as $key => $option)
                            <label class="flex cursor-pointer items-center gap-4 rounded-xl border border-[#e3e3e0] bg-white/50 p-4 transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/50 {{ $selectedAnswer === $key ? 'border-[#f53003] bg-[#f53003]/5 dark:border-[#FF4433] dark:bg-[#FF4433]/10' : '' }}">
                                <input
                                    type="radio"
                                    name="selected_answer"
                                    value="{{ $key }}"
                                    {{ $selectedAnswer === $key ? 'checked' : '' }}
                                    class="h-5 w-5 border-[#e3e3e0] text-[#f53003] focus:ring-[#f53003]/20 dark:border-[#3E3E3A] dark:text-[#FF4433]"
                                >
                                <div>
                                    <span class="font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $key }}.</span>
                                    <span class="text-[#1b1b18] dark:text-[#EDEDEC]">{{ $option }}</span>
                                </div>
                            </label>
                        @endforeach

                        <div class="mt-8 flex items-center justify-between gap-4">
                            <a
                                href="{{ $index > 0 ? route('attempts.question', ['attempt' => $attempt, 'index' => $index - 1]) : route('attempts.question', ['attempt' => $attempt, 'index' => $index]) }}"
                                class="rounded-lg border border-[#e3e3e0] bg-white/80 px-6 py-2.5 text-sm font-medium text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
                            >
                                Anterior
                            </a>

                            <input type="hidden" name="next_index" value="{{ $index + 1 < $total ? $index + 1 : $index }}">

                            @if ($index + 1 < $total)
                                <button
                                    type="submit"
                                    class="rounded-lg bg-[#1b1b18] px-6 py-2.5 text-sm font-medium text-white transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                                >
                                    Próxima
                                </button>
                            @else
                                <button
                                    type="submit"
                                    formaction="{{ route('attempts.submit', $attempt) }}"
                                    class="rounded-lg bg-[#f53003] px-6 py-2.5 text-sm font-medium text-white transition hover:bg-[#d62b04] dark:bg-[#FF4433] dark:hover:bg-[#f53003]"
                                >
                                    Finalizar
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection
