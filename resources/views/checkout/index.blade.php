@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-2xl font-bold text-zinc-950 mb-6">Ringkasan Checkout</h1>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded mb-4 text-sm">{{ session('error') }}</div>
    @endif

    <div class="bg-white border border-zinc-200 rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="p-6">
            <h3 class="font-bold text-lg border-b pb-3 mb-4">Daftar Produk</h3>
            
            @foreach($cart as $id => $item)
                <div class="flex justify-between items-center py-2 border-b last:border-none">
                    <div>
                        <p class="font-semibold text-zinc-900">{{ $item['name'] }}</p>
                        <p class="text-sm text-zinc-500">{{ $item['quantity'] }}x @ Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                    </div>
                    <p class="font-bold text-zinc-900">
                        Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </p>
                </div>
            @endforeach
        </div>
        
        <div class="bg-zinc-50 px-6 py-4 border-t border-zinc-200 space-y-2">
            {{-- Tier benefit badge --}}
            @if($tierName !== 'Bronze')
                <div class="flex items-center gap-2 mb-1 px-3 py-1.5 rounded-lg bg-emerald-50 border border-emerald-200/60 w-fit">
                    <i class="fa-solid fa-award text-emerald-600 text-xs"></i>
                    <span class="text-[11px] font-extrabold text-emerald-700">
                        Benefit Tier {{ $tierName }}
                        @if($discountPercent > 0) — Diskon {{ $discountPercent }}% + Free Ongkir
                        @else — Free Ongkir
                        @endif
                    </span>
                </div>
            @endif

            <div class="flex justify-between items-center">
                <p class="text-zinc-500 font-semibold text-sm">Subtotal</p>
                <p class="font-bold text-zinc-700">Rp{{ number_format($totalBelanja, 0, ',', '.') }}</p>
            </div>

            {{-- Discount row (Gold & Platinum only) --}}
            @if($discountAmount > 0)
                <div class="flex justify-between items-center">
                    <p class="text-emerald-600 font-semibold text-sm">
                        <i class="fa-solid fa-tag text-xs mr-1"></i> Diskon {{ $discountPercent }}%
                    </p>
                    <p class="font-bold text-emerald-600">-Rp{{ number_format($discountAmount, 0, ',', '.') }}</p>
                </div>
            @endif

            <div class="flex justify-between items-center">
                <p class="text-zinc-500 font-semibold text-sm">
                    <i class="fa-solid fa-truck text-xs mr-1"></i> Ongkir
                </p>
                @if($ongkir === 0)
                    <div class="flex items-center gap-2">
                        <p class="text-zinc-400 line-through text-sm">Rp5.000</p>
                        <span class="text-[10px] font-extrabold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">GRATIS</span>
                    </div>
                @else
                    <p class="font-bold text-zinc-700">Rp{{ number_format($ongkir, 0, ',', '.') }}</p>
                @endif
            </div>

            <div class="flex justify-between items-center pt-2 border-t border-zinc-200">
                <p class="text-zinc-800 font-extrabold uppercase text-sm">Grand Total</p>
                <p class="text-2xl font-black text-emerald-600">Rp{{ number_format($grandTotal, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center">
        <a href="{{ route('cart.index') }}" class="text-zinc-500 hover:text-zinc-800 font-semibold text-sm">
            &larr; Kembali ke Keranjang
        </a>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded shadow-md transition">
                Konfirmasi & Buat Pesanan
            </button>
        </form>
    </div>
</div>
@endsection