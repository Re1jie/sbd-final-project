@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">

    {{-- Flash Messages --}}
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg mb-6 text-sm flex items-center gap-2">
            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Back Link --}}
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('catalog.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">
            &larr; Lanjut Belanja (Ke Katalog)
        </a>
        <a href="{{ route('orders.index') }}" class="text-sm font-medium text-zinc-500 hover:text-zinc-700">
            Lihat Pesanan Saya &rarr;
        </a>
    </div>

    {{-- Header --}}
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 text-amber-600 mb-4">
            <i class="fa-solid fa-clock text-2xl"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-zinc-900">Menunggu Pembayaran</h1>
        <p class="text-zinc-500 mt-1">Pesanan <span class="font-bold text-zinc-700">#{{ $pesanan->ID_PESANAN }}</span> — Silakan selesaikan pembayaran Anda</p>
    </div>

    {{-- Card Utama --}}
    <div class="bg-white border border-zinc-200 rounded-2xl shadow-lg overflow-hidden">

        {{-- Status Badge --}}
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-b border-amber-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500 text-white shadow-md shadow-amber-500/30">
                    <i class="fa-solid fa-receipt text-lg"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-amber-700 uppercase tracking-wider">Status Pesanan</p>
                    <p class="text-sm font-extrabold text-amber-900">{{ $pesanan->NAMA_STATUS }}</p>
                </div>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 border border-amber-300 px-3 py-1 text-xs font-bold text-amber-800">
                <i class="fa-solid fa-circle text-[8px] text-amber-500 animate-pulse"></i>
                Belum Dibayar
            </span>
        </div>

        {{-- Detail Pesanan --}}
        <div class="p-6">
            <h3 class="font-bold text-sm text-zinc-500 uppercase tracking-wider mb-4">
                <i class="fa-solid fa-box-open mr-1"></i> Detail Produk
            </h3>

            <div class="space-y-3 mb-6">
                @foreach($items as $item)
                <div class="flex justify-between items-center py-3 px-4 rounded-xl bg-zinc-50 border border-zinc-100">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                            <i class="fa-solid fa-cube text-sm"></i>
                        </div>
                        <div>
                            <p class="font-bold text-zinc-900 text-sm">{{ $item->NAMA_PRODUK }}</p>
                            <p class="text-xs text-zinc-400">Kode: {{ $item->KODE_PRODUK }}</p>
                        </div>
                    </div>
                    <p class="font-bold text-zinc-800 text-sm">Rp{{ number_format($item->HARGA, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>

            {{-- Ringkasan Harga --}}
            <div class="border-t border-dashed border-zinc-200 pt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-zinc-500">Subtotal</span>
                    <span class="font-semibold text-zinc-700">Rp{{ number_format($pesanan->TOTAL_HARGA, 0, ',', '.') }}</span>
                </div>
                @if($pesanan->ONGKIR)
                <div class="flex justify-between text-sm">
                    <span class="text-zinc-500">Ongkos Kirim</span>
                    <span class="font-semibold text-zinc-700">Rp{{ number_format($pesanan->ONGKIR, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between items-center pt-3 border-t border-zinc-200">
                    <span class="text-zinc-600 font-bold uppercase text-sm">Total Bayar</span>
                    <span class="text-2xl font-black text-emerald-600">
                        Rp{{ number_format($pesanan->TOTAL_HARGA + ($pesanan->ONGKIR ?? 0), 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Info Tanggal --}}
        <div class="px-6 py-3 bg-zinc-50 border-t border-zinc-100 flex items-center justify-between text-xs text-zinc-500">
            <span><i class="fa-regular fa-calendar mr-1"></i> Tanggal Pesanan: <strong class="text-zinc-700">{{ date('d M Y, H:i', strtotime($pesanan->TANGGAL_PESANAN)) }}</strong></span>
            <span><i class="fa-regular fa-envelope mr-1"></i> {{ $pesanan->EMAIL }}</span>
        </div>
    </div>

    {{-- Metode Pembayaran (Dummy) --}}
    <div class="bg-white border border-zinc-200 rounded-2xl shadow-lg overflow-hidden mt-6">
        <div class="p-6">
            <h3 class="font-bold text-sm text-zinc-500 uppercase tracking-wider mb-4">
                <i class="fa-solid fa-credit-card mr-1"></i> Metode Pembayaran
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <label class="relative flex items-center gap-3 p-4 rounded-xl border-2 border-emerald-500 bg-emerald-50 cursor-pointer ring-2 ring-emerald-500/20">
                    <input type="radio" name="payment_method" checked class="sr-only">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-600 text-white">
                        <i class="fa-solid fa-building-columns text-lg"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-zinc-900">Transfer Bank</p>
                        <p class="text-xs text-zinc-500">BCA / Mandiri / BNI</p>
                    </div>
                    <i class="fa-solid fa-circle-check text-emerald-600 absolute top-2 right-2"></i>
                </label>

                <label class="relative flex items-center gap-3 p-4 rounded-xl border-2 border-zinc-200 bg-white cursor-pointer hover:border-zinc-300 transition-all">
                    <input type="radio" name="payment_method" class="sr-only">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                        <i class="fa-solid fa-wallet text-lg"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-zinc-900">E-Wallet</p>
                        <p class="text-xs text-zinc-500">GoPay / OVO / Dana</p>
                    </div>
                </label>

                <label class="relative flex items-center gap-3 p-4 rounded-xl border-2 border-zinc-200 bg-white cursor-pointer hover:border-zinc-300 transition-all">
                    <input type="radio" name="payment_method" class="sr-only">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                        <i class="fa-solid fa-qrcode text-lg"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-zinc-900">QRIS</p>
                        <p class="text-xs text-zinc-500">Scan & Pay</p>
                    </div>
                </label>
            </div>
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">

        {{-- Tombol Batalkan Pesanan --}}
        <form action="{{ route('payment.cancel', $pesanan->ID_PESANAN) }}" method="POST" 
              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('PUT')
            <button type="submit" class="group flex items-center gap-2 rounded-xl border-2 border-red-200 bg-white px-6 py-3 text-sm font-bold text-red-600 shadow-sm hover:bg-red-600 hover:text-white hover:border-red-600 hover:shadow-lg hover:shadow-red-500/20 transition-all">
                <i class="fa-solid fa-ban group-hover:animate-pulse"></i>
                Batalkan Pesanan
            </button>
        </form>

        {{-- Tombol Bayar Sekarang --}}
        <form action="{{ route('payment.pay', $pesanan->ID_PESANAN) }}" method="POST"
              onsubmit="return confirm('Konfirmasi pembayaran sebesar Rp{{ number_format($pesanan->TOTAL_HARGA + ($pesanan->ONGKIR ?? 0), 0, ',', '.') }}?')">
            @csrf
            @method('PUT')
            <button type="submit" class="group flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-8 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-500/25 hover:from-emerald-500 hover:to-teal-500 hover:shadow-xl hover:shadow-emerald-500/30 transition-all transform hover:scale-[1.02]">
                <i class="fa-solid fa-lock text-emerald-200 group-hover:text-white transition-colors"></i>
                Bayar Sekarang — Rp{{ number_format($pesanan->TOTAL_HARGA + ($pesanan->ONGKIR ?? 0), 0, ',', '.') }}
            </button>
        </form>
    </div>

    {{-- Info Keamanan --}}
    <div class="mt-6 text-center">
        <p class="text-xs text-zinc-400">
            <i class="fa-solid fa-shield-halved text-emerald-500 mr-1"></i>
            Transaksi Anda dilindungi dengan enkripsi SSL. Pembayaran ini bersifat <strong>dummy/simulasi</strong>.
        </p>
    </div>

</div>
@endsection
