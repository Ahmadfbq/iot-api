<?php

use App\Models\Home;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns a welcome message', function () {
    $response = $this->get('/api/home');

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Welcome to the IoT API Home Endpoint',
        'status' => 'success'
    ]);
});

it('receives info and stores it in the database', function () {
    $payload = [
        'gate_status' => 'opened',
        'package_status' => 'taken',
        'pin' => '1234'
    ];

    $response = $this->post('/api/home/info', $payload);

    $response->assertStatus(201);
    $this->assertDatabaseHas('homes', $payload);
});

it('displays info from the database', function () {
    $payload = [
        'gate_status' => 'opened',
        'package_status' => 'taken',
        'pin' => '1234'
    ];

    $home = Home::query()->create($payload);
    $response = $this->get("/api/home/info/{$home->id}");

    $response->assertStatus(200);
    $response->assertJson($payload);
});

// tests:
// 1. test the home endpoint returns a welcome message
// 2. test the receiveInfo endpoint receives the correct info and stores it in the database
// 3. test the displayInfo endpoint returns the correct info from the database