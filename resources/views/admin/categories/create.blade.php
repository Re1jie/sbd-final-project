@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">
    <div class="mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-emerald-600 hover:underline text-sm">&larr; Kembali ke Daftar Kategori</a>
        <h1 class="text-2xl font-bold text-zinc-950 mt-2">Tambah Kategori Baru</h1>
    </div>

    <div class="bg-white shadow border border-zinc-200 rounded-lg p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="ID_KATEGORI" class="block text-sm font-semibold text-zinc-700 mb-2">ID Kategori (Unik) *</label>
                <input type="number" name="ID_KATEGORI" id="ID_KATEGORI" value="{{ old('ID_KATEGORI') }}" 
                       class="w-full px-3 py-2 border border-zinc-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 @error('ID_KATEGORI') border-red-500 @enderror" placeholder="Contoh: 10, 20, 30">
                @error('ID_KATEGORI')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="NAMA_KATEGORI" class="block text-sm font-semibold text-zinc-700 mb-2">Nama Kategori *</label>
                <input type="text" name="NAMA_KATEGORI" id="NAMA_KATEGORI" value="{{ old('NAMA_KATEGORI') }}" 
                       class="w-full px-3 py-2 border border-zinc-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 @error('NAMA_KATEGORI') border-red-500 @enderror" placeholder="Masukkan nama kategori">
                @error('NAMA_KATEGORI')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3 border-t border-zinc-100 pt-4">
                <a href="{{ route('admin.categories.index') }}" class="bg-zinc-100 hover:bg-zinc-200 text-zinc-700 font-semibold py-2 px-4 rounded shadow-sm text-sm">Batal</a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded shadow-sm text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection