<?php

namespace App\Http\Controllers;

use App\Enums\ExamStatus;
use App\Models\Exam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function show(Request $request, string $slug): View
    {
        $exam = Exam::where('slug', $slug)
            ->where('status', ExamStatus::Published)
            ->firstOrFail();

        return view('exams.show', [
            'exam' => [
                'id' => $exam->id,
                'name' => $exam->name,
                'slug' => $exam->slug,
                'description' => $exam->description,
                'questions_count' => $exam->questions_count,
            ],
        ]);
    }

    public function start(Request $request, string $slug): RedirectResponse
    {
        $exam = Exam::where('slug', $slug)
            ->where('status', ExamStatus::Published)
            ->firstOrFail();

        return redirect()->route('dashboard');
    }

    public function export(Request $request): Response
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
