<?php

namespace App\Actions\Results;

use App\Models\Attempt;

class BuildCertificateSvgAction
{
    public function handle(Attempt $attempt): string
    {
        $attempt->loadMissing('exam', 'user');

        $score = sprintf('%.0f%%', (float) $attempt->percentage);
        $scoreFontSize = 115;
        $scoreWidth = array_sum(array_map(fn (string $char): float => match (true) {
            $char === '%' => 0.88,
            $char === '.' => 0.28,
            default => 0.56,
        }, str_split($score))) * $scoreFontSize;

        $barWidth = 140;
        $barGap = 25;
        $scoreX = 600 - (($scoreWidth + $barGap + $barWidth) / 2);

        return view('results.certificate', [
            'logoDataUri' => 'data:image/png;base64,'.base64_encode(file_get_contents(public_path('images/logo.png'))),
            'candidateName' => mb_strtoupper($attempt->user->name),
            'titleLines' => $this->wrapText($attempt->exam->name, 38, 960),
            'score' => $score,
            'scoreX' => $scoreX,
            'barX' => $scoreX + $scoreWidth + $barGap,
            'barWidth' => $barWidth,
            'correct' => $attempt->correct_answers,
            'total' => $attempt->total_questions,
            'date' => $attempt->finished_at?->format('d/m/Y') ?? now()->format('d/m/Y'),
        ])->render();
    }

    /**
     * Approximate word wrapping for Arial at a given font size (~0.55em per char).
     *
     * @return array<int, string>
     */
    private function wrapText(string $text, int $fontSize, int $maxWidth): array
    {
        $maxChars = max(1, (int) floor($maxWidth / ($fontSize * 0.55)));
        $lines = explode("\n", wordwrap($text, $maxChars, "\n", false));

        return array_values(array_filter($lines, fn ($line) => $line !== ''));
    }
}
