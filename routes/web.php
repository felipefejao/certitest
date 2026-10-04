<?php

use App\Http\Controllers\AttemptController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SharedResultController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ThemeSuggestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/robots.txt', RobotsController::class)->name('robots');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/locale/{locale}', [LocaleController::class, 'update'])->name('locale.update');
Route::view('/privacidade', 'privacy')->name('privacy');
Route::post('/sugestoes', [ThemeSuggestionController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('suggestions.store');

Route::get('/exams/{slug}', [ExamController::class, 'show'])->name('exams.show');
Route::get('/categorias/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('blog.show');

Route::get('/result/{public_token}', [SharedResultController::class, 'show'])->name('results.public');
Route::get('/result/{public_token}/image', [SharedResultController::class, 'image'])->name('results.image');
Route::get('/result/{public_token}/image.png', [SharedResultController::class, 'imagePng'])->name('results.image.png');

// Localized public routes (pt_BR stays unprefixed as the default).
Route::prefix('{locale}')
    ->where(['locale' => 'en|de|fr'])
    ->name('localized.')
    ->group(function () {
        Route::get('/', HomeController::class)->name('home');
        Route::view('/privacidade', 'privacy')->name('privacy');
        Route::get('/exams/{slug}', [ExamController::class, 'show'])->name('exams.show');
        Route::get('/categorias/{slug}', [CategoryController::class, 'show'])->name('categories.show');
        Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
        Route::get('/blog/{slug}', [PostController::class, 'show'])->name('blog.show');
        Route::get('/result/{public_token}', [SharedResultController::class, 'show'])->name('results.public');
    });

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:register');

    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CandidateController::class, 'dashboard'])->name('dashboard');
    Route::post('/exams/{exam:slug}/start', [AttemptController::class, 'start'])->name('exams.start');
    Route::get('/exams-export', [ExamController::class, 'export'])->name('exams.export');

    Route::get('/attempts/{attempt}/question/{index}', [AttemptController::class, 'question'])->name('attempts.question');
    Route::post('/attempts/{attempt}/question/{index}', [AttemptController::class, 'answer']);
    Route::get('/attempts/{attempt}/confirm', [AttemptController::class, 'confirm'])->name('attempts.confirm');
    Route::post('/attempts/{attempt}/submit', [AttemptController::class, 'submit'])->name('attempts.submit');
    Route::get('/attempts/{attempt}/result', [AttemptController::class, 'result'])->name('attempts.result');
});
