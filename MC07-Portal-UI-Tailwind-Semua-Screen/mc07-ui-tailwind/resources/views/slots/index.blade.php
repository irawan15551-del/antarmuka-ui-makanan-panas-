@extends('layouts.app')
@section('title','Slot Mapping')
@section('breadcrumb','Slot Mapping')
@section('content')
<div class="flex justify-between mb-6"><div><h1 class="text-2xl font-bold">Slot Mapping</h1><p class="text-slate-500 text-sm mt-1">Atur pemetaan produk pada slot mesin.</p></div><button class="px-4 py-2.5 bg-primary text-white rounded-lg text-sm">Edit Mapping</button></div>
<div class="bg-white rounded-xl border shadow-card overflow-hidden"><table class="w-full text-sm"><thead class="bg-slate-50"><tr><th class="p-4 text-left">Slot</th><th class="p-4 text-left">Produk</th><th class="p-4 text-left">Status</th><th class="p-4 text-left">Aksi</th></tr></thead><tbody class="divide-y">
@php $slots=['A01','A02','A03','A04','A05','A06']; $prods=\App\Models\Product::take(6)->get(); @endphp
@foreach($slots as $i=>$slot)<tr><td class="p-4 font-semibold">{{ $slot }}</td><td class="p-4">{{ $prods[$i]->name ?? 'Belum terisi' }}</td><td class="p-4"><span class="px-2 py-1 rounded-full text-xs {{ isset($prods[$i])?'bg-emerald-50 text-emerald-700':'bg-slate-100 text-slate-500' }}">{{ isset($prods[$i])?'Terisi':'Kosong' }}</span></td><td class="p-4"><button class="text-primary text-xs">Edit</button></td></tr>@endforeach
</tbody></table></div>
@endsection
