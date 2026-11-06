<?php

namespace App\Http\Controllers;

use App\Models\MachineTelemetry;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $telemetry = MachineTelemetry::latest('received_at')->first();

        $machineConnected = $telemetry
            && $telemetry->connection_status === 'connected'
            && $telemetry->received_at
            && $telemetry->received_at->gt(now()->subSeconds(60));

        return view('dashboard', [
            'user' => $request->user(),
            'telemetry' => $telemetry,
            'machineConnected' => $machineConnected,
        ]);
    }
}
