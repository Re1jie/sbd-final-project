<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Sistem Toko Online' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-zinc-100 text-zinc-900">
    <div class="flex min-h-screen">
        <aside class="hidden w-64 shrink-0 border-r border-zinc-200 bg-white px-5 py-6 lg:block">
            <a href="{{ route('dashboard') }}" class="block">
                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700">SBD Final Project</p>
                <h1 class="mt-2 text-xl font-bold text-zinc-950">Toko Online</h1>
            </a>

            <nav class="mt-8 space-y-1">
            <a href="{{ route('dashboard') }}" 
                class="flex items-center rounded-md px-3 py-2 text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-800' : 'text-zinc-600 hover:bg-zinc-100' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}" 
                class="flex items-center rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-emerald-50 text-emerald-800 font-semibold' : 'text-zinc-600 hover:bg-zinc-100' }}">
                    Produk
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                class="flex items-center rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-50 text-emerald-800 font-semibold' : 'text-zinc-600 hover:bg-zinc-100' }}">
                    Kategori
                </a>

                <a href="#" class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100">Pelanggan</a>
                <a href="#" class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100">Pesanan</a>
                <a href="#" class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100">Laporan</a>
            </nav>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="border-b border-zinc-200 bg-white">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500">Antarmuka Kosong</p>
                        <h2 class="text-lg font-bold text-zinc-950">{{ $pageTitle ?? 'Sistem Toko Online' }}</h2>
                    </div>
                    <div class="rounded-md border border-zinc-200 px-3 py-2 text-sm font-medium text-zinc-600">
                        Laravel MVC
                    </div>
                </div>
            </header>

            <main class="flex-1">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
