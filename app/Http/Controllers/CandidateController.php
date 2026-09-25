<?php

namespace App\Http\Controllers;

use App\Enums\ExamStatus;
use App\Models\Exam;
use App\Models\ExamCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidateController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();

        $categories = ExamCategory::whereHas('exams', fn ($query) => $query->where('status', ExamStatus::Published))
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $selectedCategory = $request->string('categoria')->toString();

        $availableExams = Exam::where('status', ExamStatus::Published)
            ->when($selectedCategory !== '', fn ($query) => $query->whereHas('category', fn ($q) => $q->where('slug', $selectedCategory)))
            ->with('category:id,name,slug')
            ->get(['id', 'name', 'slug', 'description', 'questions', 'exam_category_id'])
            ->map(fn (Exam $exam) => [
                'id' => $exam->id,
                'name' => $exam->name,
                'slug' => $exam->slug,
                'description' => $exam->description,
                'category' => $exam->category?->name,
                'questions_count' => $exam->questions_count,
            ]);

        $finishedAttempts = $user->attempts()
            ->with('exam')
            ->whereNotNull('finished_at')
            ->latest('finished_at')
            ->latest('id')
            ->get();

        $stats = [
            'exams_taken' => $finishedAttempts->count(),
            'average' => $finishedAttempts->isNotEmpty() ? round($finishedAttempts->avg('percentage'), 2) : 0,
            'best_score' => $finishedAttempts->isNotEmpty() ? round($finishedAttempts->max('percentage'), 2) : 0,
            'last_score' => $finishedAttempts->isNotEmpty() ? (float) $finishedAttempts->first()->percentage : 0,
        ];

        return view('dashboard', compact('user', 'availableExams', 'categories', 'selectedCategory', 'stats', 'finishedAttempts'));
    }
}
