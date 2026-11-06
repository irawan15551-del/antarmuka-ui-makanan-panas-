<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MachineConfiguration;
use App\Models\MachineTelemetry;
use Illuminate\Http\JsonResponse;

class MachineMonitoringController extends Controller
{
    public function index(): JsonResponse
    {
        $latestTelemetry = MachineTelemetry::latest('received_at')->first();

        $latestConfiguration = MachineConfiguration::latest()->first();

        return response()->json([
            'success' => true,
            'message' => 'Data monitoring mesin berhasil diambil.',
            'data' => [
                'connection' => $latestTelemetry
                    ? $latestTelemetry->connection_status
                    : 'unverified',

                'temperature' => $latestTelemetry
                    ? $latestTelemetry->temperature
                    : null,

                'heater_status' => $latestTelemetry
                    ? $latestTelemetry->heater_status
                    : 'unknown',

                'last_updated' => $latestTelemetry
                    ? $latestTelemetry->received_at
                    : null,

                'source' => $latestTelemetry
                    ? $latestTelemetry->source
                    : null,

                'latest_configuration' => $latestConfiguration ? [
                    'id' => $latestConfiguration->id,
                    'machine_id' => $latestConfiguration->payload['machine_id'] ?? null,
                    'target_temperature' => $latestConfiguration->payload['target_temperature'] ?? null,
                    'heating_duration' => $latestConfiguration->payload['heating_duration'] ?? null,
                    'machine_mode' => $latestConfiguration->payload['machine_mode'] ?? null,
                    'status' => $latestConfiguration->status,
                    'created_at' => $latestConfiguration->created_at,
                    'response' => $latestConfiguration->response,
                ] : null,
            ],
        ]);
    }
}
