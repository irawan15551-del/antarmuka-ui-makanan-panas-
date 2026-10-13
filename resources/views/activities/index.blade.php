@extends('layouts.app')
@section('title','Log Aktivitas')
@section('breadcrumb','Log Aktivitas')
@section('content')
<div class="mb-6"><h1 class="text-2xl font-bold">Log Aktivitas</h1><p class="text-slate-500 text-sm mt-1">Riwayat aktivitas Admin dan Operator.</p></div>
<div class="bg-white rounded-xl border shadow-card overflow-hidden"><div class="p-4 border-b flex flex-wrap gap-3"><select class="h-10 border rounded-lg px-3"><option>Semua User</option></select><select class="h-10 border rounded-lg px-3"><option>Semua Aktivitas</option></select><input type="date" class="h-10 border rounded-lg px-3"></div>
<table class="w-full text-sm"><thead class="bg-slate-50"><tr><th class="p-4 text-left">No</th><th class="p-4 text-left">Waktu</th><th class="p-4 text-left">User</th><th class="p-4 text-left">Aktivitas</th><th class="p-4 text-left">Status</th></tr></thead><tbody class="divide-y">@forelse($activities as $i=>$a)<tr><td class="p-4">{{ $i+1 }}</td><td class="p-4">{{ $a->created_at?->format('d M Y H:i') }}</td><td class="p-4">{{ $a->user?->name ?? '-' }}</td><td class="p-4">{{ $a->description ?: $a->action }}</td><td class="p-4"><span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs">Berhasil</span></td></tr>@empty<tr><td colspan="5" class="p-10 text-center text-slate-400">Belum ada aktivitas.</td></tr>@endforelse</tbody></table></div>
@endsection
