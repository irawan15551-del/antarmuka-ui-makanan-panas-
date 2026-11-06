@extends('kiosk.layout')

@section('title', 'Manajemen Produk')
@section('crumb', 'Manajemen Produk')

@section('content')

@php
    $isPaginated = $products instanceof \Illuminate\Pagination\AbstractPaginator;
    $shownCount = $products->count();
    $productCount = $isPaginated ? $products->total() : $shownCount;
    $firstItem = $isPaginated ? ($products->firstItem() ?? 0) : ($shownCount ? 1 : 0);
    $lastItem = $isPaginated ? ($products->lastItem() ?? 0) : $shownCount;
@endphp

{{-- Header --}}
<div class="mb-7">
    <div class="text-sm font-bold text-blue-600 mb-2">
        KATALOG & INVENTARIS
    </div>

    <h1 class="text-3xl font-extrabold tracking-tight">
        Manajemen Produk
    </h1>

    <p class="text-slate-500 mt-2">
        Kelola informasi, harga, ketersediaan, dan status produk.
    </p>
</div>

{{-- Ringkasan Produk --}}
<div class="grid sm:grid-cols-3 gap-4 mb-6">

    <div class="fm-card p-5">
        <div class="text-sm text-slate-500 font-semibold">
            Produk ditampilkan
        </div>

        <div class="text-3xl font-extrabold mt-2">
            {{ $shownCount }}
        </div>

        <div class="text-xs text-slate-400 mt-1">
            Item pada daftar saat ini
        </div>
    </div>

    <div class="fm-card p-5">
        <div class="text-sm text-slate-500 font-semibold">
            Total data
        </div>

        <div class="text-3xl font-extrabold mt-2">
            {{ $productCount }}
        </div>

        <div class="text-xs text-slate-400 mt-1">
            Jumlah seluruh produk
        </div>
    </div>

    <div class="fm-card p-5">
        <div class="text-sm text-slate-500 font-semibold">
            Halaman
        </div>

        <div class="text-3xl font-extrabold mt-2">
            {{ $isPaginated ? $products->currentPage() : 1 }}
        </div>

        <div class="text-xs text-slate-400 mt-1">
            Halaman daftar produk
        </div>
    </div>

</div>

{{-- Tabel Produk --}}
<section class="fm-card overflow-hidden">

    {{-- Header Tabel --}}
    <div class="p-5 md:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-slate-100">

        <div>
            <h2 class="text-lg font-extrabold">
                Daftar Produk
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Menampilkan {{ $firstItem }}–{{ $lastItem }}
                dari {{ $productCount }} data
            </p>
        </div>

        <div class="text-xs text-slate-400">
            Informasi mengikuti database
        </div>

    </div>

    {{-- Isi Tabel --}}
    <div class="overflow-x-auto">

        <table class="fm-table w-full min-w-[760px]">

            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th class="text-right">Tindakan</th>
                </tr>
            </thead>

            <tbody>

                @forelse($products as $product)

                    <tr class="hover:bg-slate-50/70">

                        {{-- Gambar dan Nama Produk --}}
                        <td>
                            <div class="flex items-center gap-3">

                                <div class="h-12 w-12 rounded-xl bg-slate-100 overflow-hidden flex items-center justify-center shrink-0">

                                    @if(!empty($product->image))

                                        @php
                                            $imagePath = trim($product->image);

                                            $isExternalUrl = preg_match(
                                                '/^https?:\/\//i',
                                                $imagePath
                                            );

                                            $imageUrl = $isExternalUrl
                                                ? $imagePath
                                                : asset('storage/' . ltrim($imagePath, '/'));
                                        @endphp

                                        <img
                                            src="{{ $imageUrl }}"
                                            alt="{{ $product->name }}"
                                            class="h-full w-full object-cover"
                                            loading="lazy"
                                            onerror="this.onerror=null; this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                                        >

                                        <span
                                            class="hidden text-xl"
                                            role="img"
                                            aria-label="Gambar produk tidak tersedia"
                                        >
                                            🍱
                                        </span>

                                    @else

                                        <span
                                            class="text-xl"
                                            role="img"
                                            aria-label="Tidak ada gambar produk"
                                        >
                                            🍱
                                        </span>

                                    @endif

                                </div>

                                <div>
                                    <div class="font-bold text-slate-800">
                                        {{ $product->name }}
                                    </div>

                                    <div class="text-xs text-slate-400 mt-1">
                                        ID #{{ $product->id }}
                                    </div>
                                </div>

                            </div>
                        </td>

                        {{-- Harga --}}
                        <td class="font-bold text-slate-700">
                            Rp {{ number_format((float) ($product->price ?? 0), 0, ',', '.') }}
                        </td>

                        {{-- Stok --}}
                        <td>
                            <span class="fm-badge {{ (int) ($product->stock ?? 0) <= 5 ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700' }}">
                                {{ $product->stock ?? 0 }} unit
                            </span>
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="fm-badge {{ ($product->status ?? '') === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                <span>●</span>
                                {{ ucfirst($product->status ?? 'unknown') }}
                            </span>
                        </td>

                        {{-- Tindakan --}}
                        <td class="text-right">
                            <a
                                href="{{ route('products.index') }}"
                                class="fm-btn fm-muted"
                            >
                                Kelola →
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5">

                            <div class="py-12 text-center">

                                <div class="text-4xl mb-3">
                                    📦
                                </div>

                                <div class="font-extrabold text-slate-700">
                                    Belum ada produk
                                </div>

                                <p class="text-sm text-slate-500 mt-1">
                                    Belum ada data produk yang tersedia.
                                </p>

                                <a
                                    href="{{ route('products.index') }}"
                                    class="fm-btn fm-muted mt-4"
                                >
                                    Lihat Manajemen Produk →
                                </a>

                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
    @if($isPaginated)
        <div class="p-5 border-t border-slate-100">
            {{ $products->links() }}
        </div>
    @endif

</section>

{{-- Informasi --}}
<div class="mt-5 flex items-start gap-3 rounded-xl bg-blue-50 border border-blue-100 p-4 text-sm text-blue-800">

    <span class="text-lg">ℹ️</span>

    <p>
        Pengelolaan data produk dilakukan melalui halaman CRUD.
        Gambar dapat menggunakan URL eksternal atau file yang tersimpan
        di penyimpanan Laravel. Jika gambar tidak tersedia, sistem
        menampilkan ikon makanan sebagai pengganti.
    </p>

</div>

@endsection