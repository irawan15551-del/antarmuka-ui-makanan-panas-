<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - MC07 Portal</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#F4F8FD] flex items-center justify-center p-4">
<div class="w-full max-w-5xl bg-white rounded-2xl overflow-hidden shadow-2xl shadow-blue-100 grid md:grid-cols-2">
    <section class="hidden md:flex bg-[#06224A] text-white p-10 relative overflow-hidden">
        <div class="relative z-10 self-center">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-2xl mb-6">🍴</div>
            <h1 class="text-3xl font-bold">Portal Admin & Operator</h1>
            <p class="text-blue-200 mt-2">Mesin Penjual Makanan Panas Otomatis</p>
            <p class="text-sm text-slate-300 mt-5 max-w-sm leading-6">Kelola produk, stok, pengguna dan konfigurasi mesin dengan mudah dan aman.</p>
            <div class="mt-12 text-8xl opacity-20">▱</div>
        </div>
        <div class="absolute -bottom-20 -right-20 w-72 h-72 rounded-full border border-blue-400/20"></div>
    </section>
    <section class="p-8 sm:p-12">
        <div class="max-w-md mx-auto">
            <div class="mb-8">
                <div class="text-xs text-primary font-bold uppercase tracking-wider">MC07 Portal</div>
                <h2 class="text-2xl font-bold text-slate-900 mt-2">Masuk ke Akun Anda</h2>
                <p class="text-sm text-slate-500 mt-2">Silakan masukkan username dan password untuk melanjutkan.</p>
            </div>
            @if(session('success')) <div class="mb-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg p-3 text-sm">{{ session('success') }}</div> @endif
            @if($errors->any()) <div class="mb-4 bg-red-50 text-red-700 border border-red-200 rounded-lg p-3 text-sm">{{ $errors->first() }}</div> @endif
            <form method="POST" action="{{ route('login.process') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-2">Username / Email</label>
                    <input name="email" type="email" value="{{ old('email') }}" required placeholder="Masukkan username atau email" class="w-full h-11 px-4 rounded-lg border border-slate-300 focus:border-primary focus:ring-2 focus:ring-blue-100 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Password</label>
                    <input name="password" type="password" required placeholder="Masukkan password" class="w-full h-11 px-4 rounded-lg border border-slate-300 focus:border-primary focus:ring-2 focus:ring-blue-100 outline-none">
                </div>
                <div class="flex justify-between items-center text-sm">
                    <label class="flex gap-2 items-center"><input type="checkbox" class="rounded text-primary"> Ingat saya</label>
                    <a href="#" class="text-primary hover:underline">Lupa password?</a>
                </div>
                <button class="w-full h-11 rounded-lg bg-primary hover:bg-blue-700 text-white font-semibold">Login</button>
            </form>
        </div>
    </section>
</div>
</body>
</html>
