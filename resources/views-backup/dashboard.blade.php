@extends('layouts.app')
@section('title', $user->role === 'admin' ? 'Dashboard Admin' : 'Dashboard Operator')
@section('breadcrumb','Dashboard')
@section('content')
@php
    $isAdmin = $user->role === 'admin';
    $total = \App\Models\Product::count();
    $activeCount = \App\Models\Product::where('status','active')->count();
    $inactiveCount = \App\Models\Product::where('status','inactive')->count();
    $deletedCount = \App\Models\Product::onlyTrashed()->count();
    $lowStock = \App\Models\Product::whereBetween('stock',[1,5])->count();
    $outStock = \App\Models\Product::where('stock',0)->count();
    $recent = \App\Models\Product::latest()->take(5)->get();
@endphp
<div class="flex items-start justify-between mb-7">
    <div><h1 class="text-2xl font-bold">Dashboard {{ $isAdmin ? 'Admin' : 'Operator' }}</h1><p class="text-slate-500 mt-1">Selamat datang, {{ $user->name }} 👋</p></div>
    <div class="text-xs text-slate-400">{{ now()->format('d M Y H:i') }}</div>
</div>
<div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    @foreach(($isAdmin ? [
        ['Total Produk',$total,'📦','bg-blue-50 text-primary'],
        ['Produk Aktif',$activeCount,'✓','bg-emerald-50 text-emerald-600'],
        ['Produk Tidak Aktif',$inactiveCount,'!','bg-amber-50 text-amber-600'],
        ['Produk Dihapus',$deletedCount,'×','bg-red-50 text-red-600'],
    ] : [
        ['Total Produk',$total,'📦','bg-blue-50 text-primary'],
        ['Produk Aktif',$activeCount,'✓','bg-emerald-50 text-emerald-600'],
        ['Stok Menipis',$lowStock,'!','bg-amber-50 text-amber-600'],
        ['Stok Habis',$outStock,'×','bg-red-50 text-red-600'],
    ]) as $card)
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-card"><div class="flex justify-between"><div><p class="text-xs text-slate-500">{{ $card[0] }}</p><p class="text-2xl font-bold mt-2">{{ $card[1] }}</p></div><div class="w-10 h-10 rounded-lg {{ $card[3] }} flex items-center justify-center">{{ $card[2] }}</div></div></div>
    @endforeach
</div>
<div class="grid xl:grid-cols-[1.5fr_1fr] gap-5">
    <div class="bg-white rounded-xl border border-slate-200 shadow-card">
        <div class="p-5 border-b flex justify-between"><h2 class="font-bold">Produk Terbaru</h2><a class="text-xs text-primary" href="{{ route('products.index') }}">Lihat Semua</a></div>
        <div class="overflow-x-auto"><table class="w-full text-sm"><thead class="bg-slate-50 text-slate-500"><tr><th class="text-left px-5 py-3">Nama Produk</th><th class="text-left px-5 py-3">Harga</th><th class="text-left px-5 py-3">Status</th><th class="text-left px-5 py-3">Tanggal</th></tr></thead>
        <tbody class="divide-y">@forelse($recent as $p)<tr><td class="px-5 py-3 font-medium">{{ $p->name }}</td><td class="px-5 py-3">Rp {{ number_format($p->price,0,',','.') }}</td><td class="px-5 py-3"><span class="px-2 py-1 rounded-full text-xs {{ $p->status==='active'?'bg-emerald-50 text-emerald-700':'bg-red-50 text-red-700' }}">{{ ucfirst($p->status) }}</span></td><td class="px-5 py-3 text-slate-500">{{ $p->created_at?->format('d M Y H:i') }}</td></tr>@empty<tr><td colspan="4" class="p-8 text-center text-slate-400">Belum ada produk.</td></tr>@endforelse</tbody></table></div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 shadow-card">
        <div class="p-5 border-b flex justify-between"><h2 class="font-bold">{{ $isAdmin ? 'Aktivitas Terbaru' : 'Notifikasi' }}</h2><a class="text-xs text-primary" href="{{ route('activities.index') }}">Lihat Semua</a></div>
        <div class="p-4 space-y-3">
            @forelse(\App\Models\Activity::latest()->take(5)->get() as $a)
            <div class="flex gap-3 p-3 rounded-lg bg-slate-50"><div class="w-8 h-8 rounded-full bg-blue-100 text-primary flex items-center justify-center">•</div><div><p class="text-sm">{{ $a->description ?: $a->action }}</p><p class="text-[11px] text-slate-400 mt-1">{{ $a->created_at?->format('d M Y H:i') }}</p></div></div>
            @empty
            @foreach(['Produk berhasil dikelola melalui portal','Periksa stok yang menipis','Pastikan konfigurasi mesin sesuai parameter'] as $n)<div class="flex gap-3 p-3 rounded-lg bg-slate-50"><div class="w-8 h-8 rounded-full bg-blue-100 text-primary flex items-center justify-center">i</div><div class="text-sm">{{ $n }}</div></div>@endforeach
            @endforelse
        </div>
    </div>
</div>
@endsection
