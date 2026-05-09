<?php

namespace App\Http\Controllers;

use App\Events\DeliveryUpdated;
use App\Http\Requests\StoreInfoRequest;
use App\Models\Delivery;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DeliveryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Welcome to the IoT API Delivery Endpoint',
            'status' => 'success'
        ]);
    }

    public function receiveInfo(StoreInfoRequest $request): Delivery
    {
        // Handle the incoming info from the ESP32 device
        $info = $request->validated();
        $payload = [
            'user_id' => User::query()->value('id'),
            'delivery_name' => $info['delivery_name'] ?? 'Default Delivery Name',
            'gate_status' => $info['gate_status'],
            'package_status' => $info['package_status'],
            'pin' => $info['pin']
        ];

        $delivery = Delivery::query()->create($payload);

        event(new DeliveryUpdated($delivery->toArray()));

        return $delivery;
    }
    
    public function listInfo(): JsonResponse
    {
        $all = Delivery::query()
            ->orderByDesc('id')
            ->paginate(5);

        return response()->json($all);
    }

    public function displayInfo(int $id): Delivery
    {
        $info = Delivery::query()->findOrFail($id);
        return $info;
    }
}
