<?php

namespace App\Models;

use App\Actions\Attempts\FinishAttemptAction;
use Database\Factories\AttemptFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

#[Fillable(['user_id', 'exam_id', 'total_questions', 'correct_answers', 'wrong_answers', 'percentage', 'started_at', 'finished_at', 'public_token', 'questions_snapshot'])]
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
            'questions_snapshot' => 'array',
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

    /**
     * @return Collection<int, array<string, mixed>>
     */
    public function questions(): Collection
    {
        return collect($this->questions_snapshot ?? $this->exam->questions ?? []);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function questionAt(int $index): ?array
    {
        return $this->questions()->get($index);
    }

    public function questionCount(): int
    {
        return $this->questions()->count();
    }

    public function finish(): void
    {
        app(FinishAttemptAction::class)->handle($this);
    }
}
