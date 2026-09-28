<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="630" viewBox="0 0 1200 630">
    <rect width="1200" height="630" fill="#f7f4ef"/>

    <rect x="60" y="60" width="1080" height="510" fill="none" stroke="#c8bfb2" stroke-width="2"/>
    <rect x="68" y="68" width="1064" height="494" fill="none" stroke="#c8bfb2" stroke-width="1"/>

    <g stroke="#c8bfb2" stroke-width="2">
        <line x1="60" y1="80" x2="80" y2="60"/><line x1="60" y1="92" x2="92" y2="60"/>
        <line x1="1120" y1="60" x2="1140" y2="80"/><line x1="1108" y1="60" x2="1140" y2="92"/>
        <line x1="60" y1="550" x2="80" y2="570"/><line x1="60" y1="538" x2="92" y2="570"/>
        <line x1="1120" y1="570" x2="1140" y2="550"/><line x1="1108" y1="570" x2="1140" y2="538"/>
    </g>

    <polygon points="107.5,78 130,87 123.25,105 107.5,123 91.75,105 85,87" fill="#2e2e2e"/>
    <polyline points="96.25,98.25 103,107.25 118.75,90.6" fill="none" stroke="#f7f4ef" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
    <text x="124" y="113" font-family="Arial, Helvetica, sans-serif" font-size="40" font-weight="bold" fill="#2e2e2e">CertiTest</text>

    <line x1="85" y1="145" x2="1115" y2="145" stroke="#dcd7cd" stroke-width="2"/>

    <text x="85" y="170" font-family="Arial, Helvetica, sans-serif" font-size="16" letter-spacing="3" fill="#645c52">OFFICIAL SIMULATED EXAM CERTIFICATE</text>
    <text x="1115" y="170" text-anchor="end" font-family="Arial, Helvetica, sans-serif" font-size="16" font-weight="bold" fill="#2e2e2e">CANDIDATE: {{ $candidateName }}</text>

    @foreach ($titleLines as $line)
        <text x="600" y="{{ 265 + $loop->index * 50 }}" text-anchor="middle" font-family="Arial, Helvetica, sans-serif" font-size="38" font-weight="bold" fill="#2e2e2e">{{ $line }}</text>
    @endforeach

    <text x="420" y="460" font-family="Arial, Helvetica, sans-serif" font-size="120" font-weight="bold" fill="#c44b2b">{{ sprintf('%.0f%%', $percentage) }}</text>

    <rect x="660" y="360" width="160" height="22" rx="11" fill="#dcdcdc"/>
    @if ($total > 0)
        <rect x="660" y="360" width="{{ 160 * ($correct / $total) }}" height="22" rx="11" fill="#c44b2b"/>
    @endif

    <text x="600" y="462" text-anchor="middle" font-family="Arial, Helvetica, sans-serif" font-size="26" fill="#645c52">{{ $correct }}/{{ $total }} correct answers</text>
    <text x="600" y="507" text-anchor="middle" font-family="Arial, Helvetica, sans-serif" font-size="24" fill="#2e2e2e">Test your knowledge on CertiTest</text>

    <path d="M140 530 q6 -6 12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0 t12 0" fill="none" stroke="#2e2e2e" stroke-width="1.5"/>
    <text x="140" y="520" font-family="'Brush Script MT', 'Segoe Script', cursive" font-size="34" fill="#2e2e2e">CertiTest</text>
    <text x="140" y="550" font-family="Arial, Helvetica, sans-serif" font-size="14" fill="#645c52">Authorized CertiTest Examiner</text>

    <text x="1060" y="545" text-anchor="end" font-family="Arial, Helvetica, sans-serif" font-size="16" fill="#2e2e2e">Document Date: {{ $date }}</text>
</svg>
