<?php

namespace App\Actions\Attempts;

use App\Models\Attempt;
use Illuminate\Support\Facades\DB;

class FinishAttemptAction
{
    public function handle(Attempt $attempt): void
    {
        DB::transaction(function () use ($attempt) {
            $attempt = Attempt::whereKey($attempt->id)->lockForUpdate()->firstOrFail();

            if ($attempt->finished_at !== null) {
                return;
            }

            $questions = $attempt->questions()->keyBy('id');
            $answers = $attempt->answers()->get();

            $correct = 0;
            $wrong = 0;

            foreach ($answers as $answer) {
                $question = $questions->get($answer->question_id);

                if ($question === null) {
                    continue;
                }

                $isCorrect = $question['correct_answer'] === $answer->selected_answer;
                $answer->update(['is_correct' => $isCorrect]);

                if ($isCorrect) {
                    $correct++;
                } else {
                    $wrong++;
                }
            }

            $total = $attempt->questionCount();
            $unanswered = $total - $answers->whereNotNull('selected_answer')->count();
            $wrong += max(0, $unanswered);

            $attempt->update([
                'correct_answers' => $correct,
                'wrong_answers' => $wrong,
                'percentage' => $total > 0 ? round(($correct / $total) * 100, 2) : 0,
                'finished_at' => now(),
            ]);
        });
    }
}
