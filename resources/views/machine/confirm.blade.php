@extends('layouts.app')
@section('title','Konfirmasi Pengiriman')
@section('breadcrumb','Konfigurasi Mesin / Konfirmasi')
@section('content')
<div class="max-w-xl mx-auto bg-white rounded-xl border shadow-card p-7"><div class="text-center"><div class="w-14 h-14 mx-auto rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-2xl">!</div><h1 class="text-xl font-bold mt-4">Konfirmasi Pengiriman Konfigurasi</h1><p class="text-sm text-slate-500 mt-2">Pastikan parameter berikut sudah benar sebelum dikirim ke MC12.</p></div><div class="mt-6 space-y-3 text-sm">@foreach(['Suhu'=>'80 °C','Waktu Pemanasan'=>'120 detik','Target Slot'=>'A01'] as $k=>$v)<div class="flex justify-between p-3 bg-slate-50 rounded-lg"><span>{{ $k }}</span><b>{{ $v }}</b></div>@endforeach</div><div class="mt-6 flex justify-end gap-3"><a href="{{ route('machine.index') }}" class="px-5 py-2.5 border rounded-lg">Kembali</a><button class="px-5 py-2.5 bg-primary text-white rounded-lg">Kirim ke Simulator</button></div></div>
@endsection
