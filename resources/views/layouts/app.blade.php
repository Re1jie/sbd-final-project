<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Toko Online SBD' }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">
    <div class="flex min-h-screen flex-col lg:flex-row">
        
        {{-- ================================================================
             SIDEBAR KHUSUS ADMIN (Hanya muncul jika rolenya 'admin')
        ================================================================ --}}
        @if(Auth::check() && Auth::user()->isAdmin())
        <aside class="hidden w-64 shrink-0 flex-col justify-between border-r border-slate-800 bg-slate-900 px-5 py-6 text-slate-300 shadow-xl lg:flex z-30 sticky top-0 h-screen overflow-y-auto">
            <div>
                <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-2 mb-8 transition-all">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/30 transition-transform group-hover:rotate-6">
                        <i class="fa-solid fa-store text-lg"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-extrabold tracking-widest text-emerald-400 uppercase">Admin Panel</span>
                        <h1 class="text-lg font-extrabold text-white tracking-tight leading-none">KOPDES<span class="text-emerald-400">Shop</span></h1>
                    </div>
                </a>

                <nav class="space-y-1.5">
                    <a href="{{ route('dashboard') }}" 
                        class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-500/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-gauge-high w-5 text-center text-lg {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}" 
                        class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-all {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-500/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-box w-5 text-center text-lg {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        <span>Produk</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" 
                        class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-md shadow-emerald-500/25' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-tags w-5 text-center text-lg {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-400' }}"></i>
                        <span>Kategori</span>
                    </a>

                    <div class="pt-3 pb-1 px-3 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">Manajemen Toko</div>

                    <a href="{{ route('admin.customers.index') }}" 
                        class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-all {{ request()->routeIs('admin.customers.*') ? 'bg-slate-800 text-emerald-400 border border-slate-700' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-users w-5 text-center text-base"></i>
                        <span>Pelanggan</span>
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" 
                        class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-semibold transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-slate-800 text-emerald-400 border border-slate-700' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-cart-flatbed w-5 text-center text-base"></i>
                        <span>Pesanan</span>
                    </a>
                </nav>
            </div>

            <div class="rounded-2xl bg-slate-800/60 p-4 border border-slate-700/60 text-xs">
                <div class="flex items-center gap-2 font-bold text-emerald-400 mb-1">
                    <i class="fa-solid fa-database"></i> SQL Server
                </div>
                <p class="text-slate-400 text-[11px] leading-relaxed">Koneksi aktif ke database <span class="text-white font-semibold">SBD Final</span>.</p>
            </div>
        </aside>
        @endif

        {{-- ================================================================
             KONTEN UTAMA & NAVBAR ATAS
        ================================================================ --}}
        <div class="flex min-w-0 flex-1 flex-col bg-slate-50 min-h-screen">
            
            <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/80 backdrop-blur-md shadow-2xs transition-all">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3.5 sm:px-6 lg:px-8">
                    
                    <div class="flex items-center gap-4">
                        @if(!Auth::check() || !Auth::user()->isAdmin())
                        <a href="{{ route('catalog.index') }}" class="flex items-center gap-2.5 group mr-2 sm:mr-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white shadow-md shadow-emerald-500/20 transition-transform group-hover:scale-105">
                                <i class="fa-solid fa-bag-shopping text-lg"></i>
                            </div>
                            <div class="leading-none">
                                <span class="text-[10px] font-extrabold tracking-widest text-emerald-600 uppercase">Toko Online</span>
                                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight leading-none">KOPDES<span class="text-emerald-600">Shop</span></h1>
                            </div>
                        </a>
                        @endif

                        <div class="{{ (!Auth::check() || !Auth::user()->isAdmin()) ? 'hidden md:block border-l border-slate-200 pl-4' : '' }}">
                            <div class="flex items-center gap-2.5">
                                <h2 class="text-lg font-extrabold text-slate-900 tracking-tight">{{ $pageTitle ?? 'Katalog Produk' }}</h2>
                                @auth
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700 border border-emerald-200/80 shadow-2xs">
                                        <i class="fa-solid fa-circle text-[8px] text-emerald-500 animate-pulse"></i> 
                                        {{ Auth::user()->ROLE }}
                                    </span>
                                @endauth
                            </div>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">
                                {{ Auth::check() ? 'Selamat datang kembali, ' . Auth::user()->NAMA : 'Silakan masuk atau daftar untuk mulai berbelanja' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 sm:gap-3">
                        
                        @if(!request()->routeIs('login', 'register') && (!Auth::check() || !Auth::user()->isAdmin()))

                            <a href="{{ route('catalog.index') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-bold text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-all">
                                <i class="fa-solid fa-border-all text-emerald-600 text-base"></i>
                                <span class="hidden sm:inline">Katalog</span>
                            </a>

                            <a href="{{ route('cart.index') }}" class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-emerald-600 transition-all shadow-2xs">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-emerald-600 text-[10px] font-bold text-white shadow-xs">
                                    <i class="fa-solid fa-bag-shopping text-[8px]"></i>
                                </span>
                            </a>

                        @endif

                        {{-- JIKA BELUM LOGIN --}}
                        @guest
                            <div class="flex items-center gap-2 pl-2 sm:pl-3 border-l border-slate-200">
                                <a href="{{ route('login') }}" class="rounded-xl px-3.5 py-2 text-sm font-bold text-slate-700 hover:bg-slate-100 transition-all">
                                    Masuk
                               </a>
                                <a href="{{ route('register') }}" class="flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-2 text-sm font-bold text-white shadow-md shadow-emerald-500/20 hover:from-emerald-500 hover:to-teal-500 transition-all">
                                    <i class="fa-solid fa-user-plus text-xs mr-0.5"></i> Daftar
                                </a>
                            </div>
                        @endguest

                        {{-- JIKA SUDAH LOGIN --}}
                        @auth
                            <div class="flex items-center gap-2.5 pl-2 sm:pl-3 border-l border-slate-200">
                                
                                @if(Auth::user()->isClient())
                                    <a href="{{ route('orders.index') }}" class="group flex items-center gap-2.5 rounded-xl border border-slate-200/80 bg-white p-1.5 pr-3 shadow-2xs hover:border-emerald-300 hover:bg-emerald-50/50 transition-all">
                                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-100 text-xs font-bold text-emerald-700 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                            <i class="fa-solid fa-clipboard-list text-sm"></i>
                                        </div>
                                        <div class="hidden text-left leading-tight sm:block">
                                            <div class="text-[10px] font-semibold text-emerald-600">Pesanan Saya</div>
                                        </div>
                                    </a>

                                    <a href="{{ route('profile.index') }}" class="group flex items-center gap-2.5 rounded-xl border border-slate-200/80 bg-white p-1.5 pr-3 shadow-2xs hover:border-emerald-300 hover:bg-emerald-50/50 transition-all">
                                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-100 text-xs font-bold text-emerald-700 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                            {{ substr(Auth::user()->NAMA, 0, 1) }}
                                        </div>
                                        <div class="hidden text-left leading-tight sm:block">
                                            <div class="max-w-[100px] truncate text-xs font-bold text-slate-800">{{ Auth::user()->NAMA }}</div>
                                            <div class="text-[10px] font-semibold text-emerald-600">Profil Saya</div>
                                        </div>
                                    </a>
                                @else
                                    <div class="flex items-center gap-2.5 rounded-xl border border-slate-200/80 bg-white p-1.5 pr-3 shadow-2xs">
                                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-100 text-xs font-bold text-indigo-700">
                                            <i class="fa-solid fa-user-shield"></i>
                                        </div>
                                        <div class="hidden text-left leading-tight sm:block">
                                            <div class="max-w-[100px] truncate text-xs font-bold text-slate-800">{{ Auth::user()->NAMA }}</div>
                                            <div class="text-[10px] font-semibold text-indigo-600">Administrator</div>
                                        </div>
                                    </div>
                                @endif

                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar dari akun?')" title="Logout" class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600 shadow-2xs hover:bg-rose-600 hover:text-white transition-all">
                                        <i class="fa-solid fa-power-off text-sm"></i>
                                    </button>
                                </form>

                            </div>
                        @endauth

                    </div>

                </div>
            </header>

            <main class="flex-1 pb-16">
                <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>

            <footer class="mt-auto border-t border-slate-200/70 bg-white py-6 text-xs text-slate-400">
                <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-4 sm:flex-row sm:px-6 lg:px-8">
                    <p class="font-medium">© {{ date('Y') }} Toko Online - SBD Final Project. All rights reserved.</p>
                    <div class="flex gap-5 font-medium text-slate-500">
                        <span class="hover:text-emerald-600 transition-colors"><i class="fa-solid fa-shield-halved mr-1 text-slate-400"></i> Keamanan SBD</span>
                        <span class="hover:text-emerald-600 transition-colors"><i class="fa-solid fa-database mr-1 text-slate-400"></i> MS SQL Server</span>
                        <span class="hover:text-emerald-600 transition-colors"><i class="fa-solid fa-code mr-1 text-slate-400"></i> Laravel 11</span>
                    </div>
                </div>
            </footer>

        </div>
    </div>
</body>
</html>