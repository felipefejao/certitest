<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
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

        $stats = [
            'exams' => Exam::published()->count(),
            'questions' => $exams->sum('questions_count'),
            'attempts' => 0,
        ];

        $captcha = [fake()->numberBetween(1, 9), fake()->numberBetween(1, 9)];
        $request->session()->put('suggestion_captcha_answer', $captcha[0] + $captcha[1]);
        $captchaQuestion = __('ui.suggestion.captcha', ['a' => $captcha[0], 'b' => $captcha[1]]);

        return view('home', compact('exams', 'categories', 'stats', 'captchaQuestion'));
    }
}
