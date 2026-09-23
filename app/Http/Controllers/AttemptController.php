<?php

namespace App\Http\Controllers;

use App\Enums\ExamStatus;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Exam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttemptController extends Controller
{
    public function start(Request $request, string $slug): RedirectResponse
    {
        $exam = Exam::where('slug', $slug)
            ->where('status', ExamStatus::Published)
            ->firstOrFail();

        $attempt = Attempt::create([
            'user_id' => $request->user()->id,
            'exam_id' => $exam->id,
            'total_questions' => $exam->questions_count,
            'started_at' => now(),
        ]);

        return redirect()->route('attempts.question', ['attempt' => $attempt, 'index' => 0]);
    }

    public function question(Request $request, Attempt $attempt, int $index): View
    {
        $this->authorizeAccess($attempt);

        $exam = $attempt->exam;
        $questions = $exam->questions ?? [];

        if ($index < 0 || $index >= count($questions)) {
            return redirect()->route('attempts.question', ['attempt' => $attempt, 'index' => 0]);
        }

        $question = $questions[$index];
        $currentAnswer = $attempt->answers
            ->where('question_id', $question['id'])
            ->first();

        return view('attempts.question', [
            'attempt' => $attempt,
            'exam' => [
                'id' => $exam->id,
                'name' => $exam->name,
                'slug' => $exam->slug,
            ],
            'index' => $index,
            'total' => count($questions),
            'question' => [
                'id' => $question['id'],
                'question' => $question['question'],
                'options' => $question['options'],
            ],
            'selectedAnswer' => $currentAnswer?->selected_answer,
            'progress' => $this->getProgress($attempt, $questions),
        ]);
    }

    public function answer(Request $request, Attempt $attempt, int $index): RedirectResponse
    {
        $this->authorizeAccess($attempt);

        $validated = $request->validate([
            'question_id' => ['required', 'string'],
            'selected_answer' => ['nullable', 'string', 'in:A,B,C,D'],
            'next_index' => ['required', 'integer'],
        ]);

        Answer::updateOrCreate(
            [
                'attempt_id' => $attempt->id,
                'question_id' => $validated['question_id'],
            ],
            [
                'selected_answer' => $validated['selected_answer'],
            ]
        );

        return redirect()->route('attempts.question', ['attempt' => $attempt, 'index' => $validated['next_index']]);
    }

    public function confirm(Request $request, Attempt $attempt): View
    {
        $this->authorizeAccess($attempt);

        return view('attempts.confirm', [
            'attempt' => $attempt,
            'answeredCount' => $attempt->answers()->whereNotNull('selected_answer')->count(),
        ]);
    }

    public function submit(Request $request, Attempt $attempt): RedirectResponse
    {
        $this->authorizeAccess($attempt);

        $attempt->finish();

        return redirect()->route('attempts.result', $attempt);
    }

    public function result(Request $request, Attempt $attempt): View
    {
        $this->authorizeAccess($attempt);

        $attempt->load('exam');

        return view('attempts.result', [
            'attempt' => $attempt,
            'exam' => $attempt->exam,
        ]);
    }

    private function authorizeAccess(Attempt $attempt): void
    {
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }
    }

    private function getProgress(Attempt $attempt, array $questions): array
    {
        $answeredIds = $attempt->answers
            ->whereNotNull('selected_answer')
            ->pluck('question_id')
            ->flip()
            ->toArray();

        return collect($questions)->map(fn ($question, $idx) => [
            'index' => $idx,
            'answered' => isset($answeredIds[$question['id']]),
        ])->toArray();
    }
}
