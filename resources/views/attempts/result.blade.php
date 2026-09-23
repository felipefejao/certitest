@extends('layouts.app')

@section('title', 'Resultado — '.$exam['name'])

@section('content')
    <main class="min-h-screen">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#fff0ed] via-[#fffaf6] to-[#f0f9ff] dark:from-[#1a0a05] dark:via-[#0a0a0a] dark:to-[#0a0a0a]"></div>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-2xl">
                <div class="glass-card p-8 text-center lg:p-12">
                    <h1 class="mb-2 text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Simulado concluído!</h1>
                    <p class="mb-8 text-[#706f6c] dark:text-[#A1A09A]">{{ $exam['name'] }}</p>

                    <div class="mb-8 flex items-center justify-center">
                        <div class="relative h-40 w-40">
                            <svg class="h-full w-full -rotate-90" viewBox="0 0 36 36">
                                <path class="text-[#e3e3e0] dark:text-[#3E3E3A]" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                                <path class="text-[#f53003] dark:text-[#FF4433]" stroke-dasharray="{{ $attempt->percentage }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $attempt->percentage }}%</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="rounded-xl bg-white/50 p-4 dark:bg-[#161615]/50">
                            <p class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $attempt->total_questions }}</p>
                            <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Total de questões</p>
                        </div>
                        <div class="rounded-xl bg-green-50 p-4 dark:bg-green-900/20">
                            <p class="text-2xl font-bold text-green-700 dark:text-green-400">{{ $attempt->correct_answers }}</p>
                            <p class="text-xs text-green-700 dark:text-green-400">Acertos</p>
                        </div>
                        <div class="rounded-xl bg-red-50 p-4 dark:bg-red-900/20">
                            <p class="text-2xl font-bold text-red-700 dark:text-red-400">{{ $attempt->wrong_answers }}</p>
                            <p class="text-xs text-red-700 dark:text-red-400">Erros</p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:justify-center">
                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-[#1b1b18] px-8 py-3 text-sm font-medium text-white transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                        >
                            Voltar ao dashboard
                        </a>
                        <a
                            href="{{ route('home') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] bg-white/80 px-8 py-3 text-sm font-medium text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
                        >
                            Fazer outro simulado
                        </a>
                    </div>

                    <div class="shareable-card mt-8 overflow-hidden rounded-2xl border border-[#e3e3e0] bg-white/80 shadow-sm dark:border-[#3E3E3A] dark:bg-[#161615]/80">
                        <img
                            src="{{ route('results.image', $attempt->public_token) }}"
                            alt="Card de resultado do CertiTest"
                            class="w-full"
                            loading="lazy"
                        >
                        <div class="flex items-center justify-between gap-4 border-t border-[#e3e3e0] p-4 dark:border-[#3E3E3A]">
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Compartilhe seu resultado</p>
                            <a
                                href="{{ route('results.image', $attempt->public_token) }}"
                                download="resultado-certitest.png"
                                class="inline-flex items-center gap-2 rounded-lg border border-[#e3e3e0] bg-white px-4 py-2 text-sm font-medium text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
                            >
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Baixar imagem
                            </a>
                        </div>
                    </div>

                    <x-share-result
                        :title="'Meu resultado no CertiTest'"
                        :description="'Acabei de fazer o simulado '.$exam['name'].' no CertiTest e consegui '.round($attempt->percentage, 0).'% de aproveitamento! 🚀'.'\n'.'Teste seus conhecimentos também.'"
                        :url="route('results.public', $attempt->public_token)"
                    />
                </div>
            </div>
        </section>
    </main>
@endsection
