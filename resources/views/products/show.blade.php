@extends('layouts.app')

@section('title', 'Detail Produk')
@section('breadcrumb', 'Produk / Detail')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Detail Produk
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Informasi lengkap produk pada sistem FoodMachine.
            </p>
        </div>

        <a
            href="{{ route('products.index') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5
                   bg-white border border-slate-200 rounded-lg
                   text-sm font-medium text-slate-600
                   hover:bg-slate-50 transition"
        >
            <span aria-hidden="true">←</span>
            Kembali ke Produk
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="p-4 rounded-lg border border-emerald-200
                    bg-emerald-50 text-emerald-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Informasi utama produk --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-card overflow-hidden">

        <div class="grid grid-cols-1 md:grid-cols-[280px_minmax(0,1fr)] gap-0">

            {{-- Gambar produk --}}
            <div class="p-6 bg-slate-50 border-b md:border-b-0 md:border-r border-slate-200">
                <div class="aspect-square w-full rounded-xl overflow-hidden
                            bg-white border border-slate-200
                            flex items-center justify-center">

                    @if($product->image)
                        <img
                            src="{{ $product->image }}"
                            alt="Gambar {{ $product->name }}"
                            class="w-full h-full object-cover"
                            loading="lazy"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >

                        <div
                            class="hidden w-full h-full items-center justify-center
                                   flex-col gap-2 text-slate-400"
                        >
                            <span class="text-6xl" aria-hidden="true">🍱</span>
                            <span class="text-xs">Gambar tidak tersedia</span>
                        </div>
                    @else
                        <div class="flex flex-col items-center gap-3 text-slate-400">
                            <span class="text-7xl" aria-hidden="true">🍱</span>
                            <span class="text-xs">Belum ada gambar produk</span>
                        </div>
                    @endif

                </div>

                <div class="mt-4 text-center">
                    <p class="text-xs text-slate-400">
                        ID Produk
                    </p>

                    <p class="font-semibold text-slate-700 mt-1">
                        #{{ $product->id }}
                    </p>
                </div>
            </div>

            {{-- Informasi produk --}}
            <div class="p-6 md:p-8">

                <div class="flex flex-col sm:flex-row sm:items-start
                            sm:justify-between gap-4">

                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase
                                  tracking-wider text-slate-400">
                            Nama Produk
                        </p>

                        <h2 class="text-2xl font-bold text-slate-800 mt-2 break-words">
                            {{ $product->name }}
                        </h2>
                    </div>

                    {{-- Status produk --}}
                    @if($product->status === 'active')
                        <span class="inline-flex items-center gap-2
                                     self-start px-3 py-1.5 rounded-full
                                     bg-emerald-50 text-emerald-700
                                     text-xs font-semibold whitespace-nowrap">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2
                                     self-start px-3 py-1.5 rounded-full
                                     bg-red-50 text-red-700
                                     text-xs font-semibold whitespace-nowrap">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            Tidak Aktif
                        </span>
                    @endif

                </div>

                {{-- Harga --}}
                <div class="mt-7 p-5 rounded-xl bg-blue-50 border border-blue-100">
                    <p class="text-sm text-slate-500">
                        Harga Produk
                    </p>

                    <p class="text-3xl font-bold text-blue-700 mt-2">
                        Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                    </p>
                </div>

                {{-- Detail produk --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-7">

                    {{-- Stok --}}
                    <div class="p-4 rounded-lg border border-slate-200">
                        <p class="text-sm text-slate-500">
                            Stok Tersedia
                        </p>

                        <div class="flex items-center gap-3 mt-2">
                            <span class="text-2xl" aria-hidden="true">📦</span>

                            <div>
                                <p class="text-xl font-bold
                                    {{ $product->stock <= 5 ? 'text-amber-600' : 'text-slate-800' }}">
                                    {{ number_format($product->stock, 0, ',', '.') }}
                                </p>

                                <p class="text-xs mt-1
                                    {{ $product->stock <= 5 ? 'text-amber-600' : 'text-slate-400' }}">
                                    {{ $product->stock <= 5 ? 'Stok perlu diperiksa' : 'Stok tersedia' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div class="p-4 rounded-lg border border-slate-200">
                        <p class="text-sm text-slate-500">
                            Kategori
                        </p>

                        <div class="flex items-center gap-3 mt-2">
                            <span class="text-2xl" aria-hidden="true">🍽️</span>

                            <div>
                                <p class="font-semibold text-slate-800">
                                    Makanan Utama
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    Kategori tampilan
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal dibuat --}}
                    <div class="p-4 rounded-lg border border-slate-200">
                        <p class="text-sm text-slate-500">
                            Tanggal Dibuat
                        </p>

                        <p class="font-medium text-slate-800 mt-2">
                            {{ $product->created_at?->format('d M Y, H:i') ?? '-' }}
                        </p>
                    </div>

                    {{-- Terakhir diperbarui --}}
                    <div class="p-4 rounded-lg border border-slate-200">
                        <p class="text-sm text-slate-500">
                            Terakhir Diperbarui
                        </p>

                        <p class="font-medium text-slate-800 mt-2">
                            {{ $product->updated_at?->format('d M Y, H:i') ?? '-' }}
                        </p>
                    </div>

                </div>

                {{-- Deskripsi --}}
                <div class="mt-7">
                    <h3 class="text-sm font-semibold text-slate-700">
                        Deskripsi Produk
                    </h3>

                    <div class="mt-3 p-4 rounded-lg bg-slate-50
                                border border-slate-200">
                        <p class="text-sm text-slate-600 leading-7 whitespace-pre-line break-words">{{ $product->description ?: 'Belum ada deskripsi untuk produk ini.' }}</p>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="mt-8 pt-6 border-t border-slate-200
                            flex flex-col sm:flex-row sm:justify-end gap-3">

                    <a
                        href="{{ route('products.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5
                               rounded-lg border border-slate-200 bg-white
                               text-sm font-medium text-slate-600
                               hover:bg-slate-50 transition"
                    >
                        Kembali
                    </a>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <a
                            href="{{ route('products.edit', $product) }}"
                            class="inline-flex items-center justify-center gap-2
                                   px-5 py-2.5 rounded-lg bg-primary
                                   text-white text-sm font-semibold
                                   hover:opacity-90 transition"
                        >
                            <span aria-hidden="true">✏️</span>
                            Edit Produk
                        </a>
                    @endif

                </div>

            </div>
        </div>
    </div>

</div>
@endsection