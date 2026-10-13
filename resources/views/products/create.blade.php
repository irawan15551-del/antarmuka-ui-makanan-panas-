@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('breadcrumb', 'Produk / Tambah')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header Halaman --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Tambah Produk</h1>
            <p class="text-slate-500 text-sm mt-1">
                Lengkapi data produk dan pastikan validasi sudah benar.
            </p>
        </div>

        <a href="{{ route('products.index') }}"
           class="text-sm text-slate-500 hover:text-primary">
            ← Kembali
        </a>
    </div>

    {{-- Pesan Error Validasi --}}
    @if ($errors->any())
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4">
            <p class="font-semibold text-red-700">
                Data produk belum berhasil disimpan.
            </p>

            <ul class="mt-2 list-disc pl-5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Produk --}}
    <form method="POST"
          action="{{ route('products.store') }}"
          class="bg-white rounded-xl border border-slate-200 shadow-card p-6">

        @csrf

        <div class="grid lg:grid-cols-[230px_1fr] gap-7">

            {{-- Gambar Produk --}}
            <div>
                <div class="h-48 rounded-xl bg-slate-100 border border-dashed border-slate-300 flex flex-col items-center justify-center text-slate-400">
                    <span class="text-3xl">📷</span>
                    <span class="text-xs mt-2">Preview gambar</span>
                </div>

                <label for="image" class="block text-sm font-medium mt-4 mb-2">
                    URL Gambar
                </label>

                <input
                    id="image"
                    type="url"
                    name="image"
                    value="{{ old('image') }}"
                    class="w-full h-10 px-3 border rounded-lg text-sm"
                    placeholder="https://contoh.com/gambar.jpg"
                >

                @error('image')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror

                <p class="text-xs text-slate-400 mt-1">
                    Opsional. Masukkan URL gambar produk.
                </p>
            </div>

            {{-- Informasi Produk --}}
            <div class="grid md:grid-cols-2 gap-5">

                {{-- Nama Produk --}}
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium mb-2">
                        Nama Produk *
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        maxlength="255"
                        class="w-full h-11 px-4 border rounded-lg focus:border-primary outline-none"
                        placeholder="Contoh: Nasi Ayam"
                    >

                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category" class="block text-sm font-medium mb-2">
                        Kategori
                    </label>

                    <select
                        id="category"
                        name="category"
                        class="w-full h-11 px-4 border rounded-lg">

                        <option value="">Pilih kategori</option>

                        <option value="Makanan Utama"
                            @selected(old('category') === 'Makanan Utama')>
                            Makanan Utama
                        </option>

                        <option value="Minuman"
                            @selected(old('category') === 'Minuman')>
                            Minuman
                        </option>

                        <option value="Camilan"
                            @selected(old('category') === 'Camilan')>
                            Camilan
                        </option>
                    </select>

                    @error('category')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label for="price" class="block text-sm font-medium mb-2">
                        Harga (Rp) *
                    </label>

                    <input
                        id="price"
                        type="number"
                        name="price"
                        min="0"
                        step="1"
                        value="{{ old('price') }}"
                        required
                        class="w-full h-11 px-4 border rounded-lg"
                        placeholder="15000"
                    >

                    @error('price')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok --}}
                <div>
                    <label for="stock" class="block text-sm font-medium mb-2">
                        Stok *
                    </label>

                    <input
                        id="stock"
                        type="number"
                        name="stock"
                        min="0"
                        value="{{ old('stock', 0) }}"
                        required
                        class="w-full h-11 px-4 border rounded-lg"
                    >

                    @error('stock')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium mb-2">
                        Status *
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full h-11 px-4 border rounded-lg">

                        <option value="active"
                            @selected(old('status', 'active') === 'active')>
                            Aktif
                        </option>

                        <option value="inactive"
                            @selected(old('status') === 'inactive')>
                            Tidak Aktif
                        </option>
                    </select>

                    @error('status')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium mb-2">
                        Deskripsi
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="w-full px-4 py-3 border rounded-lg"
                        placeholder="Masukkan deskripsi produk...">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="mt-7 pt-5 border-t flex justify-end gap-3">

            <a href="{{ route('products.index') }}"
               class="px-5 py-2.5 border rounded-lg text-sm hover:bg-slate-50">
                Batal
            </a>

            <button
                type="submit"
                class="px-5 py-2.5 bg-primary text-white rounded-lg text-sm font-semibold hover:opacity-90">
                Simpan Produk
            </button>

        </div>

    </form>
</div>
@endsection
