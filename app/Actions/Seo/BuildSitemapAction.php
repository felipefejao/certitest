<?php

namespace App\Actions\Seo;

use App\Http\Middleware\SetLocale;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\Post;
use App\Support\LocaleUrls;

class BuildSitemapAction
{
    /**
     * @return array<int, array{loc: string, alternates: array<string, string>}>
     */
    public function handle(): array
    {
        $pages = [
            ['home', []],
            ['privacy', []],
            ['blog.index', []],
        ];

        foreach (
            ExamCategory::whereHas('exams', fn ($query) => $query->published())
                ->orderBy('slug')
                ->pluck('slug') as $slug
        ) {
            $pages[] = ['categories.show', ['slug' => $slug]];
        }

        foreach (Exam::published()->orderBy('slug')->pluck('slug') as $slug) {
            $pages[] = ['exams.show', ['slug' => $slug]];
        }

        foreach (Post::published()->orderBy('slug')->pluck('slug') as $slug) {
            $pages[] = ['blog.show', ['slug' => $slug]];
        }

        $urls = [];

        foreach ($pages as [$name, $parameters]) {
            $alternates = [];

            foreach (SetLocale::SUPPORTED as $locale) {
                $alternates[$locale] = LocaleUrls::url($name, $parameters, $locale);
            }

            foreach ($alternates as $url) {
                $urls[] = ['loc' => $url, 'alternates' => $alternates];
            }
        }

        return $urls;
    }
}
