<?php

namespace App\Http\Controllers;

use App\Enums\ExamStatus;
use App\Models\Exam;
use App\Support\LocaleUrls;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function show(Request $request, string $slug): View
    {
        $exam = Exam::with('category:id,name,slug')
            ->where('slug', $slug)
            ->where('status', ExamStatus::Published)
            ->firstOrFail();

        if ($request->user() === null && ! $request->session()->has('url.intended')) {
            $request->session()->put('url.intended', url()->current());
        }

        $relatedExams = $exam->exam_category_id
            ? Exam::published()
                ->where('exam_category_id', $exam->exam_category_id)
                ->whereKeyNot($exam->id)
                ->orderBy('name')
                ->limit(3)
                ->get(['id', 'name', 'slug', 'description', 'questions', 'exam_category_id'])
            : collect();

        $metaDescription = $exam->meta_description ?? $exam->description ?? __('ui.home.meta_description');
        $breadcrumbs = [
            ['name' => config('app.name'), 'url' => LocaleUrls::url('home')],
        ];
        if ($exam->category !== null) {
            $breadcrumbs[] = ['name' => $exam->category->name, 'url' => LocaleUrls::url('categories.show', ['slug' => $exam->category->slug])];
        }
        $breadcrumbs[] = ['name' => $exam->name, 'url' => LocaleUrls::url('exams.show', ['slug' => $exam->slug])];

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Quiz',
                    'name' => $exam->name,
                    'about' => $exam->category?->name ?? $exam->name,
                    'description' => $metaDescription,
                    'url' => LocaleUrls::url('exams.show', ['slug' => $exam->slug]),
                    'inLanguage' => str_replace('_', '-', app()->getLocale()),
                    'isAccessibleForFree' => true,
                    'provider' => [
                        '@type' => 'Organization',
                        'name' => config('app.name'),
                        'url' => LocaleUrls::url('home'),
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => array_map(
                        fn (array $item, int $position): array => [
                            '@type' => 'ListItem',
                            'position' => $position + 1,
                            'name' => $item['name'],
                            'item' => $item['url'],
                        ],
                        $breadcrumbs,
                        array_keys($breadcrumbs),
                    ),
                ],
            ],
        ];

        return view('exams.show', [
            'exam' => [
                'id' => $exam->id,
                'name' => $exam->name,
                'slug' => $exam->slug,
                'description' => $exam->description,
                'intro' => $exam->intro,
                'questions_count' => $exam->questions_count,
                'category' => $exam->category?->name,
            ],
            'metaTitle' => $exam->meta_title,
            'metaDescription' => $metaDescription,
            'breadcrumbs' => $breadcrumbs,
            'jsonLd' => $jsonLd,
            'relatedExams' => $relatedExams,
        ]);
    }

    public function start(Request $request, string $slug): RedirectResponse
    {
        $exam = Exam::where('slug', $slug)
            ->where('status', ExamStatus::Published)
            ->firstOrFail();

        return redirect()->route('dashboard');
    }

    public function export(Request $request): JsonResponse
    {
        if (! $request->user()?->isAdmin()) {
            abort(403);
        }

        $exams = Exam::all()->map(fn (Exam $exam) => [
            'name' => $exam->name,
            'slug' => $exam->slug,
            'description' => $exam->description,
            'status' => $exam->status->value,
            'questions' => $exam->questions,
        ])->toArray();

        $filename = 'exams-'.now()->format('Y-m-d-His').'.json';

        return response()->json($exams)
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
