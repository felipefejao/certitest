<?php

namespace App\Actions\Home;

use App\DTOs\SiteStatsData;
use App\Models\Attempt;
use App\Models\Exam;
use Illuminate\Support\Facades\Cache;

class GetSiteStatsAction
{
    public function handle(): SiteStatsData
    {
        $stats = Cache::remember('home.stats', 600, $this->calculate(...));

        if (! is_array($stats) || ! isset($stats['exams'], $stats['questions'], $stats['attempts'])) {
            Cache::forget('home.stats');
            $stats = $this->calculate();
        }

        return new SiteStatsData($stats['exams'], $stats['questions'], $stats['attempts']);
    }

    /**
     * @return array{exams: int, questions: int, attempts: int}
     */
    private function calculate(): array
    {
        $exams = Exam::published()->get('questions');

        return [
            'exams' => $exams->count(),
            'questions' => $exams->sum(fn (Exam $exam): int => count($exam->questions ?? [])),
            'attempts' => Attempt::whereNotNull('finished_at')->distinct()->count('user_id'),
        ];
    }
}
