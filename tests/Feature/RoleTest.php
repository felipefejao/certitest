<?php

use App\Enums\UserRole;
use App\Models\User;
use Filament\Panel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('new users are created as candidates by default', function () {
    $user = User::factory()->create();

    expect($user->role)->toBe(UserRole::Candidate)
        ->and($user->isCandidate())->toBeTrue()
        ->and($user->isAdmin())->toBeFalse();
});

test('admins can access the filament panel', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    expect($admin->canAccessPanel(new Panel))->toBeTrue();
});

test('candidates cannot access the filament panel', function () {
    $candidate = User::factory()->create(['role' => UserRole::Candidate]);

    expect($candidate->canAccessPanel(new Panel))->toBeFalse();
});
