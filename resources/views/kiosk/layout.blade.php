<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FoodMachine') | MC07</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { color-scheme: light; }
        body { background:#f5f7fb; color:#172033; }
        .fm-card { background:#fff; border:1px solid #e8edf5; border-radius:18px; box-shadow:0 5px 20px rgba(20,40,80,.035); }
        .fm-link { display:flex; align-items:center; gap:.8rem; padding:.75rem .9rem; border-radius:12px; color:#64748b; font-size:.92rem; font-weight:600; transition:.18s; }
        .fm-link:hover,.fm-link.active { background:#eaf2ff; color:#245fe7; }
        .fm-btn { display:inline-flex; align-items:center; justify-content:center; gap:.45rem; border-radius:11px; padding:.7rem 1rem; font-size:.88rem; font-weight:700; transition:.18s; }
        .fm-primary { background:#2864e8; color:white; box-shadow:0 5px 12px rgba(40,100,232,.17); }
        .fm-primary:hover { background:#1e50c5; }
        .fm-muted { background:#f1f5f9; color:#475569; }
        .fm-muted:hover { background:#e2e8f0; }
        .fm-input { width:100%; border:1px solid #dce4ef; background:#fff; border-radius:11px; padding:.7rem .85rem; outline:none; }
        .fm-input:focus { border-color:#6c95f3; box-shadow:0 0 0 3px rgba(40,100,232,.1); }
        .fm-label { display:block; margin-bottom:.4rem; color:#475569; font-size:.86rem; font-weight:700; }
        .fm-table th { background:#f8fafc; color:#64748b; font-size:.75rem; text-transform:uppercase; letter-spacing:.06em; font-weight:800; }
        .fm-table th,.fm-table td { padding:1rem 1.1rem; text-align:left; border-bottom:1px solid #edf1f7; }
        .fm-table tr:last-child td { border-bottom:0; }
        .fm-badge { display:inline-flex; align-items:center; gap:.35rem; border-radius:999px; padding:.32rem .65rem; font-size:.75rem; font-weight:800; }
        @media(max-width:767px) { .fm-table th,.fm-table td { padding:.75rem; } }
    </style>
</head>
<body class="min-h-screen">
<div class="min-h-screen md:flex">
    <aside class="w-full md:w-64 md:min-h-screen bg-white border-r border-slate-200/80 md:fixed md:inset-y-0 md:left-0 z-20">
        <div class="px-6 py-6 flex items-center gap-3">
            <div class="h-11 w-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black text-lg shadow-lg shadow-blue-200">F</div>
            <div><div class="font-extrabold text-slate-900 tracking-tight">FoodMachine</div><div class="text-xs text-slate-400 mt-0.5">Smart Vending · MC07</div></div>
        </div>
        <div class="px-4 pb-3"><div class="text-[10px] font-extrabold text-slate-400 tracking-[.18em] px-3 mb-2">MENU UTAMA</div>
            <nav class="space-y-1">
                <a class="fm-link {{ request()->routeIs('kiosk.dashboard') ? 'active' : '' }}" href="{{ route('kiosk.dashboard') }}"><span>▦</span> Dashboard</a>
                <a class="fm-link {{ request()->routeIs('kiosk.products') || request()->routeIs('kiosk.product-detail') ? 'active' : '' }}" href="{{ route('kiosk.products') }}"><span>▤</span> Manajemen Produk</a>
                <a class="fm-link {{ request()->routeIs('kiosk.machine-status') ? 'active' : '' }}" href="{{ route('kiosk.machine-status') }}"><span>◉</span> Status Mesin</a>
                <a class="fm-link {{ request()->routeIs('kiosk.configuration*') ? 'active' : '' }}" href="{{ route('kiosk.configuration') }}"><span>⚙</span> Konfigurasi Mesin</a>
            </nav>
            <div class="text-[10px] font-extrabold text-slate-400 tracking-[.18em] px-3 mt-7 mb-2">PREFERENSI</div>
            <nav class="space-y-1">
                <a class="fm-link {{ request()->routeIs('kiosk.settings') ? 'active' : '' }}" href="{{ route('kiosk.settings') }}"><span>☷</span> Pengaturan</a>
            </nav>
        </div>
        <div class="hidden md:block absolute bottom-5 left-4 right-4">
            <div class="rounded-2xl bg-blue-50 p-4 border border-blue-100">
                <div class="text-sm font-bold text-blue-900">Panel Operasional</div>
                <p class="text-xs text-blue-700/80 mt-1 leading-5">Kelola produk dan parameter mesin dari satu tempat.</p>
            </div>
        </div>
    </aside>
    <main class="flex-1 md:ml-64 min-w-0">
        <header class="sticky top-0 z-10 bg-white/90 backdrop-blur border-b border-slate-200/80 px-5 md:px-9 py-4 flex items-center justify-between gap-4">
            <div><div class="text-xs font-semibold text-slate-400">FoodMachine / MC07</div><div class="font-bold text-slate-800 mt-1">@yield('crumb', 'Portal Operasional')</div></div>
            <div class="flex items-center gap-3">
                <div class="hidden sm:block text-right"><div class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Pengguna' }}</div><div class="text-xs text-slate-400">Admin / Operator</div></div>
                <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-extrabold">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
            </div>
        </header>
        <div class="p-5 md:p-9 max-w-[1500px] mx-auto">
            @if(session('success')) <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800">✓ {{ session('success') }}</div> @endif
            @if(session('error')) <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-800">! {{ session('error') }}</div> @endif
            @if($errors->any()) <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800"><div class="font-bold mb-1">Periksa kembali input kamu:</div><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
            @yield('content')
            <footer class="mt-10 text-xs text-slate-400 flex flex-wrap justify-between gap-2"><span>© {{ date('Y') }} FoodMachine · PBLIF3-MC07</span><span>Portal Admin & Operator</span></footer>
        </div>
    </main>
</div>
</body>
</html>
