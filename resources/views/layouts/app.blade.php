<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') | FoodMachine MC07</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#101D3A',
                        primary: '#2864F0',
                        soft: '#F4F7FC',
                        accent: '#18B981'
                    },
                    boxShadow: {
                        card: '0 4px 20px rgba(29, 61, 114, .06)',
                        soft: '0 8px 30px rgba(29, 61, 114, .08)'
                    }
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #33466B;
            border-radius: 10px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 13px;
            border-radius: 11px;
            transition: all .2s ease;
        }

        .menu-link:hover {
            background: rgba(255,255,255,.09);
            color: white;
        }

        .menu-active {
            color: white !important;
            background: linear-gradient(100deg, #3478FF, #2460E8);
            box-shadow: 0 5px 15px rgba(20, 82, 220, .24);
        }

        .page-card {
            background: white;
            border: 1px solid #E8EEF7;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(29, 61, 114, .045);
        }

        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 1023px) {
            .sidebar-mobile {
                transform: translateX(-100%);
                transition: transform .25s ease;
            }

            .sidebar-mobile.open {
                transform: translateX(0);
            }

            .sidebar-overlay.open {
                display: block;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-[#F4F7FC] text-slate-800 antialiased">

@php
    $user = auth()->user();
    $role = $user?->role ?? 'operator';
    $isAdmin = $role === 'admin';
    $routeName = request()->route()?->getName() ?? '';

    $menus = [
        [
            'route' => 'dashboard',
            'label' => 'Dashboard',
            'icon' => '▦',
            'pattern' => 'dashboard'
        ],
        [
            'route' => 'products.index',
            'label' => 'Produk',
            'icon' => '▣',
            'pattern' => 'products.*'
        ],
        [
            'route' => 'users.index',
            'label' => 'Pengguna',
            'icon' => '♙',
            'pattern' => 'users.*',
            'admin' => true
        ],
        [
            'route' => 'restock.index',
            'label' => 'Restock / Stok',
            'icon' => '↕',
            'pattern' => 'restock.*'
        ],
        [
            'route' => 'slots.index',
            'label' => 'Slot Mapping',
            'icon' => '▦',
            'pattern' => 'slots.*'
        ],
        [
            'route' => 'approvals.index',
            'label' => 'Approval Queue',
            'icon' => '✓',
            'pattern' => 'approvals.*'
        ],
        [
            'route' => 'machine.index',
            'label' => 'Konfigurasi Mesin',
            'icon' => '⚙',
            'pattern' => 'machine.*'
        ],
        [
            'route' => 'activities.index',
            'label' => 'Log Aktivitas',
            'icon' => '◷',
            'pattern' => 'activities.*'
        ],
    ];

    $availableMenus = collect($menus)->filter(function ($menu) use ($isAdmin) {
        if (($menu['admin'] ?? false) && !$isAdmin) {
            return false;
        }

        return \Illuminate\Support\Facades\Route::has($menu['route']);
    });
@endphp

<div class="min-h-screen">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="sidebar-mobile fixed inset-y-0 left-0 z-50 flex w-[260px] flex-col
               bg-[#101D3A] text-white lg:translate-x-0">

        {{-- LOGO --}}
        <div class="flex h-[82px] shrink-0 items-center gap-3 border-b border-white/10 px-6">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl
                        bg-gradient-to-br from-blue-400 to-blue-700
                        text-2xl font-bold shadow-lg shadow-blue-950/30">
                ♨
            </div>

            <div>
                <div class="text-lg font-bold tracking-tight">
                    FoodMachine
                </div>
                <div class="text-xs text-slate-400">
                    MC07 Management Portal
                </div>
            </div>

            <button onclick="toggleSidebar()"
                class="ml-auto text-xl text-slate-400 lg:hidden"
                aria-label="Tutup menu">
                ×
            </button>
        </div>

        {{-- NAVIGATION --}}
        <nav class="sidebar-scroll flex-1 space-y-1 overflow-y-auto px-4 py-6">

            <div class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[2px] text-slate-500">
                Menu Utama
            </div>

            @foreach($availableMenus as $menu)
                <a href="{{ route($menu['route']) }}"
                   class="menu-link text-sm font-medium
                   {{ request()->routeIs($menu['pattern']) ? 'menu-active' : 'text-slate-300' }}">

                    <span class="flex h-6 w-6 items-center justify-center text-xl">
                        {{ $menu['icon'] }}
                    </span>

                    <span>{{ $menu['label'] }}</span>

                    @if($menu['route'] === 'products.index')
                        <span class="ml-auto rounded-md bg-white/10 px-2 py-0.5 text-[10px]">
                            Data
                        </span>
                    @endif
                </a>
            @endforeach

            <div class="mb-3 mt-8 px-3 text-[10px] font-bold uppercase tracking-[2px] text-slate-500">
                Antarmuka Mesin
            </div>

            @if(\Illuminate\Support\Facades\Route::has('kiosk.dashboard'))
                <a href="{{ route('kiosk.dashboard') }}"
                   class="menu-link text-sm font-medium
                   {{ request()->routeIs('kiosk.*') ? 'menu-active' : 'text-slate-300' }}">

                    <span class="flex h-6 w-6 items-center justify-center text-xl">
                        ▣
                    </span>

                    <span>Tampilan Kiosk</span>
                </a>
            @endif
        </nav>

        {{-- SYSTEM STATUS --}}
        <div class="shrink-0 border-t border-white/10 p-4">

            <div class="rounded-xl border border-white/10 bg-white/[0.06] p-4">

                <div class="flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>

                    <span class="text-xs font-semibold text-emerald-300">
                        MC07 Portal Aktif
                    </span>
                </div>

                <p class="mt-2 text-[11px] leading-5 text-slate-400">
                    Sistem manajemen dan monitoring mesin otomatis.
                </p>

                <div class="mt-3 border-t border-white/10 pt-3 text-[10px] text-slate-500">
                    FoodMachine · MC07
                </div>

            </div>
        </div>
    </aside>

    {{-- OVERLAY MOBILE --}}
    <div id="sidebarOverlay"
         class="sidebar-overlay fixed inset-0 z-40 bg-slate-950/50 lg:hidden"
         onclick="toggleSidebar()">
    </div>

    {{-- MAIN CONTENT --}}
    <div class="min-h-screen lg:ml-[260px]">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/95 backdrop-blur">

            <div class="flex h-[76px] items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

                <div class="flex min-w-0 flex-1 items-center gap-4">

                    <button onclick="toggleSidebar()"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                               border border-slate-200 text-xl text-slate-600
                               hover:bg-slate-50 lg:hidden"
                        aria-label="Buka menu">
                        ☰
                    </button>

                    <div class="relative hidden w-full max-w-[430px] md:block">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg text-slate-400">
                            ⌕
                        </span>

                        <input type="search"
                            id="globalSearch"
                            placeholder="Cari menu atau halaman..."
                            class="h-11 w-full rounded-xl border border-slate-200
                                   bg-[#F7F9FD] pl-11 pr-4 text-sm outline-none
                                   transition focus:border-blue-400 focus:bg-white
                                   focus:ring-4 focus:ring-blue-50">
                    </div>

                    <div class="min-w-0 md:hidden">
                        <div class="truncate text-sm font-bold text-navy">
                            FoodMachine MC07
                        </div>
                        <div class="text-[11px] text-slate-400">
                            Management Portal
                        </div>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-3 sm:gap-5">

                    <div class="hidden text-right md:block">
                        <div class="text-xs font-semibold text-slate-700">
                            {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                        </div>
                        <div class="mt-1 text-[11px] text-slate-400">
                            Waktu server
                        </div>
                    </div>

                    <div class="hidden h-9 w-px bg-slate-200 md:block"></div>

                    <button type="button"
                        class="relative flex h-10 w-10 items-center justify-center rounded-xl
                               text-xl text-slate-500 hover:bg-slate-100"
                        title="Notifikasi">
                        ♧
                        <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-rose-500 ring-2 ring-white"></span>
                    </button>

                    <div class="hidden h-9 w-px bg-slate-200 sm:block"></div>

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-full
                                    bg-gradient-to-br from-blue-500 to-indigo-600
                                    text-sm font-bold text-white shadow-md shadow-blue-200">

                            {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}

                        </div>

                        <div class="hidden min-w-0 sm:block">
                            <div class="max-w-[130px] truncate text-sm font-bold text-slate-800">
                                {{ $user?->name ?? 'Pengguna' }}
                            </div>

                            <div class="text-xs capitalize text-slate-400">
                                {{ $isAdmin ? 'Administrator' : 'Operator' }}
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="rounded-lg px-2 py-2 text-xs font-semibold text-slate-500
                                   transition hover:bg-rose-50 hover:text-rose-600 sm:px-3">
                            Keluar
                        </button>
                    </form>

                </div>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="min-h-[calc(100vh-76px)] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- PAGE HEADING --}}
            <div class="mb-7 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">

                <div>
                    <div class="mb-1 flex items-center gap-2 text-xs text-slate-400">
                        <span>FoodMachine</span>
                        <span>/</span>
                        <span class="text-blue-600">
                            @yield('breadcrumb', 'Dashboard')
                        </span>
                    </div>

                    <h1 class="text-2xl font-extrabold tracking-tight text-[#14264B] sm:text-3xl">
                        @yield('page_heading', 'Dashboard')
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        @yield('page_description', 'Selamat datang di FoodMachine MC07 Portal.')
                    </p>
                </div>

                @hasSection('page_actions')
                    <div class="flex flex-wrap items-center gap-2">
                        @yield('page_actions')
                    </div>
                @endif

            </div>

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200
                            bg-emerald-50 px-4 py-3 text-sm text-emerald-700">

                    <span class="text-lg">✓</span>

                    <div class="flex-1">
                        {{ session('success') }}
                    </div>

                    <button type="button"
                        onclick="this.parentElement.remove()"
                        class="text-lg text-emerald-600 hover:text-emerald-900">
                        ×
                    </button>
                </div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if(session('error'))
                <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50
                            px-4 py-3 text-sm text-rose-700">
                    ⚠ {{ session('error') }}
                </div>
            @endif

            {{-- VALIDATION ERRORS --}}
            @if($errors->any())
                <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50
                            px-4 py-4 text-sm text-rose-700">

                    <div class="mb-2 font-bold">
                        Periksa kembali data yang kamu masukkan.
                    </div>

                    <ul class="ml-5 list-disc space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            {{-- CONTENT DARI SETIAP HALAMAN --}}
            @yield('content')

            {{-- FOOTER --}}
            <footer class="mt-10 flex flex-col justify-between gap-2 border-t border-slate-200
                           pt-5 text-[11px] text-slate-400 sm:flex-row sm:items-center">

                <div>
                    <span class="font-semibold text-slate-600">
                        FoodMachine MC07 Portal
                    </span>

                    <p class="mt-1">
                        Sistem Manajemen dan Monitoring Mesin Otomatis
                    </p>
                </div>

                <div>
                    MC07 · IoT Integration Project
                </div>

            </footer>

        </main>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        sidebar.classList.toggle('open');
        overlay.classList.toggle('open');
    }

    // Pencarian cepat untuk menu yang tampil pada sidebar.
    const globalSearch = document.getElementById('globalSearch');

    if (globalSearch) {
        globalSearch.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();

            document.querySelectorAll('#sidebar nav a').forEach(function (link) {
                const text = link.textContent.toLowerCase();

                link.style.display = text.includes(keyword) ? 'flex' : 'none';
            });
        });
    }
</script>

@stack('scripts')

</body>
</html>