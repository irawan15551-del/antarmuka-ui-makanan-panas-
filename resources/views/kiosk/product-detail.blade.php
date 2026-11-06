@extends('kiosk.layout')
@section('title','Detail Produk')
@section('crumb','Detail Produk')
@section('content')
<div class="mb-6"><a href="{{ route('kiosk.products') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800">← Kembali ke Manajemen Produk</a></div>
@php $item = $product ?? null; @endphp
@if($item)
<div class="grid lg:grid-cols-5 gap-6"><div class="fm-card lg:col-span-2 p-5"><div class="aspect-square rounded-2xl bg-slate-100 overflow-hidden flex items-center justify-center">@if(!empty($item->image))<img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="h-full w-full object-cover">@else<span class="text-7xl">🍱</span>@endif</div></div><div class="fm-card lg:col-span-3 p-6 md:p-8"><div class="text-xs font-extrabold text-blue-600 tracking-wider">INFORMASI PRODUK</div><h1 class="text-3xl font-extrabold mt-3">{{ $item->name }}</h1><p class="text-slate-500 mt-3 leading-7">{{ $item->description ?: 'Belum ada deskripsi untuk produk ini.' }}</p><div class="text-3xl font-extrabold text-blue-700 mt-7">Rp {{ number_format((float)$item->price,0,',','.') }}</div><div class="grid sm:grid-cols-2 gap-4 mt-6"><div class="rounded-xl bg-slate-50 p-4"><div class="text-xs text-slate-400 font-bold">STOK</div><div class="text-xl font-extrabold mt-2">{{ $item->stock ?? 0 }} unit</div></div><div class="rounded-xl bg-slate-50 p-4"><div class="text-xs text-slate-400 font-bold">STATUS</div><div class="mt-2"><span class="fm-badge {{ ($item->status ?? '') === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">{{ ucfirst($item->status ?? 'unknown') }}</span></div></div></div><a href="{{ route('products.index') }}" class="fm-btn fm-primary mt-7">Kelola Produk</a></div></div>
@else
<div class="fm-card p-10 text-center"><div class="text-4xl">📦</div><h1 class="text-2xl font-extrabold mt-4">Data produk belum tersedia</h1><p class="text-slate-500 mt-2">Pastikan controller mengirim variabel <code>$product</code> ke view ini.</p><a href="{{ route('kiosk.products') }}" class="fm-btn fm-primary mt-5">Kembali</a></div>
@endif
@endsection
