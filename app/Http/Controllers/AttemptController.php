<?php

namespace App\Http\Controllers;

use App\Actions\Attempts\FinishAttemptAction;
use App\Actions\Attempts\ResolveResumeIndexAction;
use App\Actions\Attempts\StartAttemptAction;
use App\DTOs\QuestionViewData;
use App\Enums\ExamStatus;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Exam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AttemptController extends Controller
{
    public function __construct(
        private StartAttemptAction $startAttempt,
        private ResolveResumeIndexAction $resolveResumeIndex,
        private FinishAttemptAction $finishAttempt,
    ) {}

    public function start(Request $request, Exam $exam): RedirectResponse
    {
        abort_if($exam->status !== ExamStatus::Published, 404);

        $attempt = $this->startAttempt->handle($request->user(), $exam);

        return redirect()->route('attempts.question', [
            'attempt' => $attempt,
            'index' => $this->resolveResumeIndex->handle($attempt),
        ]);
    }

    public function question(Request $request, Attempt $attempt, int $index): View|RedirectResponse
    {
        $this->authorizeAccess($attempt);

        $exam = $attempt->exam;
        $questions = $attempt->questions();

        if ($index < 0 || $index >= $questions->count()) {
            return redirect()->route('attempts.question', ['attempt' => $attempt, 'index' => 0]);
        }

        $question = $questions->get($index);
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
            'total' => $questions->count(),
            'question' => QuestionViewData::fromArray($question),
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

        $validated = $request->validate([
            'question_id' => ['nullable', 'string'],
            'selected_answer' => ['nullable', 'string', 'in:A,B,C,D'],
        ]);

        if (! empty($validated['question_id'])) {
            Answer::updateOrCreate(
                [
                    'attempt_id' => $attempt->id,
                    'question_id' => $validated['question_id'],
                ],
                [
                    'selected_answer' => $validated['selected_answer'] ?? null,
                ]
            );
        }

        $this->finishAttempt->handle($attempt);

        return redirect()->route('attempts.result', $attempt);
    }

    public function result(Request $request, Attempt $attempt): View|RedirectResponse
    {
        $this->authorizeAccess($attempt);

        if (! $attempt->isFinished()) {
            return redirect()->route('attempts.question', ['attempt' => $attempt, 'index' => 0]);
        }

        $attempt->load('exam', 'answers');

        $answersByQuestion = $attempt->answers->keyBy('question_id');

        $wrongQuestions = $attempt->questions()
            ->map(function (array $question, int $index) use ($answersByQuestion) {
                $answer = $answersByQuestion->get($question['id']);

                if ($answer?->is_correct) {
                    return null;
                }

                return [
                    'number' => $index + 1,
                    'question' => $question['question'],
                    'selected_answer' => $answer?->selected_answer,
                    'correct_answer' => $question['correct_answer'],
                    'options' => $question['options'],
                ];
            })
            ->filter()
            ->values();

        return view('attempts.result', [
            'attempt' => $attempt,
            'exam' => $attempt->exam,
            'wrongQuestions' => $wrongQuestions,
        ]);
    }

    private function authorizeAccess(Attempt $attempt): void
    {
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $questions
     * @return array<int, array{index: int, answered: bool}>
     */
    private function getProgress(Attempt $attempt, Collection $questions): array
    {
        $answeredIds = $attempt->answers
            ->whereNotNull('selected_answer')
            ->pluck('question_id')
            ->flip()
            ->toArray();

        return $questions->map(fn ($question, $idx) => [
            'index' => $idx,
            'answered' => isset($answeredIds[$question['id']]),
        ])->toArray();
    }
}
