<?php

namespace App\Http\Controllers;

use App\Actions\Home\GetSiteStatsAction;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\Post;
use App\Support\LocaleUrls;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request, GetSiteStatsAction $getSiteStats): View
    {
        $categories = ExamCategory::whereHas('exams', fn ($query) => $query->published())
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $exams = Exam::published()
            ->with('category:id,name,slug')
            ->get(['id', 'name', 'slug', 'description', 'questions', 'exam_category_id']);

        $exams = $exams->map(fn (Exam $exam) => [
            'id' => $exam->id,
            'name' => $exam->name,
            'slug' => $exam->slug,
            'description' => $exam->description,
            'category' => $exam->category?->name,
            'category_slug' => $exam->category?->slug,
            'questions_count' => count($exam->questions ?? []),
        ]);

        $latestPosts = Post::published()
            ->orderByDesc('published_at')
            ->limit(3)
            ->get(['id', 'title', 'slug', 'excerpt', 'published_at']);

        $stats = $getSiteStats->handle();

        $captcha = [fake()->numberBetween(1, 9), fake()->numberBetween(1, 9)];
        $request->session()->put('suggestion_captcha_answer', $captcha[0] + $captcha[1]);
        $captchaQuestion = __('ui.suggestion.captcha', ['a' => $captcha[0], 'b' => $captcha[1]]);

        $faqs = __('ui.faq.items');

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    'name' => config('app.name'),
                    'url' => LocaleUrls::url('home'),
                    'logo' => asset('images/logo.png'),
                ],
                [
                    '@type' => 'WebSite',
                    'name' => config('app.name'),
                    'url' => LocaleUrls::url('home'),
                    'inLanguage' => str_replace('_', '-', app()->getLocale()),
                ],
                [
                    '@type' => 'FAQPage',
                    'mainEntity' => array_map(
                        fn (array $faq): array => [
                            '@type' => 'Question',
                            'name' => $faq['q'],
                            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
                        ],
                        is_array($faqs) ? $faqs : [],
                    ),
                ],
            ],
        ];

        return view('home', compact('exams', 'categories', 'stats', 'captchaQuestion', 'faqs', 'jsonLd', 'latestPosts'));
    }
}
