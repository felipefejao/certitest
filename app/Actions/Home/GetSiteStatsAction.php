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
        return Cache::remember('home.stats', 600, function (): SiteStatsData {
            $exams = Exam::published()->get('questions');

            return new SiteStatsData(
                exams: $exams->count(),
                questions: $exams->sum(fn (Exam $exam): int => count($exam->questions ?? [])),
                attempts: Attempt::whereNotNull('finished_at')->distinct()->count('user_id'),
            );
        });
    }
}
