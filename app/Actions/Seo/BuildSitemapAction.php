<?php

namespace App\Actions\Seo;

use App\Models\Exam;
use App\Models\ExamCategory;

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

        $categoryUrls = ExamCategory::whereHas('exams', fn ($query) => $query->published())
            ->orderBy('slug')
            ->pluck('slug')
            ->map(fn (string $slug): string => route('categories.show', $slug));

        return [
            route('home'),
            route('privacy'),
            ...$categoryUrls,
            ...$examUrls,
        ];
    }
}
