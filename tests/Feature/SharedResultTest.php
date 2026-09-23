<?php

use App\Enums\ExamStatus;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('public result page is accessible with public token', function () {
    $user = User::factory()->create();
    $exam = Exam::factory()->create([
        'status' => ExamStatus::Published,
        'questions' => [
            ['id' => 'q1', 'question' => 'Q1', 'options' => ['A' => 'A', 'B' => 'B'], 'correct_answer' => 'A'],
            ['id' => 'q2', 'question' => 'Q2', 'options' => ['A' => 'A', 'B' => 'B'], 'correct_answer' => 'B'],
        ],
    ]);

    $attempt = Attempt::create([
        'user_id' => $user->id,
        'exam_id' => $exam->id,
        'total_questions' => 2,
        'started_at' => now(),
    ]);

    Answer::create([
        'attempt_id' => $attempt->id,
        'question_id' => 'q1',
        'selected_answer' => 'A',
    ]);

    Answer::create([
        'attempt_id' => $attempt->id,
        'question_id' => 'q2',
        'selected_answer' => 'B',
    ]);

    $attempt->finish();

    $response = $this->get(route('results.public', $attempt->public_token));

    $response->assertOk();
    $response->assertSee($user->name);
    $response->assertSee($exam['name']);
    $response->assertSee('100%');
    $response->assertSee('og:image');
});

test('public result image is a valid png', function () {
    $user = User::factory()->create();
    $exam = Exam::factory()->create([
        'status' => ExamStatus::Published,
        'questions' => [
            ['id' => 'q1', 'question' => 'Q1', 'options' => ['A' => 'A', 'B' => 'B'], 'correct_answer' => 'A'],
        ],
    ]);

    $attempt = Attempt::create([
        'user_id' => $user->id,
        'exam_id' => $exam->id,
        'total_questions' => 1,
        'started_at' => now(),
    ]);

    Answer::create([
        'attempt_id' => $attempt->id,
        'question_id' => 'q1',
        'selected_answer' => 'A',
    ]);

    $attempt->finish();

    $response = $this->get(route('results.image', $attempt->public_token));

    $response->assertOk();
    $response->assertHeader('Content-Type', 'image/png');
});

test('unfinished attempt is not accessible publicly', function () {
    $user = User::factory()->create();
    $exam = Exam::factory()->create([
        'status' => ExamStatus::Published,
        'questions' => [
            ['id' => 'q1', 'question' => 'Q1', 'options' => ['A' => 'A', 'B' => 'B'], 'correct_answer' => 'A'],
        ],
    ]);

    $attempt = Attempt::create([
        'user_id' => $user->id,
        'exam_id' => $exam->id,
        'total_questions' => 1,
        'started_at' => now(),
    ]);

    $this->get(route('results.public', $attempt->public_token))->assertNotFound();
});
