@extends('layouts.app')

@section('title', __('ui.verify_email.meta_title'))
@section('meta_robots', 'noindex')

@section('content')
    <main class="flex min-h-screen items-center justify-center px-6 py-20">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#fff0ed] via-[#fffaf6] to-[#f0f9ff] dark:from-[#1a0a05] dark:via-[#0a0a0a] dark:to-[#0a0a0a]"></div>

        <div class="absolute right-6 top-4">
            <x-language-selector />
        </div>

        <div class="w-full max-w-md">
            <div class="glass-card p-8">
                <div class="mb-8 text-center">
                    <h1 class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ __('ui.verify_email.heading') }}</h1>
                    <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ __('ui.verify_email.subtitle', ['email' => auth()->user()->email]) }}</p>
                </div>

                @if (session('status'))
                    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-400">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-[#1b1b18] py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
                    >
                        {{ __('ui.verify_email.resend') }}
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    <button
                        type="submit"
                        form="verify-email-logout"
                        class="font-medium text-[#f53003] hover:underline dark:text-[#FF4433]"
                    >
                        {{ __('ui.verify_email.logout') }}
                    </button>
                </p>
            </div>
        </div>
    </main>

    <form id="verify-email-logout" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>
@endsection
