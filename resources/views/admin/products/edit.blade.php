@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
    <div class="border-b border-zinc-100 pb-4 mb-4">
        <h3 class="text-lg font-semibold text-zinc-950">Edit Produk</h3>
        <p class="text-sm text-zinc-500 mt-1">Ubah informasi data produk yang dipilih.</p>
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

    <form action="{{ route('admin.products.update', $product->KODE_PRODUK) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT') <div>
            <label class="block text-sm font-medium text-zinc-700">Kode Produk (Tidak dapat diubah)</label>
            <input type="text" disabled value="{{ $product->KODE_PRODUK }}" class="mt-2 w-full rounded-md border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-500 outline-none cursor-not-allowed">
        </div>

        <div>
            <label for="NAMA_PRODUK" class="block text-sm font-medium text-zinc-700">Nama Produk</label>
            <input id="NAMA_PRODUK" name="NAMA_PRODUK" type="text" required value="{{ old('NAMA_PRODUK', $product->NAMA_PRODUK) }}" class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="Contoh: Kemeja Linen">
        </div>

        <div>
            <label for="ID_KATEGORI" class="block text-sm font-medium text-zinc-700">Kategori</label>
            <select id="ID_KATEGORI" name="ID_KATEGORI" required class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->ID_KATEGORI }}" {{ old('ID_KATEGORI', $product->ID_KATEGORI) == $category->ID_KATEGORI ? 'selected' : '' }}>
                        {{ $category->NAMA_KATEGORI }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="HARGA" class="block text-sm font-medium text-zinc-700">Harga (Rp)</label>
                <input id="HARGA" name="HARGA" type="number" min="0" required value="{{ old('HARGA', $product->HARGA) }}" class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="0">
            </div>
            <div>
                <label for="STOK" class="block text-sm font-medium text-zinc-700">Stok Barang</label>
                <input id="STOK" name="STOK" type="number" min="0" required value="{{ old('STOK', $product->STOK) }}" class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="0">
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-100 mt-6">
            <a href="{{ route('admin.products.index') }}" class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 hover:bg-zinc-50 transition">
                Batal
            </a>
            <button type="submit" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800 transition shadow-sm">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection