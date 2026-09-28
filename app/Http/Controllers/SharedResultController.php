<?php

namespace App\Http\Controllers;

use App\Models\Attempt;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SharedResultController extends Controller
{
    public function show(string $publicToken): View
    {
        $attempt = Attempt::with('exam', 'user')
            ->whereNotNull('finished_at')
            ->where('public_token', $publicToken)
            ->firstOrFail();

        return view('results.public', [
            'attempt' => $attempt,
            'exam' => $attempt->exam,
            'user' => $attempt->user,
        ]);
    }

    public function image(string $publicToken): Response
    {
        $attempt = Attempt::with('exam', 'user')
            ->whereNotNull('finished_at')
            ->where('public_token', $publicToken)
            ->firstOrFail();

        $svg = view('results.certificate', [
            'candidateName' => mb_strtoupper($attempt->user->name),
            'titleLines' => $this->wrapText($attempt->exam->name, 38, 960),
            'percentage' => (float) $attempt->percentage,
            'correct' => $attempt->correct_answers,
            'total' => $attempt->total_questions,
            'date' => $attempt->finished_at?->format('d/m/Y') ?? now()->format('d/m/Y'),
        ])->render();

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'public, max-age=86400',
        ]);
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
