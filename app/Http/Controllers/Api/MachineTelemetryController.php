<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MachineTelemetry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MachineTelemetryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // Pemeriksaan API Key
        $apiKey = config('services.machine_api_key');
        $requestKey = $request->header('X-API-Key');

        if (
            empty($apiKey) ||
            empty($requestKey) ||
            !hash_equals($apiKey, $requestKey)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'API Key tidak valid atau tidak tersedia.',
            ], 401);
        }

        // Validasi data sensor
        $validated = $request->validate([
            'temperature' => [
                'required',
                'numeric',
                'between:-40,125',
            ],
            'heater_status' => [
                'required',
                'string',
                'in:MEMANASKAN,SUHU TERCAPAI,unknown',
            ],
            'connection_status' => [
                'sometimes',
                'string',
                'in:connected,disconnected',
            ],
            'source' => [
                'sometimes',
                'string',
                'max:50',
            ],
        ]);

        // Simpan data ke database
        $telemetry = MachineTelemetry::create([
            'temperature' => $validated['temperature'],
            'heater_status' => $validated['heater_status'],
            'connection_status' => $validated['connection_status'] ?? 'connected',
            'source' => $validated['source'] ?? 'SIMULATED',
            'received_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data monitoring berhasil diterima.',
            'data' => $telemetry,
        ], 201);
    }
}
