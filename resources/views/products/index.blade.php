@extends('layouts.app')
@section('title','Kelola Produk')
@section('breadcrumb','Produk')
@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div><h1 class="text-2xl font-bold">Kelola Produk</h1><p class="text-slate-500 text-sm mt-1">Kelola katalog, harga, stok, dan status produk.</p></div>
    <div class="flex gap-2">
        <a href="{{ route('products.deleted') }}" class="px-4 py-2.5 rounded-lg border border-slate-300 bg-white text-sm">Produk Dihapus</a>
        <a href="{{ route('products.create') }}" class="px-4 py-2.5 rounded-lg bg-primary text-white text-sm font-semibold">+ Tambah Produk</a>
    </div>
</div>
<div class="bg-white rounded-xl border border-slate-200 shadow-card overflow-hidden">
    <div class="p-4 border-b flex flex-col md:flex-row gap-3 justify-between">
        <form class="w-full md:w-80"><input name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="w-full h-10 px-4 border rounded-lg outline-none focus:border-primary"></form>
        <div class="text-xs text-slate-500 flex items-center">Total {{ $products->total() }} produk</div>
    </div>
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500"><tr><th class="px-5 py-3 text-left">No</th><th class="px-5 py-3 text-left">Nama Produk</th><th class="px-5 py-3 text-left">Harga</th><th class="px-5 py-3 text-left">Stok</th><th class="px-5 py-3 text-left">Status</th><th class="px-5 py-3 text-left">Data</th><th class="px-5 py-3 text-left">Aksi</th></tr></thead>
        <tbody class="divide-y">@forelse($products as $i=>$p)<tr class="hover:bg-slate-50">
            <td class="px-5 py-3">{{ $products->firstItem()+$i }}</td>
            <td class="px-5 py-3"><div class="font-semibold">{{ $p->name }}</div><div class="text-xs text-slate-400 truncate max-w-xs">{{ $p->description }}</div></td>
            <td class="px-5 py-3">Rp {{ number_format($p->price,0,',','.') }}</td>
            <td class="px-5 py-3">{{ $p->stock }}</td>
            <td class="px-5 py-3"><span class="px-2 py-1 rounded-full text-xs {{ $p->status==='active'?'bg-emerald-50 text-emerald-700':'bg-red-50 text-red-700' }}">{{ ucfirst($p->status) }}</span></td>
            <td class="px-5 py-3 text-xs text-slate-500">{{ $p->updated_at?->format('d M Y') }}</td>
            <td class="px-5 py-3"><div class="flex gap-2"><a class="text-primary text-xs" href="{{ route('products.show',$p) }}">Detail</a><a class="text-primary text-xs" href="{{ route('products.edit',$p) }}">Edit</a><form method="POST" action="{{ route('products.destroy',$p) }}" onsubmit="return confirm('Yakin melakukan soft delete produk ini?')">@csrf @method('DELETE')<button class="text-red-500 text-xs">Hapus</button></form></div></td>
        </tr>@empty<tr><td colspan="7" class="p-10 text-center text-slate-400">Belum ada produk.</td></tr>@endforelse</tbody>
    </table></div>
    <div class="p-4 border-t">{{ $products->links() }}</div>
</div>
@endsection
