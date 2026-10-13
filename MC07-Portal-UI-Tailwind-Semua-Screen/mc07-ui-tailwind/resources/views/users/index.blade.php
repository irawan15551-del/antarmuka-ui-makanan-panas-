@extends('layouts.app')
@section('title','Manajemen Pengguna')
@section('breadcrumb','Pengguna')
@section('content')
<div class="flex justify-between mb-6"><div><h1 class="text-2xl font-bold">Kelola Pengguna</h1><p class="text-slate-500 text-sm mt-1">Kelola akun dan role pengguna portal.</p></div><a href="{{ route('users.create') }}" class="px-4 py-2.5 bg-primary text-white rounded-lg text-sm">+ Tambah Pengguna</a></div>
<div class="bg-white rounded-xl border shadow-card overflow-hidden"><div class="p-4 border-b"><input placeholder="Cari nama pengguna..." class="w-full max-w-sm h-10 px-4 border rounded-lg"></div>
<table class="w-full text-sm"><thead class="bg-slate-50"><tr><th class="p-4 text-left">No</th><th class="p-4 text-left">Nama</th><th class="p-4 text-left">Username</th><th class="p-4 text-left">Role</th><th class="p-4 text-left">Status</th><th class="p-4 text-left">Aksi</th></tr></thead>
<tbody class="divide-y">@foreach($users as $i=>$u)<tr><td class="p-4">{{ $i+1 }}</td><td class="p-4 font-medium">{{ $u->name }}</td><td class="p-4">{{ $u->email }}</td><td class="p-4">{{ ucfirst($u->role) }}</td><td class="p-4"><span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs">Aktif</span></td><td class="p-4"><a href="{{ route('users.edit',$u) }}" class="text-primary text-xs">Edit Role</a></td></tr>@endforeach</tbody></table></div>
@endsection
