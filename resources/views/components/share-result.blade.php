@props([
    'title' => null,
    'description' => null,
    'url' => null,
])

@php
    $shareUrl = $url ?? url()->current();
    $shareTitle = $title ?? 'CertiTest';
    $shareDescription = $description ?? 'Teste seus conhecimentos com o CertiTest.';
    $encodedUrl = urlencode($shareUrl);
    $encodedText = urlencode($shareDescription);
@endphp

<div
    class="share-result mt-6 rounded-2xl border border-[#e3e3e0] bg-white/50 p-4 dark:border-[#3E3E3A] dark:bg-[#161615]/50"
    data-share-url="{{ $shareUrl }}"
    data-share-title="{{ $shareTitle }}"
    data-share-text="{{ $shareDescription }}"
>
    <p class="mb-3 text-center text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Compartilhar</p>

    <div class="flex flex-wrap items-center justify-center gap-3">
        <a
            href="https://wa.me/?text={{ $encodedText }}%20{{ $encodedUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Compartilhar no WhatsApp"
            class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#25D366] text-white transition hover:scale-105 hover:opacity-90"
        >
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.521-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.521.074-.794.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26 9.87 9.87 0 0116.435-7.325 9.87 9.87 0 013.098 7.325 9.87 9.87 0 01-9.865 9.869m8.413-18.297A11.866 11.866 0 0012.225 0C5.535 0 .166 5.37.166 12.06a11.848 11.848 0 001.57 5.963L0 24l6.115-1.618a11.878 11.878 0 005.745 1.471h.003c6.59 0 12.056-5.37 12.056-12.063a11.96 11.96 0 00-3.493-8.413" />
            </svg>
        </a>

        <a
            href="https://twitter.com/intent/tweet?text={{ $encodedText }}&url={{ $encodedUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Compartilhar no X"
            class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#1b1b18] text-white transition hover:scale-105 hover:opacity-90 dark:bg-[#EDEDEC] dark:text-[#1C1C1A]"
        >
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L3.99 21.75H.68l7.73-8.835L.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L4.805 4.126H2.84z" />
            </svg>
        </a>

        <a
            href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Compartilhar no Facebook"
            class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#1877F2] text-white transition hover:scale-105 hover:opacity-90"
        >
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
            </svg>
        </a>

        <a
            href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encodedUrl }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Compartilhar no LinkedIn"
            class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#0A66C2] text-white transition hover:scale-105 hover:opacity-90"
        >
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
            </svg>
        </a>
    </div>

    <div class="mt-4 flex flex-wrap justify-center gap-2">
        <button
            type="button"
            class="share-copy-link inline-flex items-center gap-2 rounded-lg border border-[#e3e3e0] bg-white px-4 py-2 text-sm font-medium text-[#1b1b18] transition hover:border-[#f53003]/30 dark:border-[#3E3E3A] dark:bg-[#161615]/80 dark:text-[#EDEDEC]"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
            </svg>
            Copiar link
        </button>

        <button
            type="button"
            class="share-native-link inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] px-4 py-2 text-sm font-medium text-white transition hover:bg-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white"
            hidden
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 4.909A8 8 0 0119.288 7.4M7.217 4.909a8.003 8.003 0 00-1.4 11.4m0-11.4v3.6m0 0h3.6M16.783 19.091A8 8 0 014.712 16.6m12.071 2.491a8.003 8.003 0 001.4-11.4m0 11.4v-3.6m0 3.6h-3.6" />
            </svg>
            Compartilhar
        </button>
    </div>
</div>

@once('share-result-scripts')
    <script>
        (function () {
            document.querySelectorAll('.share-result').forEach(function (container) {
                const url = container.dataset.shareUrl;
                const text = container.dataset.shareText;
                const title = container.dataset.shareTitle;

                const copyBtn = container.querySelector('.share-copy-link');
                if (copyBtn) {
                    copyBtn.addEventListener('click', function () {
                        navigator.clipboard.writeText(text + ' ' + url).then(function () {
                            const original = copyBtn.textContent.trim();
                            copyBtn.textContent = 'Copiado!';
                            setTimeout(function () {
                                copyBtn.textContent = original;
                            }, 1500);
                        }).catch(function () {});
                    });
                }

                const nativeBtn = container.querySelector('.share-native-link');
                if (nativeBtn && typeof navigator.share === 'function') {
                    nativeBtn.hidden = false;
                    nativeBtn.addEventListener('click', function () {
                        navigator.share({ title: title, text: text, url: url }).catch(function () {});
                    });
                }
            });
        })();
    </script>
@endonce
