@extends('kiosk.layout')

@section('title', 'Dashboard')
@section('crumb', 'Dashboard')

@section('content')

{{-- Header Dashboard --}}
<div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-7">
    <div>
        <div class="text-sm font-bold text-blue-600 mb-2">
            FOODMACHINE MANAGEMENT
        </div>

        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
            Dashboard
        </h1>

        <p class="text-slate-500 mt-2">
            Pantau ringkasan produk dan operasional FoodMachine dalam satu tampilan.
        </p>
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('kiosk.machine-status') }}"
           class="fm-btn fm-muted">
            ◉ Status Mesin
        </a>

        <a href="{{ route('kiosk.configuration') }}"
           class="fm-btn fm-primary">
            ⚙ Konfigurasi Mesin
        </a>
    </div>
</div>


{{-- Pesan sukses --}}
@if (session('success'))
    <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-medium text-emerald-700">
        {{ session('success') }}
    </div>
@endif


{{-- Pesan informasi --}}
@if (session('info'))
    <div class="mb-5 rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm font-medium text-blue-700">
        {{ session('info') }}
    </div>
@endif


{{-- Kartu Statistik --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    {{-- Total Produk --}}
    <div class="fm-card p-5">
        <div class="flex items-center justify-between gap-3">
            <div class="text-sm font-semibold text-slate-500">
                Total Produk
            </div>

            <div class="h-11 w-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                ▤
            </div>
        </div>

        <div class="text-3xl font-extrabold text-slate-900 mt-4">
            {{ number_format($totalProducts ?? 0, 0, ',', '.') }}
        </div>

        <div class="text-xs text-slate-400 mt-2">
            Seluruh produk yang belum dihapus
        </div>

        <a href="{{ route('kiosk.products') }}"
           class="inline-block mt-4 text-sm font-bold text-blue-600 hover:text-blue-800">
            Lihat produk →
        </a>
    </div>


    {{-- Produk Aktif --}}
    <div class="fm-card p-5">
        <div class="flex items-center justify-between gap-3">
            <div class="text-sm font-semibold text-slate-500">
                Produk Aktif
            </div>

            <div class="h-11 w-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                ✓
            </div>
        </div>

        <div class="text-3xl font-extrabold text-slate-900 mt-4">
            {{ number_format($activeProducts ?? 0, 0, ',', '.') }}
        </div>

        <div class="text-xs text-slate-400 mt-2">
            Produk berstatus aktif
        </div>

        <div class="mt-4">
            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                Data database
            </span>
        </div>
    </div>


    {{-- Stok Rendah --}}
    <div class="fm-card p-5">
        <div class="flex items-center justify-between gap-3">
            <div class="text-sm font-semibold text-slate-500">
                Stok Rendah
            </div>

            <div class="h-11 w-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                !
            </div>
        </div>

        <div class="text-3xl font-extrabold text-slate-900 mt-4">
            {{ number_format($lowStockProducts ?? 0, 0, ',', '.') }}
        </div>

        <div class="text-xs text-slate-400 mt-2">
            Produk dengan stok 5 atau kurang
        </div>

        @if (($lowStockProducts ?? 0) > 0)
            <div class="mt-4">
                <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700">
                    Perlu diperiksa
                </span>
            </div>
        @else
            <div class="mt-4">
                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                    Tidak ada stok rendah
                </span>
            </div>
        @endif
    </div>


    {{-- Status Mesin --}}
    <div class="fm-card p-5">
        <div class="flex items-center justify-between gap-3">
            <div class="text-sm font-semibold text-slate-500">
                Status Mesin
            </div>

            <div class="h-11 w-11 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl">
                ◉
            </div>
        </div>

        <div class="text-xl font-extrabold text-slate-900 mt-4">
            Belum Terhubung
        </div>

        <div class="text-xs text-slate-400 mt-2">
            Menunggu integrasi API perangkat
        </div>

        <a href="{{ route('kiosk.machine-status') }}"
           class="inline-block mt-4 text-sm font-bold text-blue-600 hover:text-blue-800">
            Periksa status →
        </a>
    </div>

</div>


{{-- Informasi Harga --}}
<div class="fm-card p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

        <div>
            <div class="text-sm font-bold text-blue-600 mb-2">
                INFORMASI PRODUK
            </div>

            <h2 class="text-xl font-extrabold text-slate-900">
                Rentang Harga Produk Aktif
            </h2>

            <p class="text-sm text-slate-500 mt-2">
                Informasi harga diambil dari database produk aktif.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-3 md:min-w-72">

            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                <div class="text-xs font-bold text-slate-400">
                    HARGA TERENDAH
                </div>

                <div class="text-lg sm:text-xl font-extrabold text-slate-900 mt-2">
                    @if (isset($activePriceMin) && $activePriceMin !== null)
                        Rp {{ number_format((float) $activePriceMin, 0, ',', '.') }}
                    @else
                        —
                    @endif
                </div>
            </div>

            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                <div class="text-xs font-bold text-slate-400">
                    HARGA TERTINGGI
                </div>

                <div class="text-lg sm:text-xl font-extrabold text-slate-900 mt-2">
                    @if (isset($activePriceMax) && $activePriceMax !== null)
                        Rp {{ number_format((float) $activePriceMax, 0, ',', '.') }}
                    @else
                        —
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>


{{-- Status Operasional dan Akses Cepat --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6">

    {{-- Status Operasional --}}
    <section class="fm-card p-6 xl:col-span-2">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h2 class="font-extrabold text-lg text-slate-900">
                    Status Operasional
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Ringkasan kondisi dan koneksi perangkat.
                </p>
            </div>

            <a href="{{ route('kiosk.machine-status') }}"
               class="text-sm font-bold text-blue-600 hover:text-blue-800">
                Lihat detail →
            </a>
        </div>

        <div class="rounded-2xl bg-amber-50 border border-amber-100 p-5 flex gap-4 items-start">

            <div class="h-11 w-11 shrink-0 rounded-xl bg-white border border-amber-100 flex items-center justify-center text-xl text-amber-600">
                !
            </div>

            <div>
                <div class="font-bold text-slate-800">
                    Menunggu Data Perangkat
                </div>

                <p class="text-sm text-slate-600 mt-1 leading-6">
                    Dashboard belum menerima telemetry langsung dari mesin.
                    Data suhu, sensor, dan koneksi akan ditampilkan setelah
                    Backend API atau simulator terintegrasi.
                </p>
            </div>

        </div>


        {{-- Telemetry --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">

            <div class="rounded-xl border border-slate-100 p-4">
                <div class="text-xs text-slate-400 font-bold">
                    SUHU MESIN
                </div>

                <div class="text-xl font-extrabold text-slate-900 mt-2">
                    — °C
                </div>

                <div class="text-xs text-slate-400 mt-1">
                    Menunggu sensor
                </div>
            </div>

            <div class="rounded-xl border border-slate-100 p-4">
                <div class="text-xs text-slate-400 font-bold">
                    KONEKSI
                </div>

                <div class="text-xl font-extrabold text-slate-900 mt-2">
                    —
                </div>

                <div class="text-xs text-slate-400 mt-1">
                    Menunggu API
                </div>
            </div>

            <div class="rounded-xl border border-slate-100 p-4">
                <div class="text-xs text-slate-400 font-bold">
                    PEMBARUAN TERAKHIR
                </div>

                <div class="text-xl font-extrabold text-slate-900 mt-2">
                    —
                </div>

                <div class="text-xs text-slate-400 mt-1">
                    Belum tersedia
                </div>
            </div>

        </div>

    </section>


    {{-- Akses Cepat --}}
    <section class="fm-card p-6">

        <h2 class="font-extrabold text-lg text-slate-900">
            Akses Cepat
        </h2>

        <p class="text-sm text-slate-500 mt-1 mb-5">
            Pilih halaman sesuai pekerjaan yang ingin dilakukan.
        </p>

        <div class="space-y-3">

            <a href="{{ route('kiosk.products') }}"
               class="block rounded-xl border border-slate-100 p-4 transition hover:border-blue-200 hover:bg-blue-50/50">

                <div class="flex items-center justify-between gap-3">
                    <span class="font-bold text-slate-800">
                        Manajemen Produk
                    </span>

                    <span class="text-blue-600">→</span>
                </div>

                <div class="text-xs text-slate-500 mt-1">
                    Lihat daftar produk aktif.
                </div>

            </a>


            <a href="{{ route('kiosk.machine-status') }}"
               class="block rounded-xl border border-slate-100 p-4 transition hover:border-blue-200 hover:bg-blue-50/50">

                <div class="flex items-center justify-between gap-3">
                    <span class="font-bold text-slate-800">
                        Status Mesin
                    </span>

                    <span class="text-blue-600">→</span>
                </div>

                <div class="text-xs text-slate-500 mt-1">
                    Periksa informasi perangkat.
                </div>

            </a>


            <a href="{{ route('kiosk.configuration') }}"
               class="block rounded-xl border border-slate-100 p-4 transition hover:border-blue-200 hover:bg-blue-50/50">

                <div class="flex items-center justify-between gap-3">
                    <span class="font-bold text-slate-800">
                        Konfigurasi Mesin
                    </span>

                    <span class="text-blue-600">→</span>
                </div>

                <div class="text-xs text-slate-500 mt-1">
                    Siapkan parameter operasional.
                </div>

            </a>

        </div>

    </section>

</div>


{{-- Catatan Sistem --}}
<div class="rounded-xl border border-slate-200 bg-white p-4">
    <div class="flex items-start gap-3">

        <div class="text-blue-600 text-lg">
            ℹ
        </div>

        <div>
            <h3 class="text-sm font-bold text-slate-800">
                Informasi Sistem
            </h3>

            <p class="text-sm text-slate-500 mt-1 leading-6">
                Statistik produk berasal dari database Laravel.
                Status sensor dan koneksi mesin belum dianggap aktif sebelum
                data aktual diterima dari Backend API atau simulator.
            </p>
        </div>

    </div>
</div>

@endsection