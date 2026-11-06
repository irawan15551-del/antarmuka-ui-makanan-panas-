@extends('layouts.app')

@section('title', 'Kelola Produk')
@section('breadcrumb', 'Produk')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Kelola Produk
            </h1>

            <p class="text-slate-500 text-sm mt-1">
                Kelola katalog, harga, stok, dan status produk.
            </p>
        </div>

        {{-- Aksi khusus Admin --}}
        @if(auth()->user()->role === 'admin')
            <div class="flex flex-wrap gap-2">
                <a
                    href="{{ route('products.deleted') }}"
                    class="px-4 py-2.5 rounded-lg border border-slate-300
                           bg-white text-sm font-medium text-slate-700
                           hover:bg-slate-50 transition"
                >
                    Produk Dihapus
                </a>

                <a
                    href="{{ route('products.create') }}"
                    class="px-4 py-2.5 rounded-lg bg-primary text-white
                           text-sm font-semibold hover:opacity-90 transition"
                >
                    + Tambah Produk
                </a>
            </div>
        @endif
    </div>


    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50
                    px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif


    {{-- Pesan error --}}
    @if(session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50
                    px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif


    {{-- Daftar error validasi --}}
    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50
                    px-4 py-3 text-sm text-red-700">
            <p class="font-semibold mb-1">
                Terdapat kesalahan:
            </p>

            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Tabel produk --}}
    <div class="bg-white rounded-xl border border-slate-200
                shadow-card overflow-hidden">

        {{-- Pencarian dan jumlah produk --}}
        <div class="p-4 border-b border-slate-200
                    flex flex-col md:flex-row gap-3
                    justify-between md:items-center">

            <form
                method="GET"
                action="{{ route('products.index') }}"
                class="w-full md:w-96"
            >
                <div class="flex gap-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama produk..."
                        class="w-full h-10 px-4 border border-slate-300
                               rounded-lg outline-none
                               focus:border-primary focus:ring-1
                               focus:ring-primary"
                    >

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg bg-primary
                               text-white text-sm font-medium"
                    >
                        Cari
                    </button>

                    @if(request('search'))
                        <a
                            href="{{ route('products.index') }}"
                            class="px-3 py-2 rounded-lg border
                                   border-slate-300 text-sm
                                   flex items-center"
                        >
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <div class="text-sm text-slate-500">
                Total
                <span class="font-semibold text-slate-800">
                    {{ $products->total() }}
                </span>
                produk
            </div>
        </div>


        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold">
                            No
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Nama Produk
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Harga
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Stok
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Status
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Terakhir Diperbarui
                        </th>

                        <th class="px-5 py-3 text-left font-semibold">
                            Aksi
                        </th>
                    </tr>
                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($products as $i => $p)

                        <tr class="hover:bg-slate-50 transition">

                            {{-- Nomor --}}
                            <td class="px-5 py-4 text-slate-500">
                                {{ $products->firstItem() + $i }}
                            </td>


                            {{-- Informasi produk --}}
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800">
                                    {{ $p->name }}
                                </div>

                                <div class="text-xs text-slate-400
                                            mt-1 truncate max-w-xs">
                                    {{ $p->description ?: 'Tidak ada deskripsi.' }}
                                </div>
                            </td>


                            {{-- Harga --}}
                            <td class="px-5 py-4 whitespace-nowrap">
                                Rp {{ number_format($p->price, 0, ',', '.') }}
                            </td>


                            {{-- Stok --}}
                            <td class="px-5 py-4">
                                <span class="{{ $p->stock <= 5
                                    ? 'text-red-600 font-semibold'
                                    : 'text-slate-700' }}">
                                    {{ $p->stock }}
                                </span>

                                @if($p->stock <= 5)
                                    <div class="text-xs text-red-500 mt-1">
                                        Stok rendah
                                    </div>
                                @endif
                            </td>


                            {{-- Status --}}
                            <td class="px-5 py-4">
                                @if($p->status === 'active')
                                    <span class="inline-flex px-2.5 py-1
                                                 rounded-full text-xs
                                                 font-medium bg-emerald-50
                                                 text-emerald-700">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex px-2.5 py-1
                                                 rounded-full text-xs
                                                 font-medium bg-red-50
                                                 text-red-700">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>


                            {{-- Waktu pembaruan --}}
                            <td class="px-5 py-4 text-xs text-slate-500
                                       whitespace-nowrap">
                                {{ $p->updated_at?->format('d M Y H:i') ?? '-' }}
                            </td>


                            {{-- Aksi --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">

                                    {{-- Admin dan Operator dapat melihat detail --}}
                                    <a
                                        href="{{ route('products.show', $p) }}"
                                        class="text-primary text-xs font-medium
                                               hover:underline"
                                    >
                                        Detail
                                    </a>


                                    {{-- Hanya Admin dapat mengubah produk --}}
                                    @if(auth()->user()->role === 'admin')

                                        <a
                                            href="{{ route('products.edit', $p) }}"
                                            class="text-amber-600 text-xs
                                                   font-medium hover:underline"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('products.destroy', $p) }}"
                                            onsubmit="return confirm(
                                                'Yakin ingin menghapus produk {{ addslashes($p->name) }}?'
                                            )"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-red-500 text-xs
                                                       font-medium hover:underline"
                                            >
                                                Hapus
                                            </button>
                                        </form>

                                    @endif

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="7"
                                class="px-5 py-12 text-center"
                            >
                                <div class="text-4xl mb-3">
                                    📦
                                </div>

                                <p class="font-medium text-slate-700">
                                    @if(request('search'))
                                        Produk tidak ditemukan.
                                    @else
                                        Belum ada produk.
                                    @endif
                                </p>

                                <p class="text-sm text-slate-400 mt-1">
                                    @if(request('search'))
                                        Coba gunakan kata kunci pencarian lain.
                                    @else
                                        Produk yang ditambahkan akan muncul di sini.
                                    @endif
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>


        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif

    </div>

</div>
@endsection