<?php

use App\Http\Controllers\AttemptController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SharedResultController;
use App\Http\Controllers\ThemeSuggestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::post('/sugestoes', [ThemeSuggestionController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('suggestions.store');

Route::get('/result/{public_token}', [SharedResultController::class, 'show'])->name('results.public');
Route::get('/result/{public_token}/image', [SharedResultController::class, 'image'])->name('results.image');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [CandidateController::class, 'dashboard'])->name('dashboard');
    Route::get('/exams/{slug}', [ExamController::class, 'show'])->name('exams.show');
    Route::get('/exams/{slug}/start', [AttemptController::class, 'start'])->name('exams.start');
    Route::get('/exams-export', [ExamController::class, 'export'])->name('exams.export');

    Route::get('/attempts/{attempt}/question/{index}', [AttemptController::class, 'question'])->name('attempts.question');
    Route::post('/attempts/{attempt}/question/{index}', [AttemptController::class, 'answer']);
    Route::get('/attempts/{attempt}/confirm', [AttemptController::class, 'confirm'])->name('attempts.confirm');
    Route::post('/attempts/{attempt}/submit', [AttemptController::class, 'submit'])->name('attempts.submit');
    Route::get('/attempts/{attempt}/result', [AttemptController::class, 'result'])->name('attempts.result');
});
