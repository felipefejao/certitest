@extends('layouts.app')

@section('title', 'Confirmar envio — CertiTest')

@section('content')
    <main class="min-h-screen">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#fff0ed] via-[#fffaf6] to-[#f0f9ff] dark:from-[#1a0a05] dark:via-[#0a0a0a] dark:to-[#0a0a0a]"></div>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-xl">
                <div class="glass-card p-8 text-center">
                    <h1 class="mb-4 text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Tem certeza que deseja finalizar?</h1>

                    <p class="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
                        Você respondeu <strong class="text-[#1b1b18] dark:text-[#EDEDEC]">{{ $answeredCount }}</strong> de <strong class="text-[#1b1b18] dark:text-[#EDEDEC]">{{ $attempt->total_questions }}</strong> questões.
                    </p>

                    <p class="mb-8 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Questões não respondidas serão consideradas incorretas.
                    </p>

                    <div class="flex flex-col gap-4 sm:flex-row sm:justify-center">
                        <a
                            href="{{ route('attempts.question', ['attempt' => $attempt, 'index' => 0]) }}"
                            class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] bg-white/80 px-8 py-3 text-sm font-medium text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
                        >
                            Voltar
                        </a>

                        <form method="POST" action="{{ route('attempts.submit', $attempt) }}" class="inline-flex">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex w-full items-center justify-center rounded-lg bg-[#f53003] px-8 py-3 text-sm font-medium text-white shadow-lg transition hover:bg-[#d62b04] dark:bg-[#FF4433] dark:hover:bg-[#f53003]"
                            >
                                Finalizar prova
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
