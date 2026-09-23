<?php

use App\Enums\ExamStatus;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutMiddleware([PreventRequestForgery::class]);
});

test('candidate can start an attempt on a published exam', function () {
    $user = User::factory()->create();
    $exam = Exam::factory()->create([
        'status' => ExamStatus::Published,
        'questions' => [
            ['id' => 'q1', 'question' => 'Q1', 'options' => ['A' => 'A', 'B' => 'B'], 'correct_answer' => 'A'],
            ['id' => 'q2', 'question' => 'Q2', 'options' => ['A' => 'A', 'B' => 'B'], 'correct_answer' => 'B'],
        ],
    ]);

    $response = $this->actingAs($user)->get("/exams/{$exam->slug}/start");

    $response->assertRedirect();
    $this->assertDatabaseHas('attempts', [
        'user_id' => $user->id,
        'exam_id' => $exam->id,
        'total_questions' => 2,
    ]);
});

test('candidate can answer a question and finish an attempt', function () {
    $user = User::factory()->create();
    $exam = Exam::factory()->create([
        'status' => ExamStatus::Published,
        'questions' => [
            ['id' => 'q1', 'question' => 'Q1', 'options' => ['A' => 'A', 'B' => 'B'], 'correct_answer' => 'A'],
        ],
    ]);

    $this->actingAs($user)->get("/exams/{$exam->slug}/start");

    $attempt = $user->attempts()->first();

    $this->actingAs($user)->post("/attempts/{$attempt->id}/question/0", [
        'question_id' => 'q1',
        'selected_answer' => 'A',
        'next_index' => 0,
    ]);

    $response = $this->actingAs($user)->post("/attempts/{$attempt->id}/submit");

    $response->assertRedirect("/attempts/{$attempt->id}/result");

    $attempt->refresh();

    expect($attempt->correct_answers)->toBe(1)
        ->and($attempt->wrong_answers)->toBe(0)
        ->and((float) $attempt->percentage)->toBe(100.0)
        ->and($attempt->finished_at)->not->toBeNull();
});
