<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="630" viewBox="0 0 1200 630">
    <defs>
        <pattern id="guilloche" width="18" height="44" patternUnits="userSpaceOnUse">
            <path d="M0 4 a9 9 0 0 1 18 0" fill="none" stroke="#b3a48c" stroke-width="1"/>
            <path d="M0 14 a9 9 0 0 0 18 0" fill="none" stroke="#b3a48c" stroke-width="1"/>
            <path d="M0 24 a9 9 0 0 1 18 0" fill="none" stroke="#b3a48c" stroke-width="1"/>
            <path d="M0 34 a9 9 0 0 0 18 0" fill="none" stroke="#b3a48c" stroke-width="1"/>
            <path d="M0 44 a9 9 0 0 1 18 0" fill="none" stroke="#b3a48c" stroke-width="1"/>
        </pattern>
        <pattern id="guillocheV" width="44" height="18" patternUnits="userSpaceOnUse">
            <path d="M4 0 a9 9 0 0 0 0 18" fill="none" stroke="#b3a48c" stroke-width="1"/>
            <path d="M14 0 a9 9 0 0 1 0 18" fill="none" stroke="#b3a48c" stroke-width="1"/>
            <path d="M24 0 a9 9 0 0 0 0 18" fill="none" stroke="#b3a48c" stroke-width="1"/>
            <path d="M34 0 a9 9 0 0 1 0 18" fill="none" stroke="#b3a48c" stroke-width="1"/>
            <path d="M44 0 a9 9 0 0 0 0 18" fill="none" stroke="#b3a48c" stroke-width="1"/>
        </pattern>
        <g id="corner" fill="none" stroke="#9a8a70" stroke-width="1.5">
            <rect x="2" y="2" width="42" height="42"/>
            <rect x="9" y="9" width="28" height="28"/>
            <path d="M16 30 V16 h14 v7 h-7"/>
        </g>
    </defs>

    <rect width="1200" height="630" fill="#f6f1e7"/>

    <rect x="55" y="8" width="1090" height="42" fill="url(#guilloche)"/>
    <rect x="55" y="580" width="1090" height="42" fill="url(#guilloche)"/>
    <rect x="8" y="55" width="42" height="520" fill="url(#guillocheV)"/>
    <rect x="1150" y="55" width="42" height="520" fill="url(#guillocheV)"/>

    <use href="#corner" x="8" y="8"/>
    <use href="#corner" transform="translate(1192, 8) scale(-1, 1)"/>
    <use href="#corner" transform="translate(8, 622) scale(1, -1)"/>
    <use href="#corner" transform="translate(1192, 622) scale(-1, -1)"/>

    <rect x="55" y="55" width="1090" height="520" fill="none" stroke="#9a8a70" stroke-width="2"/>
    <rect x="63" y="63" width="1074" height="504" fill="none" stroke="#9a8a70" stroke-width="1"/>

    <image href="{{ $logoDataUri }}" x="75" y="64" width="159" height="48" preserveAspectRatio="xMidYMid meet"/>

    <line x1="75" y1="125" x2="1125" y2="125" stroke="#c8bca6" stroke-width="1.5"/>

    <text x="75" y="152" font-family="Georgia, 'Times New Roman', serif" font-size="15" letter-spacing="3" fill="#7a6f5c">{{ __('ui.certificate.heading') }}</text>
    <text x="1125" y="152" text-anchor="end" font-family="Arial, Helvetica, sans-serif" font-size="15" font-weight="bold" fill="#2e2e2e">{{ __('ui.certificate.candidate') }} {{ $candidateName }}</text>

    @foreach ($titleLines as $line)
        <text x="600" y="{{ 240 + $loop->index * 52 }}" text-anchor="middle" font-family="Georgia, 'Times New Roman', serif" font-size="40" fill="#3a3428">{{ $line }}</text>
    @endforeach

    <text x="{{ $scoreX }}" y="400" font-family="Georgia, 'Times New Roman', serif" font-size="115" font-weight="bold" fill="#c2573a">{{ $score }}</text>

    <rect x="{{ $barX }}" y="347" width="{{ $barWidth }}" height="24" rx="12" fill="#d8cfc0"/>
    @if ($total > 0)
        <rect x="{{ $barX }}" y="347" width="{{ $barWidth * ($correct / $total) }}" height="24" rx="12" fill="#c2573a"/>
    @endif

    <text x="600" y="435" text-anchor="middle" font-family="Georgia, 'Times New Roman', serif" font-size="24" fill="#3a3428">{{ __('ui.certificate.score_line', ['correct' => $correct, 'total' => $total]) }}</text>
    <text x="600" y="472" text-anchor="middle" font-family="Georgia, 'Times New Roman', serif" font-size="22" fill="#3a3428">{{ __('ui.certificate.tagline') }}</text>

    <path d="M140 478 q6 -6 12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0" fill="none" stroke="#3a3428" stroke-width="1.5"/>
    <image href="{{ $logoDataUri }}" x="140" y="424" width="179" height="54" preserveAspectRatio="xMinYMax meet"/>
    <text x="140" y="500" font-family="Arial, Helvetica, sans-serif" font-size="13" fill="#7a6f5c">{{ __('ui.certificate.examiner') }}</text>

    <text x="1060" y="500" text-anchor="end" font-family="Arial, Helvetica, sans-serif" font-size="15" fill="#3a3428">{{ __('ui.certificate.date') }} {{ $date }}</text>
</svg>
