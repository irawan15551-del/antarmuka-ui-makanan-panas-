@extends('kiosk.layout')

@section('title', 'Status Mesin')
@section('crumb', 'Status Mesin')

@section('content')

{{-- Header --}}
<div class="mb-7">
    <div class="text-sm font-bold text-blue-600 mb-2">
        MONITORING PERANGKAT
    </div>

    <h1 class="text-3xl font-extrabold tracking-tight">
        Status Mesin
    </h1>

    <p class="text-slate-500 mt-2">
        Pantau kondisi mesin dan kesiapan integrasi sensor.
    </p>
</div>

{{-- Notifikasi --}}
@if (session('success'))
    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        {{ session('error') }}
    </div>
@endif

{{-- Status koneksi perangkat --}}
<div class="fm-card p-6 md:p-8 mb-5">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div class="flex items-center gap-4">

            <div class="h-14 w-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl">
                ⌁
            </div>

            <div>
                <h2 class="text-xl font-extrabold">
                    Koneksi perangkat
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    @if (($machineStatus['connection'] ?? 'unverified') === 'connected')
                        Perangkat melaporkan status terhubung.
                    @elseif (($machineStatus['connection'] ?? 'unverified') === 'disconnected')
                        Perangkat tidak terhubung atau tidak dapat dijangkau.
                    @else
                        Status menunggu integrasi API simulator MC12.
                    @endif
                </p>
            </div>

        </div>

        @php
            $connection = $machineStatus['connection'] ?? 'unverified';

            $connectionStyles = [
                'connected' => 'bg-green-50 text-green-700',
                'disconnected' => 'bg-red-50 text-red-700',
                'unverified' => 'bg-amber-50 text-amber-700',
            ];

            $connectionLabels = [
                'connected' => '● Terhubung',
                'disconnected' => '● Terputus',
                'unverified' => '● Belum terverifikasi',
            ];
        @endphp

        <span class="fm-badge {{ $connectionStyles[$connection] ?? $connectionStyles['unverified'] }}">
            {{ $connectionLabels[$connection] ?? $connectionLabels['unverified'] }}
        </span>

    </div>

    @if ($connection === 'unverified')
        <div class="mt-6 rounded-xl border border-amber-100 bg-amber-50/60 p-4 text-sm text-amber-800">
            Status ini masih berupa placeholder antarmuka.
            Data koneksi perangkat belum diverifikasi melalui backend.
        </div>
    @elseif ($connection === 'disconnected')
        <div class="mt-6 rounded-xl border border-red-100 bg-red-50 p-4 text-sm text-red-700">
            Perangkat belum dapat dijangkau. Periksa jaringan ESP32,
            endpoint API, dan komunikasi dengan backend.
        </div>
    @else
        <div class="mt-6 rounded-xl border border-green-100 bg-green-50 p-4 text-sm text-green-700">
            Backend melaporkan perangkat terhubung.
            Periksa waktu pembaruan untuk memastikan data masih terbaru.
        </div>
    @endif

</div>

{{-- Kartu sensor --}}
<div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">

    @php
        $metrics = [
            [
                'title' => 'Suhu Mesin',
                'value' => $machineStatus['temperature'] ?? null,
                'unit' => '°C',
                'description' => 'Nilai dari sensor suhu',
            ],
            [
                'title' => 'Kelembapan',
                'value' => $machineStatus['humidity'] ?? null,
                'unit' => '%',
                'description' => 'Kelembapan dari sensor',
            ],
            [
                'title' => 'Sensor Gerak',
                'value' => $machineStatus['motion'] ?? null,
                'unit' => '',
                'description' => 'Status sensor PIR',
            ],
            [
                'title' => 'Intensitas Cahaya',
                'value' => $machineStatus['light'] ?? null,
                'unit' => '',
                'description' => 'Nilai sensor LDR',
            ],
        ];
    @endphp

    @foreach ($metrics as $metric)
        <div class="fm-card p-5">

            <div class="text-sm font-semibold text-slate-500">
                {{ $metric['title'] }}
            </div>

            <div class="text-3xl font-extrabold mt-4">

                @if ($metric['value'] === null)
                    —
                    @if (in_array($metric['title'], ['Suhu Mesin', 'Kelembapan']))
                        {{ $metric['unit'] }}
                    @endif
                @elseif ($metric['title'] === 'Sensor Gerak')
                    {{ $metric['value'] ? 'Terdeteksi' : 'Tidak terdeteksi' }}
                @else
                    {{ $metric['value'] }}{{ $metric['unit'] }}
                @endif

            </div>

            <div class="text-xs text-slate-400 mt-2">
                {{ $metric['description'] }}
            </div>

        </div>
    @endforeach

</div>

{{-- Checklist dan langkah berikutnya --}}
<div class="grid lg:grid-cols-2 gap-5">

    {{-- Checklist perangkat --}}
    <section class="fm-card p-6">

        <h2 class="font-extrabold text-lg">
            Checklist Perangkat
        </h2>

        <p class="text-sm text-slate-500 mt-1 mb-5">
            Pemeriksaan sebelum monitoring aktif.
        </p>

        <div class="space-y-4">

            @foreach ($deviceChecklist as $item)

                @php
                    $checkStatus = $item['status'] ?? 'pending';

                    $checkStyles = [
                        'completed' => 'bg-green-100 text-green-700',
                        'failed' => 'bg-red-100 text-red-700',
                        'pending' => 'bg-slate-100 text-slate-400',
                    ];

                    $checkIcons = [
                        'completed' => '✓',
                        'failed' => '!',
                        'pending' => '—',
                    ];

                    $checkLabels = [
                        'completed' => 'Selesai',
                        'failed' => 'Gagal',
                        'pending' => 'Menunggu',
                    ];
                @endphp

                <div class="flex items-center gap-3">

                    <span class="h-6 w-6 rounded-full flex-shrink-0 flex items-center justify-center text-xs font-bold {{ $checkStyles[$checkStatus] ?? $checkStyles['pending'] }}">
                        {{ $checkIcons[$checkStatus] ?? '—' }}
                    </span>

                    <span class="text-sm font-semibold text-slate-700">
                        {{ $item['label'] }}
                    </span>

                    <span class="ml-auto text-xs text-slate-400">
                        {{ $checkLabels[$checkStatus] ?? 'Menunggu' }}
                    </span>

                </div>

            @endforeach

        </div>

    </section>

    {{-- Langkah berikutnya --}}
    <section class="fm-card p-6">

        <h2 class="font-extrabold text-lg">
            Langkah Berikutnya
        </h2>

        <p class="text-sm text-slate-500 mt-1 mb-5">
            Aktifkan monitoring melalui integrasi backend.
        </p>

        <ol class="space-y-4 text-sm text-slate-600">

            <li class="flex gap-3">
                <span class="font-extrabold text-blue-600">01</span>
                <span>
                    Pastikan endpoint dan format respons simulator MC12
                    sudah disepakati.
                </span>
            </li>

            <li class="flex gap-3">
                <span class="font-extrabold text-blue-600">02</span>
                <span>
                    Hubungkan controller Laravel ke endpoint yang tersedia.
                </span>
            </li>

            <li class="flex gap-3">
                <span class="font-extrabold text-blue-600">03</span>
                <span>
                    Tampilkan waktu pembaruan dan kondisi error
                    apabila perangkat tidak mengirim data.
                </span>
            </li>

        </ol>

        <a href="{{ route('kiosk.configuration') }}"
           class="fm-btn fm-primary mt-6">
            Buka Konfigurasi →
        </a>

    </section>

</div>

{{-- Informasi konfigurasi terakhir --}}
<div class="fm-card p-6 mt-5">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        <div>
            <h2 class="font-extrabold text-lg">
                Konfigurasi Terakhir
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Informasi konfigurasi yang tersimpan di database.
            </p>
        </div>

        @if ($latestConfiguration)
            <span class="fm-badge bg-blue-50 text-blue-700">
                {{ ucfirst($latestConfiguration->status) }}
            </span>
        @else
            <span class="fm-badge bg-slate-100 text-slate-500">
                Belum ada konfigurasi
            </span>
        @endif

    </div>

    @if ($latestConfiguration)

        @php
            $payload = $latestConfiguration->payload ?? [];
        @endphp

        <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4 mt-5">

            <div class="rounded-xl bg-slate-50 p-4">
                <div class="text-xs text-slate-500">ID Mesin</div>
                <div class="font-bold mt-2">
                    {{ $payload['machine_id'] ?? '—' }}
                </div>
            </div>

            <div class="rounded-xl bg-slate-50 p-4">
                <div class="text-xs text-slate-500">Target Suhu</div>
                <div class="font-bold mt-2">
                    {{ $payload['target_temperature'] ?? '—' }}
                    @if (isset($payload['target_temperature']))
                        °C
                    @endif
                </div>
            </div>

            <div class="rounded-xl bg-slate-50 p-4">
                <div class="text-xs text-slate-500">Durasi Pemanasan</div>
                <div class="font-bold mt-2">
                    {{ $payload['heating_duration'] ?? '—' }}
                    @if (isset($payload['heating_duration']))
                        detik
                    @endif
                </div>
            </div>

            <div class="rounded-xl bg-slate-50 p-4">
                <div class="text-xs text-slate-500">Mode Mesin</div>
                <div class="font-bold mt-2">
                    {{ ucfirst($payload['machine_mode'] ?? '—') }}
                </div>
            </div>

        </div>

        <div class="text-xs text-slate-400 mt-4">
            Terakhir disimpan:
            {{ $latestConfiguration->created_at?->format('d-m-Y H:i:s') ?? '—' }}
        </div>

    @else

        <div class="rounded-xl bg-slate-50 p-4 mt-5 text-sm text-slate-500">
            Belum ada konfigurasi yang tersimpan.
            Gunakan tombol Buka Konfigurasi untuk menambahkan konfigurasi.
        </div>

    @endif

</div>

@endsection