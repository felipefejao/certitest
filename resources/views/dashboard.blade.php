@extends('layouts.app')

@section('title', 'Dashboard — CertiTest')

@section('content')
    <main class="min-h-screen">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#fff0ed] via-[#fffaf6] to-[#f0f9ff] dark:from-[#1a0a05] dark:via-[#0a0a0a] dark:to-[#0a0a0a]"></div>

        <nav class="border-b border-[#e3e3e0] bg-white/80 px-6 py-4 backdrop-blur dark:border-[#3E3E3A] dark:bg-[#161615]/80">
            <div class="mx-auto flex max-w-6xl items-center justify-between">
                <a href="{{ route('home') }}" class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">CertiTest</a>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ $user->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-[#f53003] hover:underline dark:text-[#FF4433]">Sair</button>
                    </form>
                </div>
            </div>
        </nav>

        <section class="px-6 py-12">
            <div class="mx-auto max-w-6xl">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Olá, {{ $user->name }} 👋</h1>
                    <p class="mt-2 text-[#706f6c] dark:text-[#A1A09A]">Continue sua preparação.</p>
                </div>

                <div class="mb-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="glass-card p-6">
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Provas realizadas</p>
                        <p class="mt-2 text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $stats['exams_taken'] }}</p>
                    </div>
                    <div class="glass-card p-6">
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Média geral</p>
                        <p class="mt-2 text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $stats['average'] }}%</p>
                    </div>
                    <div class="glass-card p-6">
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Melhor resultado</p>
                        <p class="mt-2 text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $stats['best_score'] }}%</p>
                    </div>
                    <div class="glass-card p-6">
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Último resultado</p>
                        <p class="mt-2 text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $stats['last_score'] }}%</p>
                    </div>
                </div>

                <div class="mb-12 grid gap-8 lg:grid-cols-3">
                    <div class="lg:col-span-2">
                        <h2 class="mb-4 text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Provas disponíveis</h2>

                        @if ($availableExams->isNotEmpty())
                            <div class="grid gap-4 sm:grid-cols-2">
                                @foreach ($availableExams as $exam)
                                    <article class="glass-card flex flex-col p-6">
                                        <div class="mb-3 flex items-center justify-between">
                                            <h3 class="font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $exam['name'] }}</h3>
                                            <span class="rounded-full bg-[#f53003]/10 px-2.5 py-0.5 text-xs font-medium text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                                                {{ $exam['questions_count'] }} questões
                                            </span>
                                        </div>
                                        <p class="mb-4 flex-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ $exam['description'] }}</p>
                                        <a
                                            href="{{ route('exams.show', $exam['slug']) }}"
                                            class="inline-flex w-full items-center justify-center rounded-lg bg-[#1b1b18] py-2.5 text-sm font-semibold text-white transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                                        >
                                            Começar simulado
                                        </a>
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="glass-card py-10 text-center">
                                <p class="text-[#706f6c] dark:text-[#A1A09A]">Nenhuma prova disponível no momento.</p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <h2 class="mb-4 text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Resumo</h2>
                        <div class="glass-card p-6">
                            @if ($stats['exams_taken'] > 0)
                                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                    Você realizou {{ $stats['exams_taken'] }} {{ $stats['exams_taken'] === 1 ? 'simulado' : 'simulados' }}.
                                </p>
                                <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                    Sua melhor nota foi {{ $stats['best_score'] }}%.
                                </p>
                            @else
                                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Você ainda não realizou nenhum simulado.</p>
                            @endif
                            <a href="#exams" class="mt-4 inline-flex w-full items-center justify-center rounded-lg border border-[#e3e3e0] py-2.5 text-sm font-semibold text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:text-[#EDEDEC]">
                                {{ $stats['exams_taken'] > 0 ? 'Fazer outro simulado' : 'Continuar estudando' }}
                            </a>

                            <x-share-result
                                :title="'Meu desempenho no CertiTest'"
                                :description="$stats['exams_taken'] > 0
                                    ? 'No CertiTest realizei '.$stats['exams_taken'].' '.($stats['exams_taken'] === 1 ? 'simulado' : 'simulados').', com média de '.$stats['average'].'% e melhor resultado de '.$stats['best_score'].'%!'
                                    : 'Ainda não fiz simulados no CertiTest. Vamos praticar juntos?'"
                                :url="route('home')"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
