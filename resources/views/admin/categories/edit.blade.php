@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
    <div class="border-b border-zinc-100 pb-4 mb-4">
        <h3 class="text-lg font-semibold text-zinc-950">Edit Kategori</h3>
        <p class="text-sm text-zinc-500 mt-1">Ubah informasi data kategori yang dipilih.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-600 border border-red-200">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category->ID_KATEGORI) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT') 
        
        <div>
            <label class="block text-sm font-medium text-zinc-700">ID Kategori (Tidak dapat diubah)</label>
            <input type="text" disabled value="{{ $category->ID_KATEGORI }}" class="mt-2 w-full rounded-md border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-500 outline-none cursor-not-allowed">
        </div>

        <div>
            <label for="NAMA_KATEGORI" class="block text-sm font-medium text-zinc-700">Nama Kategori</label>
            <input id="NAMA_KATEGORI" name="NAMA_KATEGORI" type="text" required value="{{ old('NAMA_KATEGORI', $category->NAMA_KATEGORI) }}" class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="Contoh: Pakaian Pria">
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-100 mt-6">
            <a href="{{ route('admin.categories.index') }}" class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 hover:bg-zinc-50 transition">
                Batal
            </a>
            <button type="submit" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800 transition shadow-sm">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection