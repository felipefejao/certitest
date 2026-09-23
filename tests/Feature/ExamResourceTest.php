<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can access the exams resource', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $response = $this->actingAs($admin)->get('/admin/exams');

    $response->assertOk();
});

test('candidate cannot access the exams resource', function () {
    $candidate = User::factory()->create(['role' => UserRole::Candidate]);

    $response = $this->actingAs($candidate)->get('/admin/exams');

    $response->assertForbidden();
});
