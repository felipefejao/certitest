@php
    $locales = [
        'pt_BR' => 'Português',
        'en' => 'English',
        'de' => 'Deutsch',
        'fr' => 'Français',
    ];
@endphp

<select
    aria-label="{{ __('ui.language') }}"
    onchange="if (this.value) { window.location.href = this.value; }"
    class="rounded-lg border border-[#e3e3e0] bg-white/80 px-2.5 py-1.5 text-sm font-medium text-[#1b1b18] outline-none transition focus:border-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC] dark:focus:border-[#FF4433]"
>
    @foreach ($locales as $locale => $label)
        <option
            value="{{ route('locale.update', ['locale' => $locale, 'redirect' => request()->getRequestUri()]) }}"
            @selected(app()->getLocale() === $locale)
        >
            {{ $label }}
        </option>
    @endforeach
</select>
