<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | FoodMachine MC07 Portal</title>

    <meta name="theme-color" content="#101D3A">
    <meta name="description" content="Login portal manajemen dan monitoring FoodMachine MC07.">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2864F0',
                        navy: '#101D3A',
                        soft: '#F4F7FC'
                    },
                    boxShadow: {
                        panel: '0 25px 80px rgba(15, 35, 75, .13)',
                        button: '0 8px 20px rgba(40, 100, 240, .25)'
                    }
                }
            }
        };
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .login-background {
            background:
                radial-gradient(circle at 10% 10%, rgba(59,130,246,.12), transparent 30%),
                radial-gradient(circle at 90% 90%, rgba(99,102,241,.10), transparent 30%),
                #F4F7FC;
        }

        .login-input {
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .login-input:focus {
            border-color: #2864F0;
            box-shadow: 0 0 0 4px rgba(40,100,240,.10);
            outline: none;
        }

        .login-button {
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(40,100,240,.30);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .decorative-circle {
            position: absolute;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 9999px;
            pointer-events: none;
        }
    </style>
</head>

<body class="login-background min-h-screen text-slate-800">

<div class="flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-10">

    <div class="grid w-full max-w-6xl overflow-hidden rounded-[28px]
                border border-white bg-white shadow-panel lg:min-h-[650px] lg:grid-cols-2">

        {{-- PANEL KIRI --}}
        <section class="relative hidden overflow-hidden bg-[#101D3A] p-10 text-white
                        md:flex md:flex-col md:justify-between lg:p-14">

            {{-- Background dekoratif --}}
            <div class="decorative-circle -right-24 -top-24 h-80 w-80"></div>
            <div class="decorative-circle -right-10 -top-10 h-52 w-52"></div>

            <div class="absolute -bottom-40 -left-28 h-96 w-96 rounded-full
                        bg-blue-600/10 blur-2xl"></div>

            <div class="absolute -bottom-48 right-0 h-80 w-80 rounded-full
                        bg-indigo-500/10 blur-2xl"></div>

            {{-- Brand --}}
            <div class="relative z-10 flex items-center gap-3">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl
                            bg-gradient-to-br from-blue-400 to-blue-700
                            text-2xl shadow-lg shadow-blue-950/40">
                    ♨
                </div>

                <div>
                    <div class="text-xl font-extrabold tracking-tight">
                        FoodMachine
                    </div>

                    <div class="mt-0.5 text-xs text-blue-200">
                        MC07 Management Portal
                    </div>
                </div>

            </div>

            {{-- Main illustration and text --}}
            <div class="relative z-10 my-12">

                <div class="mb-6 inline-flex items-center gap-2 rounded-full
                            border border-blue-300/20 bg-blue-400/10
                            px-4 py-2 text-xs font-medium text-blue-100">

                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    Portal Admin & Operator
                </div>

                <h1 class="max-w-lg text-4xl font-extrabold leading-tight tracking-tight
                           lg:text-5xl">
                    Kelola Mesin.
                    <span class="block text-blue-400">
                        Pantau Lebih Mudah.
                    </span>
                </h1>

                <p class="mt-6 max-w-md text-sm leading-7 text-slate-300 lg:text-base">
                    Satu portal untuk mengelola produk, memantau stok,
                    mengatur konfigurasi, dan mendukung operasional
                    mesin penjual makanan panas otomatis.
                </p>

                {{-- Decorative machine card --}}
                <div class="mt-10 max-w-md rounded-2xl border border-white/10
                            bg-white/[0.06] p-5 backdrop-blur-sm">

                    <div class="flex items-center gap-4">

                        <div class="flex h-14 w-14 shrink-0 items-center justify-center
                                    rounded-2xl bg-blue-500/15 text-3xl">
                            ▣
                        </div>

                        <div class="flex-1">
                            <div class="font-semibold">
                                Machine Management
                            </div>

                            <div class="mt-1 text-xs leading-5 text-slate-400">
                                Produk, stok, dan konfigurasi mesin dalam satu tempat.
                            </div>
                        </div>

                        <div class="text-2xl text-blue-400">→</div>

                    </div>
                </div>
            </div>

            <div class="relative z-10 flex items-center justify-between
                        border-t border-white/10 pt-5 text-[11px] text-slate-400">

                <span>FoodMachine MC07</span>
                <span>IoT Integration Project</span>

            </div>
        </section>


        {{-- PANEL KANAN: FORM LOGIN --}}
        <section class="flex items-center justify-center bg-white px-6 py-10
                        sm:px-12 lg:px-14">

            <div class="w-full max-w-md">

                {{-- Mobile brand --}}
                <div class="mb-10 flex items-center gap-3 md:hidden">

                    <div class="flex h-12 w-12 items-center justify-center
                                rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700
                                text-2xl text-white shadow-lg shadow-blue-200">
                        ♨
                    </div>

                    <div>
                        <div class="text-lg font-extrabold text-[#101D3A]">
                            FoodMachine
                        </div>

                        <div class="text-xs text-slate-400">
                            MC07 Management Portal
                        </div>
                    </div>

                </div>

                {{-- Heading --}}
                <div class="mb-8">

                    <div class="mb-4 flex h-12 w-12 items-center justify-center
                                rounded-2xl bg-blue-50 text-2xl text-primary">
                        ↗
                    </div>

                    <p class="text-xs font-bold uppercase tracking-[2px] text-primary">
                        Selamat Datang
                    </p>

                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight
                               text-[#101D3A] sm:text-4xl">
                        Masuk ke Portal
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        Masukkan akun kamu untuk mengakses dashboard
                        manajemen FoodMachine.
                    </p>

                </div>


                {{-- Success message --}}
                @if(session('success'))
                    <div class="mb-5 flex gap-3 rounded-xl border border-emerald-200
                                bg-emerald-50 p-4 text-sm text-emerald-700">

                        <span class="text-lg">✓</span>

                        <div>
                            {{ session('success') }}
                        </div>

                    </div>
                @endif


                {{-- Error message --}}
                @if($errors->any())
                    <div class="mb-5 flex gap-3 rounded-xl border border-rose-200
                                bg-rose-50 p-4 text-sm text-rose-700">

                        <span class="text-lg">!</span>

                        <div>
                            <div class="font-semibold">
                                Login belum berhasil.
                            </div>

                            <div class="mt-1">
                                {{ $errors->first() }}
                            </div>
                        </div>

                    </div>
                @endif


                {{-- Login form --}}
                <form method="POST"
                      action="{{ route('login.process') }}"
                      class="space-y-5">

                    @csrf

                    {{-- Email --}}
                    <div>

                        <label for="email"
                               class="mb-2 block text-sm font-semibold text-slate-700">
                            Alamat Email
                        </label>

                        <div class="relative">

                            <span class="pointer-events-none absolute left-4 top-1/2
                                         -translate-y-1/2 text-lg text-slate-400">
                                ✉
                            </span>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="nama@contoh.com"
                                class="login-input h-13 w-full rounded-xl border
                                       border-slate-200 bg-slate-50/70 py-3.5
                                       pl-12 pr-4 text-sm text-slate-800
                                       placeholder:text-slate-400"
                            >

                        </div>
                    </div>


                    {{-- Password --}}
                    <div>

                        <div class="mb-2 flex items-center justify-between">

                            <label for="password"
                                   class="block text-sm font-semibold text-slate-700">
                                Password
                            </label>

                        </div>

                        <div class="relative">

                            <span class="pointer-events-none absolute left-4 top-1/2
                                         -translate-y-1/2 text-lg text-slate-400">
                                ♙
                            </span>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                class="login-input h-13 w-full rounded-xl border
                                       border-slate-200 bg-slate-50/70 py-3.5
                                       pl-12 pr-14 text-sm text-slate-800
                                       placeholder:text-slate-400"
                            >

                            <button
                                type="button"
                                id="togglePassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2
                                       rounded-lg px-2 py-1.5 text-xs font-semibold
                                       text-slate-500 transition hover:bg-slate-100
                                       hover:text-primary"
                                aria-label="Tampilkan password"
                                aria-pressed="false">
                                Lihat
                            </button>

                        </div>
                    </div>


                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="login-button flex h-12 w-full items-center
                               justify-center gap-2 rounded-xl bg-primary
                               px-4 text-sm font-bold text-white shadow-button
                               hover:bg-blue-700 focus:outline-none
                               focus:ring-4 focus:ring-blue-100">

                        <span>Masuk ke Dashboard</span>
                        <span class="text-lg">→</span>

                    </button>

                </form>


                {{-- Security information --}}
                <div class="mt-7 flex items-start gap-3 rounded-xl
                            border border-slate-100 bg-slate-50 p-4">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center
                                rounded-lg bg-emerald-50 text-lg text-emerald-600">
                        ✓
                    </div>

                    <div>
                        <div class="text-xs font-bold text-slate-700">
                            Akses Portal Terlindungi
                        </div>

                        <p class="mt-1 text-[11px] leading-5 text-slate-500">
                            Gunakan akun yang telah terdaftar.
                            Menu yang tersedia mengikuti hak akses akun kamu.
                        </p>
                    </div>

                </div>


                {{-- Footer --}}
                <div class="mt-8 text-center text-[11px] leading-5 text-slate-400">
                    <p>
                        © {{ date('Y') }} FoodMachine MC07 Portal
                    </p>

                    <p>
                        Sistem Manajemen dan Monitoring Mesin Otomatis
                    </p>
                </div>

            </div>
        </section>

    </div>

</div>


{{-- Show / hide password --}}
<script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', function () {
        const isHidden = passwordInput.type === 'password';

        passwordInput.type = isHidden ? 'text' : 'password';

        this.textContent = isHidden ? 'Sembunyi' : 'Lihat';

        this.setAttribute('aria-pressed', String(isHidden));

        this.setAttribute(
            'aria-label',
            isHidden ? 'Sembunyikan password' : 'Tampilkan password'
        );
    });
</script>

</body>
</html>