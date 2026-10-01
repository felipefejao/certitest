<?php

namespace App\Actions\Seo;

use App\Models\Exam;

class BuildSitemapAction
{
    /**
     * @return array<int, string>
     */
    public function handle(): array
    {
        $examUrls = Exam::published()
            ->orderBy('slug')
            ->pluck('slug')
            ->map(fn (string $slug): string => route('exams.show', $slug));

        return [
            route('home'),
            route('privacy'),
            ...$examUrls,
        ];
    }
}
