<?php

namespace App\Http\Controllers;

use App\Models\MachineConfiguration;
use Illuminate\Http\Request;

class MachineConfigurationController extends Controller
{
    /**
     * Menampilkan halaman konfigurasi mesin.
     */
    public function index()
    {
        $latestConfiguration = MachineConfiguration::latest()->first();

        return view('machine.index', compact('latestConfiguration'));
    }

    /**
     * Menyimpan konfigurasi mesin.
     *
     * Catatan: penyimpanan database bukan berarti
     * konfigurasi sudah diterima oleh simulator.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'temperature' => [
                'required',
                'numeric',
                'min:0',
                'max:120',
            ],
            'heating_time' => [
                'required',
                'integer',
                'min:1',
                'max:3600',
            ],
            'target_slot' => [
                'required',
                'string',
                'max:20',
            ],
            'mode' => [
                'required',
                'in:Normal,Maintenance',
            ],
        ]);

        $configuration = MachineConfiguration::create([
            'user_id' => $request->user()->id,
            'payload' => [
                'target_temperature' => (float) $validated['temperature'],
                'heating_duration' => (int) $validated['heating_time'],
                'target_slot' => $validated['target_slot'],
                'machine_mode' => strtolower($validated['mode']),
            ],
            'status' => 'pending',
            'response' => null,
        ]);

        return redirect()
            ->route('machine.confirm', ['id' => $configuration->id])
            ->with(
                'success',
                'Konfigurasi tersimpan. Pengiriman ke simulator belum diverifikasi.'
            );
    }

    /**
     * Menampilkan detail konfigurasi yang tersimpan.
     */
    public function show($machine)
    {
        $configuration = MachineConfiguration::findOrFail($machine);

        return view('machine.confirm', compact('configuration'));
    }

    /**
     * Alias untuk route konfirmasi lama.
     */
    public function confirm($id = null)
    {
        if ($id !== null) {
            return $this->show($id);
        }

        $configuration = MachineConfiguration::latest()->first();

        if (! $configuration) {
            return redirect()
                ->route('machine.index')
                ->with('error', 'Belum ada konfigurasi mesin.');
        }

        return $this->show($configuration->id);
    }
}
