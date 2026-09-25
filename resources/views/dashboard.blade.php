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
                    <div class="lg:col-span-2" id="exams">
                        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                            <h2 class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Provas disponíveis</h2>

                            @if ($categories->isNotEmpty())
                                <form method="GET" action="{{ route('dashboard') }}#exams">
                                    <select
                                        name="categoria"
                                        onchange="this.form.submit()"
                                        class="rounded-lg border border-[#e3e3e0] bg-white/80 px-4 py-2 text-sm font-medium text-[#1b1b18] outline-none transition focus:border-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC] dark:focus:border-[#FF4433]"
                                    >
                                        <option value="">Todas as categorias</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            @endif
                        </div>

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
                                        @if ($exam['category'])
                                            <span class="mb-2 inline-flex w-fit rounded-full border border-[#e3e3e0] px-2.5 py-0.5 text-xs font-medium text-[#706f6c] dark:border-[#3E3E3A] dark:text-[#A1A09A]">
                                                {{ $exam['category'] }}
                                            </span>
                                        @endif
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

                <div class="mb-12">
                    <h2 class="mb-4 text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Provas realizadas</h2>

                    <div class="glass-card overflow-hidden">
                        @if ($finishedAttempts->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead class="border-b border-[#e3e3e0] bg-[#FDFDFC] dark:border-[#3E3E3A] dark:bg-[#0a0a0a]">
                                        <tr>
                                            <th class="px-6 py-3 font-medium text-[#706f6c] dark:text-[#A1A09A]">Data</th>
                                            <th class="px-6 py-3 font-medium text-[#706f6c] dark:text-[#A1A09A]">Prova</th>
                                            <th class="px-6 py-3 font-medium text-[#706f6c] dark:text-[#A1A09A]">Resultado</th>
                                            <th class="px-6 py-3 text-right font-medium text-[#706f6c] dark:text-[#A1A09A]"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#e3e3e0] dark:divide-[#3E3E3A]">
                                        @foreach ($finishedAttempts as $attempt)
                                            <tr>
                                                <td class="whitespace-nowrap px-6 py-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                                                    {{ $attempt->finished_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td class="px-6 py-4 text-[#1b1b18] dark:text-[#EDEDEC]">{{ $attempt->exam->name }}</td>
                                                <td class="px-6 py-4 font-semibold text-[#f53003] dark:text-[#FF4433]">{{ $attempt->percentage }}%</td>
                                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                                    <a
                                                        href="{{ route('attempts.result', $attempt) }}"
                                                        class="inline-flex items-center gap-1 rounded-lg border border-[#e3e3e0] bg-white px-3 py-1.5 text-xs font-medium text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
                                                    >
                                                        Ver resultado
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="px-6 py-10 text-center">
                                <p class="text-[#706f6c] dark:text-[#A1A09A]">Você ainda não realizou nenhuma prova.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
