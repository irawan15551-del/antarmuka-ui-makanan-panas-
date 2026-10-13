<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MC07 Portal')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#061B33',
                        primary: '#1769E0',
                        soft: '#F4F8FD'
                    },
                    boxShadow: {
                        card: '0 6px 24px rgba(16, 54, 95, .08)'
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        .scrollbar::-webkit-scrollbar{width:6px;height:6px}.scrollbar::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:999px}
    </style>
</head>
<body class="bg-[#F5F9FE] text-slate-800">
@php
    $user = auth()->user();
    $role = $user?->role ?? 'operator';
    $isAdmin = $role === 'admin';
    $active = request()->routeIs('*') ? request()->route()->getName() : '';
@endphp

<div class="min-h-screen flex">
    <aside class="w-[238px] bg-[#061B33] text-white fixed inset-y-0 left-0 z-40 hidden lg:flex flex-col">
        <div class="h-16 px-5 flex items-center gap-3 border-b border-white/10">
            <div class="w-9 h-9 rounded-lg bg-primary flex items-center justify-center font-bold">MC</div>
            <div>
                <div class="font-bold text-sm">MC07 Portal</div>
                <div class="text-[10px] text-slate-400">Admin & Operator</div>
            </div>
        </div>

        <nav class="px-3 py-4 space-y-1 text-sm overflow-y-auto scrollbar">
            @php
                $menus = [
                    ['dashboard','Dashboard','📊','dashboard'],
                    ['products.index','Produk','📦','products.*'],
                    ['restock.index','Restock / Stok','↕','restock.*'],
                    ['slots.index','Slot Mapping','▦','slots.*'],
                    ['users.index','Pengguna','♙','users.*'],
                    ['approvals.index','Approval Queue','✓','approvals.*'],
                    ['machine.index','Konfigurasi Mesin','⚙','machine.*'],
                    ['activities.index','Log Aktivitas','≡','activities.*'],
                ];
            @endphp
            @foreach($menus as [$route,$label,$icon,$pattern])
                @if($route === 'users.index' && !$isAdmin)
                    @continue
                @endif
                <a href="{{ route($route) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
                   {{ request()->routeIs($pattern) ? 'bg-primary text-white shadow-lg shadow-blue-900/20' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <span class="w-5 text-center">{{ $icon }}</span>
                    <span>{{ $label }}</span>
                </a>
            @endforeach
        </nav>

        <div class="mt-auto p-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-slate-600 flex items-center justify-center text-sm">
                    {{ strtoupper(substr($user?->name ?? 'U',0,1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <div class="font-semibold text-sm truncate">{{ $user?->name ?? 'User' }}</div>
                    <div class="text-[11px] text-slate-400">{{ $isAdmin ? 'Administrator' : 'Operator' }}</div>
                </div>
            </div>
        </div>
    </aside>

    <main class="lg:ml-[238px] flex-1 min-w-0">
        <header class="h-16 bg-white border-b border-slate-200 px-5 lg:px-8 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button class="lg:hidden text-slate-600">☰</button>
                <div class="text-sm font-semibold text-slate-500">@yield('breadcrumb','Portal')</div>
            </div>
            <div class="flex items-center gap-5">
                <button class="relative text-slate-500">🔔<span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-red-500"></span></button>
                <div class="flex items-center gap-2 text-sm">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-primary flex items-center justify-center font-bold">{{ strtoupper(substr($user?->name ?? 'U',0,1)) }}</div>
                    <span class="hidden sm:block">{{ $user?->name ?? 'User' }}</span>
                    <span class="text-slate-400">▾</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-xs text-slate-500 hover:text-red-600">Logout</button>
                </form>
            </div>
        </header>

        <div class="p-5 lg:p-8">
            @if(session('success'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 flex justify-between">
                    <span>✓ {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()">×</button>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">⚠ {{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <div class="font-semibold mb-1">Periksa kembali input:</div>
                    <ul class="list-disc ml-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
