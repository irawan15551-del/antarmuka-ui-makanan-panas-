<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MachineMonitoringController;
use App\Http\Controllers\Api\MachineTelemetryController;

/*
|--------------------------------------------------------------------------
| API Routes - MC07
|--------------------------------------------------------------------------
*/

// Mendapatkan data pengguna yang sedang login
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Mendapatkan data monitoring mesin
// URL: GET /api/v1/machine-monitoring
Route::get('/v1/machine-monitoring', [
    MachineMonitoringController::class,
    'index',
]);

// Menerima data sensor ESP32 dari Wokwi
// URL: POST /api/v1/machine-telemetry
Route::post('/v1/machine-telemetry', [
    MachineTelemetryController::class,
    'store',
]);