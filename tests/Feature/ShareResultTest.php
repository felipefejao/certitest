<?php

use App\Enums\ExamStatus;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('dashboard displays share result component', function () {
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

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
    $response->assertSee('Compartilhar');
    $response->assertSee('Meu desempenho no CertiTest');
    $response->assertSee('wa.me');
});

test('result page displays share result component', function () {
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
        'selected_answer' => 'A',
    ]);

    $attempt->finish();

    $response = $this->actingAs($user)->get(route('attempts.result', $attempt));

    $response->assertOk();
    $response->assertSee('Compartilhar');
    $response->assertSee('Meu resultado no CertiTest');
    $response->assertSee($exam['name']);
    $response->assertSee('50.00%');
});
