<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutMiddleware([PreventRequestForgery::class]);
});

test('guest can view the registration page', function () {
    $response = $this->get('/register');

    $response->assertOk();
});

test('guest can register as a candidate', function () {
    $response = $this->post('/register', [
        'name' => 'New Candidate',
        'email' => 'candidate@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');

    $this->assertDatabaseHas('users', [
        'email' => 'candidate@example.com',
        'role' => UserRole::Candidate->value,
    ]);
});

test('guest can log in with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'login@example.com',
        'password' => Hash::make('password123'),
        'role' => UserRole::Candidate,
    ]);

    $response = $this->post('/login', [
        'email' => 'login@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticatedAs($user);
});

test('authenticated user can log out', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $response->assertRedirect('/');
    $this->assertGuest();
});

test('guest cannot access the dashboard', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});
