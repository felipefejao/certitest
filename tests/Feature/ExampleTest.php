<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('the google tag is rendered', function () {
    $response = $this->get('/');

    $response->assertSee('https://www.googletagmanager.com/gtag/js?id=G-XCHXPC53GX', false);
    $response->assertSee("gtag('config', 'G-XCHXPC53GX')", false);
});
