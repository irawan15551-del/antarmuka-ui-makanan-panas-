@extends('layouts.app')
@section('title','Restock / Stok')
@section('breadcrumb','Restock / Stok')
@section('content')
<div class="mb-6"><h1 class="text-2xl font-bold">Manajemen Stok</h1><p class="text-slate-500 text-sm mt-1">Pantau stok dan ajukan restock produk.</p></div>
<div class="bg-white rounded-xl border shadow-card overflow-hidden"><div class="p-4 border-b flex gap-3"><select class="h-10 border rounded-lg px-3"><option>Semua Kategori</option></select><input class="h-10 border rounded-lg px-4" placeholder="Cari produk..."></div>
<table class="w-full text-sm"><thead class="bg-slate-50"><tr><th class="p-4 text-left">No</th><th class="p-4 text-left">Nama Produk</th><th class="p-4 text-left">Stok</th><th class="p-4 text-left">Status Stok</th><th class="p-4 text-left">Aksi</th></tr></thead><tbody class="divide-y">
@foreach(\App\Models\Product::latest()->get() as $i=>$p)
@php $s=$p->stock===0?'Habis':($p->stock<=5?'Menipis':'Aman'); @endphp
<tr><td class="p-4">{{ $i+1 }}</td><td class="p-4 font-medium">{{ $p->name }}</td><td class="p-4">{{ $p->stock }}</td><td class="p-4"><span class="px-2 py-1 rounded-full text-xs {{ $s==='Aman'?'bg-emerald-50 text-emerald-700':($s==='Menipis'?'bg-amber-50 text-amber-700':'bg-red-50 text-red-700') }}">{{ $s }}</span></td><td class="p-4"><button class="px-3 py-1.5 rounded-lg bg-primary text-white text-xs">Restock</button></td></tr>
@endforeach</tbody></table></div>
@endsection
