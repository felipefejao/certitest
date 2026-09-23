@extends('layouts.app')

@section('title', 'Entrar — CertiTest')

@section('content')
    <main class="flex min-h-screen items-center justify-center px-6 py-20">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#fff0ed] via-[#fffaf6] to-[#f0f9ff] dark:from-[#1a0a05] dark:via-[#0a0a0a] dark:to-[#0a0a0a]"></div>

        <div class="w-full max-w-md">
            <div class="glass-card p-8">
                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Bem-vindo de volta</h1>
                    <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">Entre para continuar sua preparação.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">E-mail</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full rounded-lg border border-[#e3e3e0] bg-white/80 px-4 py-2.5 text-[#1b1b18] placeholder-[#706f6c] outline-none transition focus:border-[#f53003] focus:ring-2 focus:ring-[#f53003]/20 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
                            placeholder="seu@email.com"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Senha</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="w-full rounded-lg border border-[#e3e3e0] bg-white/80 px-4 py-2.5 text-[#1b1b18] placeholder-[#706f6c] outline-none transition focus:border-[#f53003] focus:ring-2 focus:ring-[#f53003]/20 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
                            placeholder="••••••••"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-[#e3e3e0] text-[#f53003] focus:ring-[#f53003]/20 dark:border-[#3E3E3A]">
                            Lembrar-me
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-[#1b1b18] py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                    >
                        Entrar
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    Ainda não tem conta?
                    <a href="{{ route('register') }}" class="font-medium text-[#f53003] hover:underline dark:text-[#FF4433]">Cadastre-se</a>
                </p>
            </div>
        </div>
    </main>
@endsection
