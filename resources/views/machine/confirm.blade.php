@extends('layouts.app')

@section('title', 'Detail Konfigurasi Mesin')
@section('breadcrumb', 'Konfigurasi Mesin / Detail')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Detail Konfigurasi Mesin
        </h1>

        <p class="text-sm text-slate-500 mt-2">
            Informasi konfigurasi yang tersimpan di database.
        </p>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="mb-5 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if (session('error'))
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">
            {{ session('error') }}
        </div>
    @endif

    {{-- Detail konfigurasi --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">

        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Konfigurasi #{{ $configuration->id }}
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Dibuat {{ $configuration->created_at?->format('d-m-Y H:i') ?? '-' }}
                </p>
            </div>

            @php
                $statusClasses = [
                    'pending' => 'bg-amber-100 text-amber-800',
                    'sent' => 'bg-blue-100 text-blue-800',
                    'success' => 'bg-green-100 text-green-800',
                    'failed' => 'bg-red-100 text-red-800',
                ];

                $statusLabels = [
                    'pending' => 'Menunggu Pengiriman',
                    'sent' => 'Terkirim',
                    'success' => 'Berhasil',
                    'failed' => 'Gagal',
                ];

                $status = $configuration->status ?? 'pending';
            @endphp

            <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $statusClasses[$status] ?? 'bg-slate-100 text-slate-700' }}">
                {{ $statusLabels[$status] ?? ucfirst($status) }}
            </span>
        </div>

        <div class="space-y-4">

            <div class="flex justify-between gap-4 border-b border-slate-100 pb-3">
                <span class="text-sm text-slate-500">Target suhu</span>

                <strong class="text-sm text-slate-800">
                    {{ $configuration->payload['target_temperature'] ?? $configuration->payload['temperature'] ?? '-' }} °C
                </strong>
            </div>

            <div class="flex justify-between gap-4 border-b border-slate-100 pb-3">
                <span class="text-sm text-slate-500">Durasi pemanasan</span>

                <strong class="text-sm text-slate-800">
                    {{ $configuration->payload['heating_duration'] ?? $configuration->payload['heating_time'] ?? '-' }} detik
                </strong>
            </div>

            <div class="flex justify-between gap-4 border-b border-slate-100 pb-3">
                <span class="text-sm text-slate-500">Target slot</span>

                <strong class="text-sm text-slate-800">
                    {{ $configuration->payload['target_slot'] ?? '-' }}
                </strong>
            </div>

            <div class="flex justify-between gap-4 border-b border-slate-100 pb-3">
                <span class="text-sm text-slate-500">Mode mesin</span>

                <strong class="text-sm text-slate-800">
                    {{ ucfirst($configuration->payload['machine_mode'] ?? $configuration->payload['mode'] ?? '-') }}
                </strong>
            </div>

        </div>

        {{-- Respons simulator --}}
        <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50 p-4">

            <h3 class="font-bold text-amber-900 text-sm">
                Status Integrasi Simulator
            </h3>

            <p class="text-sm text-amber-800 mt-2">
                Data konfigurasi sudah tersimpan di database.
                Status ini tidak membuktikan bahwa simulator MC12 telah
                menerima atau menerapkan konfigurasi.
            </p>

            @if ($configuration->response)
                <pre class="mt-3 whitespace-pre-wrap break-words text-xs text-slate-700">{{ json_encode($configuration->response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            @else
                <p class="text-xs text-amber-800 mt-3">
                    Belum ada respons simulator yang tersimpan.
                </p>
            @endif

        </div>

        {{-- Tombol --}}
        <div class="flex flex-wrap gap-3 mt-6">

            <a href="{{ route('machine.index') }}"
               class="px-5 py-2.5 border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Kembali ke Konfigurasi
            </a>

            <a href="{{ route('kiosk.machine-status') }}"
               class="px-5 py-2.5 bg-blue-600 rounded-lg text-sm font-semibold text-white hover:bg-blue-700">
                Lihat Monitoring Mesin
            </a>

        </div>

    </div>

</div>

@endsection