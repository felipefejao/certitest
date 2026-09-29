<?php

namespace App\Actions\Attempts;

use App\Models\Attempt;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StartAttemptAction
{
    public function handle(User $user, Exam $exam): Attempt
    {
        return DB::transaction(function () use ($user, $exam) {
            User::whereKey($user->id)->lockForUpdate()->first();

            $attempt = $user->attempts()
                ->where('exam_id', $exam->id)
                ->whereNull('finished_at')
                ->latest('id')
                ->first();

            if ($attempt !== null) {
                return $attempt;
            }

            return $user->attempts()->create([
                'exam_id' => $exam->id,
                'total_questions' => $exam->questions_count,
                'questions_snapshot' => $exam->questions,
                'started_at' => now(),
            ]);
        });
    }
}
