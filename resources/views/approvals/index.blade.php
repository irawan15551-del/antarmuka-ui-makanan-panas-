@extends('layouts.app')
@section('title','Approval Queue')
@section('breadcrumb','Approval Queue')
@section('content')
<div class="mb-6"><h1 class="text-2xl font-bold">Antrian Persetujuan</h1><p class="text-slate-500 text-sm mt-1">Review permintaan restock dan konfigurasi mesin.</p></div>
<div class="bg-white rounded-xl border shadow-card overflow-hidden"><div class="p-4 border-b flex gap-3"><select class="h-10 border rounded-lg px-3"><option>Semua Jenis</option></select><select class="h-10 border rounded-lg px-3"><option>Semua Status</option></select></div>
<table class="w-full text-sm"><thead class="bg-slate-50"><tr><th class="p-4 text-left">No</th><th class="p-4 text-left">Jenis</th><th class="p-4 text-left">Pengaju</th><th class="p-4 text-left">Waktu</th><th class="p-4 text-left">Status</th><th class="p-4 text-left">Aksi</th></tr></thead><tbody class="divide-y">@forelse($approvals as $i=>$a)<tr><td class="p-4">{{ $i+1 }}</td><td class="p-4">{{ ucfirst($a->type ?? 'Request') }}</td><td class="p-4">{{ $a->requested_by }}</td><td class="p-4">{{ $a->created_at?->format('d M Y H:i') }}</td><td class="p-4"><span class="px-2 py-1 rounded-full text-xs bg-amber-50 text-amber-700">{{ ucfirst($a->status) }}</span></td><td class="p-4 flex gap-2"><button class="text-emerald-600 text-xs">Approve</button><button class="text-red-500 text-xs">Reject</button></td></tr>@empty<tr><td colspan="6" class="p-10 text-center text-slate-400">Belum ada approval.</td></tr>@endforelse</tbody></table></div>
@endsection
