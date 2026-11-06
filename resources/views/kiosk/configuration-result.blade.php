@extends('kiosk.layout')

@section('title', 'Hasil Konfigurasi')
@section('crumb', 'Hasil Konfigurasi')

@section('content')
@php
    $payload = $configuration->payload ?? [];
    $status = strtolower($configuration->status ?? 'pending');
@endphp

<div class="max-w-3xl mx-auto">

    <div class="fm-card p-7 md:p-10">

        <div class="text-center">

            <div class="mx-auto h-16 w-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-3xl">
                ✓
            </div>

            <div class="text-xs font-extrabold tracking-[.18em] text-blue-600 mt-5">
                HASIL PENYIMPANAN
            </div>

            <h1 class="text-2xl md:text-3xl font-extrabold mt-2">
                Konfigurasi Tersimpan
            </h1>

            <p class="text-slate-500 mt-3 max-w-xl mx-auto">
                Parameter konfigurasi sudah tersimpan di database dan menunggu proses pengiriman ke simulator.
            </p>

        </div>

        @if (session('success'))
            <div class="mt-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-8 rounded-xl border border-slate-200 p-5">

            <div class="text-xs font-bold text-slate-400">
                ID KONFIGURASI
            </div>

            <div class="text-xl font-extrabold text-slate-800 mt-1">
                #{{ $configuration->id }}
            </div>

            <div class="mt-5 flex items-center justify-between gap-3">

                <span class="text-sm font-semibold text-slate-600">
                    Status penyimpanan
                </span>

                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-extrabold text-amber-800">
                    {{ strtoupper($status) }}
                </span>

            </div>

        </div>

        <div class="grid sm:grid-cols-2 gap-3 text-left mt-6">

            <div class="rounded-xl border border-slate-100 p-4">
                <div class="text-xs font-bold text-slate-400">
                    ID Mesin
                </div>

                <div class="font-extrabold text-slate-800 mt-2">
                    {{ $payload['machine_id'] ?? '—' }}
                </div>
            </div>

            <div class="rounded-xl border border-slate-100 p-4">
                <div class="text-xs font-bold text-slate-400">
                    Target Suhu
                </div>

                <div class="font-extrabold text-slate-800 mt-2">
                    {{ $payload['target_temperature'] ?? '—' }} °C
                </div>
            </div>

            <div class="rounded-xl border border-slate-100 p-4">
                <div class="text-xs font-bold text-slate-400">
                    Durasi Pemanasan
                </div>

                <div class="font-extrabold text-slate-800 mt-2">
                    {{ $payload['heating_duration'] ?? '—' }} detik
                </div>
            </div>

            <div class="rounded-xl border border-slate-100 p-4">
                <div class="text-xs font-bold text-slate-400">
                    Mode Mesin
                </div>

                <div class="font-extrabold text-slate-800 mt-2">
                    {{ ucfirst($payload['machine_mode'] ?? '—') }}
                </div>
            </div>

        </div>

        <div class="mt-6 rounded-xl border border-amber-100 bg-amber-50 p-4 text-sm text-amber-800">
            <strong>Catatan:</strong>
            status PENDING berarti konfigurasi telah disimpan dan belum dikonfirmasi diterapkan oleh simulator MC12.
        </div>

        <div class="flex flex-wrap justify-center gap-3 mt-7">

            <a href="{{ route('kiosk.configuration') }}"
               class="fm-btn fm-primary">
                ← Kembali ke Konfigurasi
            </a>

            <a href="{{ route('kiosk.machine-status') }}"
               class="fm-btn fm-muted">
                Status Mesin
            </a>

        </div>

    </div>

</div>
@endsection
