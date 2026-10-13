@extends('layouts.app')
@section('title',$user->exists ? 'Edit Role Pengguna' : 'Tambah Pengguna')
@section('breadcrumb','Pengguna')
@section('content')
<div class="max-w-2xl"><h1 class="text-2xl font-bold mb-6">{{ $user->exists ? 'Edit Role Pengguna' : 'Tambah Pengguna' }}</h1>
<form method="POST" action="{{ $user->exists ? route('users.update',$user) : route('users.store') }}" class="bg-white rounded-xl border p-6 space-y-5 shadow-card">@csrf @if($user->exists) @method('PUT') @endif
<div><label class="block text-sm mb-2">Nama *</label><input name="name" value="{{ old('name',$user->name) }}" required class="w-full h-11 px-4 border rounded-lg"></div>
<div><label class="block text-sm mb-2">Username / Email *</label><input name="email" type="email" value="{{ old('email',$user->email) }}" required class="w-full h-11 px-4 border rounded-lg"></div>
@if(!$user->exists)<div><label class="block text-sm mb-2">Password *</label><input name="password" type="password" required class="w-full h-11 px-4 border rounded-lg"></div>@endif
<div><label class="block text-sm mb-2">Role *</label><select name="role" class="w-full h-11 px-4 border rounded-lg"><option value="admin" @selected(old('role',$user->role)==='admin')>Admin</option><option value="operator" @selected(old('role',$user->role)==='operator')>Operator</option></select></div>
<div class="flex justify-end gap-3 pt-4 border-t"><a href="{{ route('users.index') }}" class="px-5 py-2.5 border rounded-lg">Batal</a><button class="px-5 py-2.5 bg-primary text-white rounded-lg">{{ $user->exists ? 'Simpan' : 'Tambah Pengguna' }}</button></div>
</form></div>
@endsection
