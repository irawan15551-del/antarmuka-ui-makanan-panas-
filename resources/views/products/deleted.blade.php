@extends('layouts.app')
@section('title','Produk Dihapus')
@section('breadcrumb','Produk / Soft Deleted')
@section('content')
<div class="flex justify-between mb-6"><div><h1 class="text-2xl font-bold">Produk Dihapus</h1><p class="text-slate-500 text-sm mt-1">Produk soft-delete masih dapat dipulihkan.</p></div><a href="{{ route('products.index') }}" class="px-4 py-2 border rounded-lg bg-white text-sm">← Kembali</a></div>
<div class="bg-white rounded-xl border border-slate-200 shadow-card overflow-hidden">
<table class="w-full text-sm"><thead class="bg-slate-50"><tr><th class="p-4 text-left">Produk</th><th class="p-4 text-left">Harga</th><th class="p-4 text-left">Dihapus</th><th class="p-4 text-left">Aksi</th></tr></thead>
<tbody class="divide-y">@forelse($products as $p)<tr><td class="p-4 font-medium">{{ $p->name }}</td><td class="p-4">Rp {{ number_format($p->price,0,',','.') }}</td><td class="p-4 text-slate-500">{{ $p->deleted_at?->format('d M Y H:i') }}</td><td class="p-4"><form method="POST" action="{{ route('products.restore',$p->id) }}">@csrf<button class="px-3 py-1.5 rounded-lg bg-blue-50 text-primary text-xs">Restore</button></form></td></tr>@empty<tr><td colspan="4" class="p-10 text-center text-slate-400">Tidak ada produk yang dihapus.</td></tr>@endforelse</tbody></table>
<div class="p-4 border-t">{{ $products->links() }}</div></div>
@endsection
