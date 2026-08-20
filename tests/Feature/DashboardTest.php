<?php

use App\Enums\ExamStatus;
use App\Models\Answer;
use App\Models\Attempt;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutMiddleware([PreventRequestForgery::class]);
});

test('dashboard displays zeroed stats for candidate with no attempts', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
    $response->assertSee('Provas realizadas');
    $response->assertSee('0%');
    $response->assertSee('Você ainda não realizou nenhum simulado');
});

test('dashboard shows candidate stats from finished attempts', function () {
    $user = User::factory()->create();
    $exam = Exam::factory()->create([
        'status' => ExamStatus::Published,
        'questions' => [
            ['id' => 'q1', 'question' => 'Q1', 'options' => ['A' => 'A', 'B' => 'B'], 'correct_answer' => 'A'],
            ['id' => 'q2', 'question' => 'Q2', 'options' => ['A' => 'A', 'B' => 'B'], 'correct_answer' => 'B'],
        ],
    ]);

    $firstAttempt = Attempt::create([
        'user_id' => $user->id,
        'exam_id' => $exam->id,
        'total_questions' => 2,
        'started_at' => now()->subDays(2),
    ]);

    Answer::create([
        'attempt_id' => $firstAttempt->id,
        'question_id' => 'q1',
        'selected_answer' => 'A',
    ]);

    Answer::create([
        'attempt_id' => $firstAttempt->id,
        'question_id' => 'q2',
        'selected_answer' => 'B',
    ]);

    $firstAttempt->finish();
    $firstAttempt->update(['finished_at' => now()->subDay()]);

    $secondAttempt = Attempt::create([
        'user_id' => $user->id,
        'exam_id' => $exam->id,
        'total_questions' => 2,
        'started_at' => now()->subDay(),
    ]);

    Answer::create([
        'attempt_id' => $secondAttempt->id,
        'question_id' => 'q1',
        'selected_answer' => 'A',
    ]);

    Answer::create([
        'attempt_id' => $secondAttempt->id,
        'question_id' => 'q2',
        'selected_answer' => 'A',
    ]);

    $secondAttempt->finish();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
    $response->assertSee('2'); // exams_taken
    $response->assertSee('75%'); // average
    $response->assertSee('100%'); // best_score
    $response->assertSee('50%'); // last_score
    $response->assertSee('Provas realizadas');
    $response->assertSee($exam->name);
    $response->assertSee('Ver resultado');
    $response->assertSee('attempts/'.$firstAttempt->id.'/result');
    $response->assertSee('attempts/'.$secondAttempt->id.'/result');
});
