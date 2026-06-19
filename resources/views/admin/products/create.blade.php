@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Tambah Produk Baru</h2>

        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kode Produk (Unik)</label>
                <input type="number" name="KODE_PRODUK" value="{{ old('KODE_PRODUK') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline @error('KODE_PRODUK') border-red-500 @enderror">
                @error('KODE_PRODUK') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                <input type="text" name="NAMA_PRODUK" value="{{ old('NAMA_PRODUK') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline @error('NAMA_PRODUK') border-red-500 @enderror">
                @error('NAMA_PRODUK') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                <select name="ID_KATEGORI" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline @error('ID_KATEGORI') border-red-500 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->ID_KATEGORI }}" {{ old('ID_KATEGORI') == $category->ID_KATEGORI ? 'selected' : '' }}>
                            {{ $category->NAMA_KATEGORI }}
                        </option>
                    @endforeach
                </select>
                @error('ID_KATEGORI') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rupiah)</label>
                <input type="number" name="HARGA" value="{{ old('HARGA') }}" min="0" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline @error('HARGA') border-red-500 @enderror">
                @error('HARGA') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Stok</label>
                <input type="number" name="STOK" value="{{ old('STOK') }}" min="0" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline @error('STOK') border-red-500 @enderror">
                @error('STOK') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection