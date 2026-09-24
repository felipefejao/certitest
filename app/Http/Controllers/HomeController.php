<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        $exams = Exam::published()->get(['id', 'name', 'slug', 'description', 'questions']);

        $exams = $exams->map(fn (Exam $exam) => [
            'id' => $exam->id,
            'name' => $exam->name,
            'slug' => $exam->slug,
            'description' => $exam->description,
            'questions_count' => count($exam->questions ?? []),
        ]);

        $stats = [
            'exams' => Exam::published()->count(),
            'questions' => $exams->sum('questions_count'),
            'attempts' => 0,
        ];

        $captcha = [fake()->numberBetween(1, 9), fake()->numberBetween(1, 9)];
        $request->session()->put('suggestion_captcha_answer', $captcha[0] + $captcha[1]);
        $captchaQuestion = "Quanto é {$captcha[0]} + {$captcha[1]}?";

        return view('home', compact('exams', 'stats', 'captchaQuestion'));
    }
}
