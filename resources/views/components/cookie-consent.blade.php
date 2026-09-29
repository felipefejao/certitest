@props([
    'gaId' => null,
    'adsenseClient' => null,
])

<div
    id="certitest-consent"
    data-ga-id="{{ $gaId }}"
    data-adsense-client="{{ $adsenseClient }}"
    role="dialog"
    aria-label="{{ __('ui.consent.title') }}"
    class="fixed inset-x-0 bottom-0 z-50 hidden border-t border-[#e3e3e0] bg-white/95 px-6 py-4 shadow-lg backdrop-blur dark:border-[#3E3E3A] dark:bg-[#161615]/95"
>
    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 sm:flex-row">
        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
            {{ __('ui.consent.message') }}
            <a href="{{ route('privacy') }}" class="font-medium text-[#1b1b18] underline underline-offset-2 transition hover:text-[#f53003] dark:text-[#EDEDEC] dark:hover:text-[#FF4433]">
                {{ __('ui.consent.policy_link') }}
            </a>
        </p>
        <div class="flex shrink-0 gap-3">
            <button
                type="button"
                data-consent="reject"
                class="inline-flex items-center justify-center rounded-lg border border-[#e3e3e0] bg-white px-6 py-2.5 text-sm font-semibold text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]"
            >
                {{ __('ui.consent.reject') }}
            </button>
            <button
                type="button"
                data-consent="accept"
                class="inline-flex items-center justify-center rounded-lg bg-[#1b1b18] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
            >
                {{ __('ui.consent.accept') }}
            </button>
        </div>
    </div>
</div>
