<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamCategory;
use App\Support\LocaleUrls;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = ExamCategory::where('slug', $slug)->firstOrFail();

        $exams = Exam::published()
            ->where('exam_category_id', $category->id)
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'description', 'questions', 'exam_category_id']);

        abort_if($exams->isEmpty(), 404);

        $breadcrumbs = [
            ['name' => config('app.name'), 'url' => LocaleUrls::url('home')],
            ['name' => $category->name, 'url' => LocaleUrls::url('categories.show', ['slug' => $category->slug])],
        ];

        $jsonLd = [
            '@context' => 'https://schema.org',
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
        ];

        return view('categories.show', [
            'category' => $category,
            'exams' => $exams,
            'metaTitle' => $category->meta_title,
            'metaDescription' => $category->meta_description ?? $category->description ?? __('ui.home.meta_description'),
            'breadcrumbs' => $breadcrumbs,
            'jsonLd' => $jsonLd,
        ]);
    }
}
