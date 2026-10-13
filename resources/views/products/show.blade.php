@extends('layouts.app')
@section('title','Detail Produk')
@section('breadcrumb','Produk / Detail')
@section('content')
<div class="max-w-4xl mx-auto">
<div class="flex justify-between mb-6"><div><h1 class="text-2xl font-bold">Detail Produk</h1><p class="text-slate-500 text-sm mt-1">Informasi lengkap produk.</p></div><a href="{{ route('products.index') }}" class="text-sm text-slate-500">← Kembali</a></div>
<div class="bg-white border border-slate-200 rounded-xl shadow-card p-6 grid md:grid-cols-[240px_1fr] gap-7">
<div class="h-56 rounded-xl bg-slate-100 flex items-center justify-center overflow-hidden">@if($product->image)<img src="{{ $product->image }}" class="w-full h-full object-cover">@else<span class="text-7xl">🍱</span>@endif</div>
<div><div class="flex justify-between items-start gap-3"><h2 class="text-xl font-bold">{{ $product->name }}</h2><span class="px-2 py-1 rounded-full text-xs {{ $product->status==='active'?'bg-emerald-50 text-emerald-700':'bg-red-50 text-red-700' }}">{{ ucfirst($product->status) }}</span></div>
<div class="grid sm:grid-cols-2 gap-5 mt-6 text-sm"><div><span class="text-slate-400">Kategori</span><p class="font-medium mt-1">Makanan Utama</p></div><div><span class="text-slate-400">Harga</span><p class="font-medium mt-1">Rp {{ number_format($product->price,0,',','.') }}</p></div><div><span class="text-slate-400">Stok</span><p class="font-medium mt-1">{{ $product->stock }}</p></div><div><span class="text-slate-400">Diperbarui</span><p class="font-medium mt-1">{{ $product->updated_at?->format('d M Y H:i') }}</p></div></div>
<div class="mt-6"><span class="text-slate-400 text-sm">Deskripsi</span><p class="mt-1 text-sm leading-6">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p></div>
<div class="mt-7 flex justify-end gap-3"><a href="{{ route('products.edit',$product) }}" class="px-5 py-2.5 bg-primary text-white rounded-lg text-sm">Edit Produk</a></div>
</div></div>
</div>
@endsection
