@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Kembali ke Daftar Kategori</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Kategori</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.categories.update', $category->ID_KATEGORI) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="NAMA_KATEGORI" class="block text-sm font-semibold text-gray-700 mb-1">Nama Kategori *</label>
                <input type="text" name="NAMA_KATEGORI" id="NAMA_KATEGORI" value="{{ old('NAMA_KATEGORI', $category->NAMA_KATEGORI) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 @error('NAMA_KATEGORI') border-red-500 @enderror">
                @error('NAMA_KATEGORI')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="DESKRIPSI" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea name="DESKRIPSI" id="DESKRIPSI" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">{{ old('DESKRIPSI', $category->DESKRIPSI) }}</textarea>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded shadow-sm text-sm">Batal</a>
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded shadow-sm text-sm">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection