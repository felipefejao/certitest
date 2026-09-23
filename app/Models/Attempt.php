<?php

namespace App\Models;

use Database\Factories\AttemptFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable(['user_id', 'exam_id', 'total_questions', 'correct_answers', 'wrong_answers', 'percentage', 'started_at', 'finished_at', 'public_token'])]
class Attempt extends Model
{
    /** @use HasFactory<AttemptFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'percentage' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function isFinished(): bool
    {
        return $this->finished_at !== null;
    }

    protected static function booted(): void
    {
        static::creating(function (Attempt $attempt) {
            if (empty($attempt->public_token)) {
                $attempt->public_token = (string) Str::uuid();
            }
        });
    }

    public function finish(): void
    {
        $questions = $this->exam->questions ?? [];
        $correctByQuestion = collect($questions)->keyBy('id');

        $answers = $this->answers()->get();
        $correct = 0;
        $wrong = 0;

        foreach ($answers as $answer) {
            $question = $correctByQuestion->get($answer->question_id);

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

        $unanswered = count($questions) - $answers->whereNotNull('selected_answer')->count();
        $wrong += $unanswered;

        $total = count($questions);
        $percentage = $total > 0 ? round(($correct / $total) * 100, 2) : 0;

        $this->update([
            'correct_answers' => $correct,
            'wrong_answers' => $wrong,
            'percentage' => $percentage,
            'finished_at' => now(),
        ]);
    }
}
