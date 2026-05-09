<?php

use App\Events\DeliveryUpdated;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

it('returns a welcome message', function () {
    $response = $this->get('/api/delivery');

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Welcome to the IoT API Delivery Endpoint',
        'status' => 'success'
    ]);
});

it('receives info and stores it in the database', function () {
    Event::fake();
    User::factory()->create();

    $payload = [
        'gate_status' => 'opened',
        'package_status' => 'taken',
        'pin' => '1234'
    ];

    $response = $this->post('/api/delivery/info', $payload);

    $response->assertStatus(201);
    $this->assertDatabaseHas('deliveries', ['gate_status' => $payload['gate_status'], 'package_status' => $payload['package_status'], 'pin' => $payload['pin'], 'user_id' => 1]);
    Event::assertDispatched(DeliveryUpdated::class, function (DeliveryUpdated $event) use ($payload) {
        return $event->data['gate_status'] === $payload['gate_status']
            && $event->data['package_status'] === $payload['package_status']
            && $event->data['pin'] === $payload['pin'];
    });
});

it('receives info without requiring an existing user', function () {
    Event::fake();

    $payload = [
        'gate_status' => 'opened',
        'package_status' => 'taken',
        'pin' => '1234'
    ];

    $response = $this->post('/api/delivery/info', $payload);

    $response->assertStatus(201);
    $this->assertDatabaseHas('deliveries', [
        'gate_status' => $payload['gate_status'],
        'package_status' => $payload['package_status'],
        'pin' => $payload['pin'],
        'user_id' => null,
    ]);
});

it('displays info from the database', function () {
    $payload = [
        'gate_status' => 'opened',
        'package_status' => 'taken',
        'pin' => '1234'
    ];

    $delivery = Delivery::query()->create($payload);
    $response = $this->get("/api/delivery/info/{$delivery->id}");

    $response->assertStatus(200);
    $response->assertJson($payload);
});