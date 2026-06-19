@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-2xl font-bold text-zinc-950 mb-6">Keranjang Belanja</h1>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded mb-4 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded mb-4 text-sm">{{ session('error') }}</div>
    @endif

    @if(count($cart) > 0)
        <div class="bg-white border border-zinc-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 space-y-4">
                @php $totalSementara = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $totalSementara += $subtotal; @endphp
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-zinc-100 pb-4 last:border-none last:pb-0">
                        <div class="flex-1">
                            <h4 class="font-bold text-zinc-900 text-base">{{ $item['name'] }}</h4>
                            <p class="text-sm text-zinc-500">Rp{{ number_format($item['price'], 0, ',', '.') }} / satuan</p>
                        </div>
                        
                        <div class="flex items-center space-x-4 mt-3 sm:mt-0">
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['max_stock'] }}" class="w-16 border rounded px-2 py-1 text-sm text-center focus:ring-1 focus:ring-emerald-500 focus:outline-none">
                                <button type="submit" class="ml-2 text-xs text-blue-600 font-semibold hover:underline">Update</button>
                            </form>

                            <p class="font-bold text-zinc-950 text-sm w-24 text-right">Rp{{ number_format($subtotal, 0, ',', '.') }}</p>

                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm">&times;</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-zinc-50 px-6 py-4 flex justify-between items-center border-t border-zinc-200">
                <div>
                    <p class="text-xs text-zinc-500 uppercase tracking-wider font-semibold">Total Sementara</p>
                    <p class="text-2xl font-black text-zinc-950">Rp{{ number_format($totalSementara, 0, ',', '.') }}</p>
                </div>
                <a href="{{ route('checkout.index') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-6 rounded shadow-sm text-sm transition">
                    Lanjut ke Checkout &rarr;
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-white border border-zinc-200 rounded-lg shadow-sm">
            <p class="text-zinc-500 text-sm mb-4">Keranjang belanja Anda masih kosong.</p>
            <a href="{{ route('catalog.index') }}" class="text-sm font-semibold text-emerald-600 hover:underline">&larr; Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection