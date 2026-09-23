@extends('layouts.app')

@section('title', 'CertiTest — Teste seus conhecimentos e prepare-se para certificações')
@section('description', 'Faça simulados, descubra seu desempenho e prepare-se melhor para suas próximas certificações com o CertiTest.')

@section('content')
    <main class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#fff0ed] via-[#fffaf6] to-[#f0f9ff] dark:from-[#1a0a05] dark:via-[#0a0a0a] dark:to-[#0a0a0a]"></div>

        <nav class="px-6 py-4">
            <div class="mx-auto flex max-w-6xl items-center justify-between">
                <span class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">CertiTest</span>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-[#1b1b18] hover:text-[#f53003] dark:text-[#EDEDEC] dark:hover:text-[#FF4433]">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-[#1b1b18] hover:text-[#f53003] dark:text-[#EDEDEC] dark:hover:text-[#FF4433]">Sair</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-[#1b1b18] hover:text-[#f53003] dark:text-[#EDEDEC] dark:hover:text-[#FF4433]">Entrar</a>
                        <a href="{{ route('register') }}" class="rounded-lg bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white">Cadastrar</a>
                    @endauth
                </div>
            </div>
        </nav>

        <section class="px-6 pt-12 pb-24 lg:pt-24 lg:pb-40">
            <div class="mx-auto max-w-6xl">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#f53003]/20 bg-[#f53003]/5 px-4 py-1.5 text-sm font-medium text-[#f53003] dark:bg-[#f53003]/10 dark:text-[#FF4433]">
                            <span class="h-2 w-2 rounded-full bg-[#f53003]"></span>
                            Plataforma de simulados premium
                        </div>

                        <h1 class="text-5xl font-bold tracking-tight text-[#1b1b18] dark:text-[#EDEDEC] lg:text-7xl">
                            Teste seus<br />
                            <span class="text-[#f53003] dark:text-[#FF4433]">conhecimentos.</span>
                        </h1>

                        <p class="max-w-lg text-lg leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">
                            Prepare-se para certificações, provas e desafios profissionais com simulados que mostram onde você realmente precisa melhorar.
                        </p>

                        <div class="flex flex-col gap-4 sm:flex-row">
                            <a
                                href="{{ Route::has('register') ? route('register') : url('/register') }}"
                                class="inline-flex items-center justify-center rounded-lg bg-[#1b1b18] px-8 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                            >
                                Começar agora
                            </a>
                            <a
                                href="#exams"
                                class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] bg-white/80 px-8 py-3.5 text-sm font-semibold text-[#1b1b18] backdrop-blur transition hover:border-[#f53003]/30 hover:bg-white dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC] dark:hover:bg-[#1a1a19]"
                            >
                                Explorar simulados
                            </a>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute -inset-4 -z-10 rounded-full bg-[#f53003]/10 blur-3xl dark:bg-[#f53003]/15"></div>

                        <div class="glass-card p-8 lg:p-10">
                            <div class="mb-6 flex items-center justify-between">
                                <span class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Simulado em andamento</span>
                                <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-400">85% concluído</span>
                            </div>

                            <div class="space-y-4">
                                <p class="text-lg font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Qual alternativa representa corretamente o padrão Repository no Laravel?</p>

                                <div class="space-y-3">
                                    <div class="flex items-center gap-3 rounded-lg border border-[#e3e3e0] bg-white/50 p-3 dark:border-[#3E3E3A] dark:bg-[#161615]/50">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full border border-[#e3e3e0] text-xs font-semibold dark:border-[#3E3E3A]">A</span>
                                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">Uma camada de abstração do banco de dados</span>
                                    </div>
                                    <div class="flex items-center gap-3 rounded-lg border border-[#f53003] bg-[#f53003]/5 p-3 dark:border-[#FF4433] dark:bg-[#FF4433]/10">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#f53003] text-xs font-semibold text-white dark:bg-[#FF4433]">B</span>
                                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">Um facade para envio de e-mails</span>
                                    </div>
                                    <div class="flex items-center gap-3 rounded-lg border border-[#e3e3e0] bg-white/50 p-3 dark:border-[#3E3E3A] dark:bg-[#161615]/50">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full border border-[#e3e3e0] text-xs font-semibold dark:border-[#3E3E3A]">C</span>
                                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">Um middleware de autenticação</span>
                                    </div>
                                    <div class="flex items-center gap-3 rounded-lg border border-[#e3e3e0] bg-white/50 p-3 dark:border-[#3E3E3A] dark:bg-[#161615]/50">
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full border border-[#e3e3e0] text-xs font-semibold dark:border-[#3E3E3A]">D</span>
                                        <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">Um componente Livewire</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="mb-2 flex items-center justify-between text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    <span>Progresso</span>
                                    <span>Questão 12 de 50</span>
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-[#e3e3e0] dark:bg-[#3E3E3A]">
                                    <div class="h-full w-[24%] rounded-full bg-[#f53003] dark:bg-[#FF4433]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-6xl">
                <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Como funciona</h2>
                    <p class="mt-3 text-[#706f6c] dark:text-[#A1A09A]">Três passos simples para acelerar sua preparação.</p>
                </div>

                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="glass-card p-8 text-center">
                        <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#f53003]/10 text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125V9.375m-7.5 10.5V6.375a1.125 1.125 0 011.125-1.125h6.375c.621 0 1.125.504 1.125 1.125v11.25" /></svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">1. Escolha seu simulado</h3>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Navegue pelos simulados disponíveis e escolha a prova que você quer treinar.</p>
                    </div>

                    <div class="glass-card p-8 text-center">
                        <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#f53003]/10 text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">2. Teste seus conhecimentos</h3>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Responda as questões no seu ritmo e navegue entre elas antes de finalizar.</p>
                    </div>

                    <div class="glass-card p-8 text-center">
                        <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#f53003]/10 text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" /></svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">3. Veja seu resultado</h3>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Receba o resultado imediato com acertos, erros e percentual de aproveitamento.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-6xl">
                <div class="grid gap-12 lg:grid-cols-2">
                    <div>
                        <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Por que usar o CertiTest?</h2>
                        <p class="mt-3 text-[#706f6c] dark:text-[#A1A09A]">Uma experiência pensada para quem quer ir além na preparação.</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Simulados práticos</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Questões elaboradas para simular provas reais.</p>
                        </div>
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Resultado instantâneo</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Correção imediata assim que você finaliza.</p>
                        </div>
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Histórico de desempenho</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Acompanhe sua evolução ao longo do tempo.</p>
                        </div>
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Preparação focada</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Saiba exatamente em quais tópicos precisa melhorar.</p>
                        </div>
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Experiência responsiva</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Estude no desktop, tablet ou celular com o mesmo conforto.</p>
                        </div>
                        <div class="glass-card p-6">
                            <h3 class="mb-2 font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Compartilhamento</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Compartilhe seus resultados nas redes sociais.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="exams" class="px-6 py-20">
            <div class="mx-auto max-w-6xl">
                <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Provas disponíveis</h2>
                    <p class="mt-3 text-[#706f6c] dark:text-[#A1A09A]">Escolha um simulado e comece a praticar agora mesmo.</p>
                </div>

                @if ($exams->isNotEmpty())
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($exams as $exam)
                            <article class="glass-card flex flex-col p-6 transition hover:-translate-y-1">
                                <div class="mb-4 flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $exam['name'] }}</h3>
                                    <span class="rounded-full bg-[#f53003]/10 px-2.5 py-0.5 text-xs font-medium text-[#f53003] dark:bg-[#f53003]/15 dark:text-[#FF4433]">
                                        {{ $exam['questions_count'] }} questões
                                    </span>
                                </div>
                                <p class="mb-6 flex-1 text-sm leading-relaxed text-[#706f6c] dark:text-[#A1A09A]">{{ $exam['description'] }}</p>
                                <a
                                    href="{{ Route::has('exams.show') ? route('exams.show', $exam['slug']) : url('/exams/'.$exam['slug']) }}"
                                    class="mt-auto inline-flex w-full items-center justify-center rounded-lg bg-[#1b1b18] py-2.5 text-sm font-semibold text-white transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                                >
                                    Começar simulado
                                </a>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="glass-card py-16 text-center">
                        <p class="text-lg font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Nenhum simulado publicado no momento.</p>
                        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">Volte em breve para conferir as novidades.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-6xl">
                <div class="grid gap-8 text-center sm:grid-cols-3">
                    <div class="glass-card p-8">
                        <p class="text-4xl font-bold text-[#f53003] dark:text-[#FF4433]">+{{ number_format($stats['questions'], 0, ',', '.') }}</p>
                        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">Questões respondidas</p>
                    </div>
                    <div class="glass-card p-8">
                        <p class="text-4xl font-bold text-[#f53003] dark:text-[#FF4433]">+{{ number_format($stats['exams'], 0, ',', '.') }}</p>
                        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">Simulados</p>
                    </div>
                    <div class="glass-card p-8">
                        <p class="text-4xl font-bold text-[#f53003] dark:text-[#FF4433]">+{{ number_format($stats['attempts'], 0, ',', '.') }}</p>
                        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">Candidatos</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="px-6 py-20">
            <div class="mx-auto max-w-4xl">
                <div class="glass-card p-10 text-center lg:p-16">
                    <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Pronto para descobrir o quanto você sabe?</h2>
                    <p class="mx-auto mt-4 max-w-xl text-[#706f6c] dark:text-[#A1A09A]">Comece seu primeiro simulado agora e veja seu desempenho em tempo real.</p>
                    <a
                        href="{{ Route::has('register') ? route('register') : url('/register') }}"
                        class="mt-8 inline-flex items-center justify-center rounded-lg bg-[#f53003] px-10 py-4 text-base font-semibold text-white shadow-lg transition hover:bg-[#d62b04] dark:bg-[#FF4433] dark:hover:bg-[#f53003]"
                    >
                        Começar agora
                    </a>
                </div>
            </div>
        </section>

        <footer class="border-t border-[#e3e3e0] px-6 py-10 dark:border-[#3E3E3A]">
            <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 text-sm text-[#706f6c] dark:text-[#A1A09A] sm:flex-row">
                <p>&copy; {{ date('Y') }} CertiTest. Todos os direitos reservados.</p>
                <div class="flex gap-6">
                    <a href="#" class="transition hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">Termos de uso</a>
                    <a href="#" class="transition hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">Privacidade</a>
                </div>
            </div>
        </footer>
    </main>
@endsection
