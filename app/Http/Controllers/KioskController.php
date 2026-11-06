<?php

namespace App\Http\Controllers;

use App\Models\MachineConfiguration;
use App\Models\MachineTelemetry;
use App\Models\Product;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    /**
     * Halaman splash screen.
     */
    public function splash()
    {
        return view('kiosk.splash');
    }

    /**
     * Dashboard statistik produk.
     */
    public function dashboard()
    {
        $totalProducts = Product::count();

        $activeProducts = Product::where('status', 'active')->count();

        $lowStockProducts = Product::where('stock', '<=', 5)->count();

        $priceRange = Product::where('status', 'active')
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        $activePriceMin = $priceRange?->min_price;
        $activePriceMax = $priceRange?->max_price;

        return view('kiosk.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'activePriceMin',
            'activePriceMax'
        ));
    }

    /**
     * Menampilkan produk aktif.
     */
    public function products()
    {
        $products = Product::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('kiosk.products', compact('products'));
    }

    /**
     * Halaman detail produk.
     */
    public function productDetail()
    {
        return view('kiosk.product-detail');
    }

    /**
     * Monitoring mesin dan konfigurasi terakhir.
     * Data diambil dari telemetry ESP32 yang tersimpan di database.
     */
    public function machineStatus()
    {
        // Mengambil data telemetry terbaru.
        $telemetry = MachineTelemetry::latest('received_at')->first();

        // Memeriksa apakah data diterima dalam 60 detik terakhir.
        $isFresh = $telemetry
            && $telemetry->received_at
            && $telemetry->received_at->gt(now()->subSeconds(60));

        // Menentukan status koneksi mesin.
        if (! $telemetry) {
            $connection = 'unverified';
        } elseif (
            $telemetry->connection_status === 'connected'
            && $isFresh
        ) {
            $connection = 'connected';
        } else {
            $connection = 'disconnected';
        }

        // Menyiapkan data monitoring untuk halaman Blade.
        $machineStatus = [
            'connection' => $connection,
            'temperature' => $telemetry?->temperature,
            'humidity' => null,
            'motion' => null,
            'light' => null,
            'heater_status' => $telemetry?->heater_status ?? 'unknown',
            'last_updated' => $telemetry?->received_at,
        ];

        // Checklist berdasarkan data telemetry yang diterima.
        $deviceChecklist = [
            [
                'label' => 'ESP32 atau simulator terhubung',
                'status' => $connection === 'connected'
                    ? 'completed'
                    : ($connection === 'disconnected' ? 'failed' : 'pending'),
            ],
            [
                'label' => 'Endpoint telemetri tersedia',
                'status' => $telemetry ? 'completed' : 'pending',
            ],
            [
                'label' => 'Data sensor diterima',
                'status' => $telemetry && $telemetry->temperature !== null
                    ? 'completed'
                    : 'pending',
            ],
            [
                'label' => 'Timestamp telemetri tersedia',
                'status' => $telemetry && $telemetry->received_at
                    ? 'completed'
                    : 'pending',
            ],
        ];

        // Mengambil konfigurasi mesin terakhir.
        $latestConfiguration = MachineConfiguration::latest()->first();

        return view('kiosk.machine-status', compact(
            'machineStatus',
            'latestConfiguration',
            'deviceChecklist'
        ));
    }

    /**
     * Halaman formulir konfigurasi mesin.
     */
    public function configuration()
    {
        return view('kiosk.configuration');
    }

    /**
     * Memvalidasi dan menyimpan konfigurasi mesin.
     *
     * Penyimpanan ke database belum berarti konfigurasi
     * sudah dikirim atau diterapkan oleh simulator MC12.
     */
    public function configurationResult(Request $request)
    {
        $validated = $request->validate([
            'machine_id' => [
                'required',
                'string',
                'max:50',
            ],
            'target_temperature' => [
                'required',
                'numeric',
                'min:0',
                'max:120',
            ],
            'heating_duration' => [
                'required',
                'integer',
                'min:1',
                'max:3600',
            ],
            'machine_mode' => [
                'required',
                'in:normal,maintenance',
            ],
        ]);

        $configuration = MachineConfiguration::create([
            'user_id' => auth()->id(),
            'payload' => [
                'machine_id' => $validated['machine_id'],
                'target_temperature' => (float) $validated['target_temperature'],
                'heating_duration' => (int) $validated['heating_duration'],
                'machine_mode' => $validated['machine_mode'],
            ],
            'status' => 'pending',
            'response' => null,
        ]);

        return redirect()->route(
            'kiosk.configuration-result.show',
            ['id' => $configuration->id]
        )->with(
            'success',
            'Konfigurasi berhasil disimpan ke database. Pengiriman ke perangkat belum diverifikasi.'
        );
    }

    /**
     * Menampilkan hasil konfigurasi.
     */
    public function showConfigurationResult($id)
    {
        $configuration = MachineConfiguration::findOrFail($id);

        $status = $configuration->status;

        return view('kiosk.configuration-result', compact(
            'configuration',
            'status'
        ));
    }

    /**
     * Halaman pengaturan sistem.
     */
    public function settings()
    {
        return view('kiosk.settings');
    }
}
