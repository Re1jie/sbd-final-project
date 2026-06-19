@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow">
            + Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-left text-sm uppercase font-semibold">
                    <th class="px-5 py-3 border-b-2 border-gray-200">Kode</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Nama Produk</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Kategori</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Harga</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Stok</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200">Status</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse($products as $product)
                    <tr>
                        <td class="px-5 py-4 border-b border-gray-200">{{ $product->KODE_PRODUK }}</td>
                        <td class="px-5 py-4 border-b border-gray-200 font-medium">{{ $product->NAMA_PRODUK }}</td>
                        <td class="px-5 py-4 border-b border-gray-200">{{ $product->NAMA_KATEGORI ?? 'Tanpa Kategori' }}</td>
                        <td class="px-5 py-4 border-b border-gray-200">Rp{{ number_format($product->HARGA, 0, ',', '.') }}</td>
                        <td class="px-5 py-4 border-b border-gray-200">{{ $product->STOK }}</td>
                        <td class="px-5 py-4 border-b border-gray-200">
                            @if($product->STOK > 0)
                                <span class="bg-green-100 text-green-800 text-xs px-2.5 py-1 rounded-full font-semibold">Tersedia</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs px-2.5 py-1 rounded-full font-semibold">Habis</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 text-center space-x-2">
                            <a href="{{ route('admin.products.edit', $product->KODE_PRODUK) }}" class="text-yellow-600 hover:text-yellow-900 font-semibold">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->KODE_PRODUK) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-4 border-b border-gray-200 text-center text-gray-500">Belum ada data produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection