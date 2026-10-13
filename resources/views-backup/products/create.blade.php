@extends('layouts.app')
@section('title','Tambah Produk')
@section('breadcrumb','Produk / Tambah')
@section('content')
<div class="max-w-5xl mx-auto">
<div class="flex items-center justify-between mb-6"><div><h1 class="text-2xl font-bold">{{ $mode === 'create' ? 'Tambah Produk' : 'Edit Produk' }}</h1><p class="text-slate-500 text-sm mt-1">Lengkapi data produk dan pastikan validasi sudah benar.</p></div><a href="{{ route('products.index') }}" class="text-sm text-slate-500">← Kembali</a></div>
<form method="POST" action="{{ $mode === 'create' ? route('products.store') : route('products.update',$product) }}" class="bg-white rounded-xl border border-slate-200 shadow-card p-6">
@csrf
<div class="grid lg:grid-cols-[230px_1fr] gap-7">
    <div><div class="h-48 rounded-xl bg-slate-100 border border-dashed border-slate-300 flex flex-col items-center justify-center text-slate-400">📷<span class="text-xs mt-2">Preview gambar</span></div><input name="image" value="{{ old('image',$product->image ?? '') }}" class="mt-3 w-full h-10 px-3 border rounded-lg text-xs" placeholder="URL gambar (opsional)"></div>
    <div class="grid md:grid-cols-2 gap-5">
        <div class="md:col-span-2"><label class="block text-sm font-medium mb-2">Nama Produk *</label><input name="name" value="{{ old('name',$product->name ?? '') }}" required class="w-full h-11 px-4 border rounded-lg focus:border-primary outline-none" placeholder="Contoh: Nasi Ayam"></div>
        <div><label class="block text-sm font-medium mb-2">Kategori</label><select class="w-full h-11 px-4 border rounded-lg"><option>Makanan Utama</option><option>Minuman</option><option>Camilan</option></select></div>
        <div><label class="block text-sm font-medium mb-2">Harga *</label><input name="price" type="number" min="0" value="{{ old('price',$product->price ?? '') }}" required class="w-full h-11 px-4 border rounded-lg" placeholder="15000"></div>
        <div><label class="block text-sm font-medium mb-2">Stok *</label><input name="stock" type="number" min="0" value="{{ old('stock',$product->stock ?? 0) }}" required class="w-full h-11 px-4 border rounded-lg"></div>
        <div><label class="block text-sm font-medium mb-2">Status *</label><select name="status" class="w-full h-11 px-4 border rounded-lg"><option value="active" @selected(old('status',$product->status ?? 'active')==='active')>Aktif</option><option value="inactive" @selected(old('status',$product->status ?? '')==='inactive')>Tidak Aktif</option></select></div>
        <div class="md:col-span-2"><label class="block text-sm font-medium mb-2">Deskripsi</label><textarea name="description" rows="4" class="w-full px-4 py-3 border rounded-lg">{{ old('description',$product->description ?? '') }}</textarea></div>
    </div>
</div>
<div class="mt-7 pt-5 border-t flex justify-end gap-3"><a href="{{ route('products.index') }}" class="px-5 py-2.5 border rounded-lg text-sm">Batal</a><button class="px-5 py-2.5 bg-primary text-white rounded-lg text-sm font-semibold">{{ $mode === 'create' ? 'Simpan' : 'Simpan Perubahan' }}</button></div>
</form></div>
@endsection
