<?php

namespace App\Http\Controllers;

use App\Events\DeliveryUpdated;
use App\Http\Requests\StoreInfoRequest;
use App\Models\Home;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Welcome to the IoT API Home Endpoint',
            'status' => 'success'
        ]);
    }

    public function receiveInfo(StoreInfoRequest $request): Home
    {
        // Handle the incoming info from the ESP32 device
        $info = $request->validated();
        $payload = [
            'gate_status' => $info['gate_status'],
            'package_status' => $info['package_status'],
            'pin' => $info['pin']
        ];

        $home = Home::query()->create($payload);

        event(new DeliveryUpdated($home->toArray()));

        return $home;
    }
    
    public function listInfo(): JsonResponse
    {
        $all = Home::query()
            ->orderByDesc('id')
            ->get();

        return response()->json($all);
    }

    public function displayInfo(int $id): Home
    {
        $info = Home::query()->findOrFail($id);
        return $info;
    }
}
