<?php

namespace App\Actions\Attempts;

use App\Models\Attempt;

class ResolveResumeIndexAction
{
    public function handle(Attempt $attempt): int
    {
        $answeredIds = $attempt->answers()
            ->whereNotNull('selected_answer')
            ->pluck('question_id')
            ->flip();

        foreach ($attempt->questions() as $index => $question) {
            if (! isset($answeredIds[$question['id']])) {
                return $index;
            }
        }

        return 0;
    }
}
