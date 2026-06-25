@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-extrabold text-zinc-950 mb-8">Katalog Produk</h1>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-md mb-6 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            <div class="bg-white border border-zinc-200 rounded-lg p-5 flex flex-col justify-between shadow-sm">
                <div>
                    @if(!empty($product->GAMBAR_PRODUK))
                        <div class="mb-4">
                            <img src="{{ asset($product->GAMBAR_PRODUK) }}" alt="{{ $product->NAMA_PRODUK }}" class="w-full h-48 object-cover rounded-md border border-zinc-100">
                        </div>
                    @else
                        <div class="mb-4 bg-zinc-50 w-full h-48 flex items-center justify-center rounded-md border border-zinc-100">
                            <span class="text-zinc-400 text-sm">Tidak ada gambar</span>
                        </div>
                    @endif
                    <span class="text-xs font-semibold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">
                        {{ $product->NAMA_KATEGORI ?? 'Umum' }}
                    </span>
                    <h3 class="text-lg font-bold text-zinc-950 mt-3">{{ $product->NAMA_PRODUK }}</h3>
                    <p class="text-xl font-black text-zinc-900 mt-2">Rp{{ number_format($product->HARGA, 0, ',', '.') }}</p>
                    <p class="text-xs text-zinc-500 mt-1">Sisa Stok: {{ $product->STOK }}</p>
                </div>

                <div class="mt-6">
                    @if($product->STOK > 0)
                        <form action="{{ route('cart.add', $product->KODE_PRODUK) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded text-sm transition shadow-sm">
                                + Masuk Keranjang
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-zinc-200 text-zinc-400 font-bold py-2 px-4 rounded text-sm cursor-not-allowed">
                            Habis
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection