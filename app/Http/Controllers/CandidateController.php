<?php

namespace App\Http\Controllers;

use App\Enums\ExamStatus;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidateController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();

        $availableExams = Exam::where('status', ExamStatus::Published)
            ->get(['id', 'name', 'slug', 'description', 'questions'])
            ->map(fn (Exam $exam) => [
                'id' => $exam->id,
                'name' => $exam->name,
                'slug' => $exam->slug,
                'description' => $exam->description,
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

        return view('dashboard', compact('user', 'availableExams', 'stats', 'finishedAttempts'));
    }
}
