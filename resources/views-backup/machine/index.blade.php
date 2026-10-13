@extends('layouts.app')
@section('title','Konfigurasi Mesin')
@section('breadcrumb','Konfigurasi Mesin')
@section('content')
<div class="mb-6"><h1 class="text-2xl font-bold">Konfigurasi Mesin</h1><p class="text-slate-500 text-sm mt-1">Masukkan parameter yang akan dikirim ke MC12 Simulator.</p></div>
<form method="POST" action="{{ route('machine.store') }}" class="grid xl:grid-cols-[1fr_330px] gap-5">@csrf
<div class="bg-white rounded-xl border shadow-card p-6"><h2 class="font-bold mb-5">Parameter yang akan dikirim</h2>
<div class="grid md:grid-cols-2 gap-5"><div><label class="block text-sm mb-2">Suhu (°C)</label><input name="temperature" type="number" value="80" class="w-full h-11 border rounded-lg px-4"></div><div><label class="block text-sm mb-2">Waktu Pemanasan (detik)</label><input name="heating_time" type="number" value="120" class="w-full h-11 border rounded-lg px-4"></div><div><label class="block text-sm mb-2">Target Slot</label><input name="target_slot" value="A01" class="w-full h-11 border rounded-lg px-4"></div><div><label class="block text-sm mb-2">Mode</label><select name="mode" class="w-full h-11 border rounded-lg px-4"><option>Normal</option><option>Maintenance</option></select></div></div>
<div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg text-sm text-amber-800">⚠ Pastikan parameter sudah sesuai sebelum dikirim ke MC12 Simulator.</div>
<div class="mt-6 flex justify-end"><button class="px-5 py-2.5 bg-primary text-white rounded-lg font-semibold">Kirim ke Simulator</button></div></div>
<div class="bg-white rounded-xl border shadow-card p-6"><h2 class="font-bold mb-4">Status Mesin</h2><div class="p-4 rounded-xl bg-slate-50"><div class="flex justify-between"><span class="font-semibold">MC12 Simulator</span><span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs">Online</span></div><p class="text-xs text-slate-500 mt-2">Terakhir update {{ now()->format('d M Y H:i') }}</p></div><div class="mt-5 text-sm"><div class="flex justify-between py-2 border-b"><span>Suhu</span><b>80 °C</b></div><div class="flex justify-between py-2 border-b"><span>Pemanasan</span><b>120 detik</b></div><div class="flex justify-between py-2"><span>Target Slot</span><b>A01</b></div></div></div>
</form>
@endsection
