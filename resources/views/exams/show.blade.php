@extends('layouts.app')

@section('title', $exam['name'].' — CertiTest')

@section('content')
    <main class="min-h-screen">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#fff0ed] via-[#fffaf6] to-[#f0f9ff] dark:from-[#1a0a05] dark:via-[#0a0a0a] dark:to-[#0a0a0a]"></div>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-2xl">
                <a href="{{ route('dashboard') }}" class="mb-6 inline-flex items-center gap-1 text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]">
                    ← Voltar
                </a>

                <div class="glass-card p-8">
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                        <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $exam['name'] }}</h1>
                        <span class="rounded-full bg-[#f53003]/10 px-3 py-1 text-sm font-medium text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                            {{ $exam['questions_count'] }} questões
                        </span>
                    </div>

                    <p class="mb-8 text-[#706f6c] dark:text-[#A1A09A]">{{ $exam['description'] }}</p>

                    <div class="mb-8 rounded-xl border border-[#e3e3e0] bg-white/50 p-6 dark:border-[#3E3E3A] dark:bg-[#161615]/50">
                        <h2 class="mb-4 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Antes de começar</h2>
                        <ul class="space-y-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#f53003]"></span>
                                Você poderá navegar entre as questões antes de finalizar.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#f53003]"></span>
                                O tempo não é cronometrado.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#f53003]"></span>
                                Questões não respondidas serão consideradas incorretas.
                            </li>
                        </ul>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a
                            href="{{ route('exams.start', $exam['slug']) }}"
                            class="inline-flex items-center justify-center rounded-lg bg-[#1b1b18] px-8 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                        >
                            Começar simulado
                        </a>
                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] bg-white/80 px-8 py-3.5 text-sm font-semibold text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
                        >
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
