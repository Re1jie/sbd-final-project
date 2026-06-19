@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-zinc-950">Manajemen Kategori</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded shadow-sm text-sm">
            + Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded mb-4 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow border border-zinc-200 rounded-lg overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-zinc-50 text-zinc-600 text-left text-xs uppercase font-semibold border-b border-zinc-200">
                    <th class="px-5 py-3 text-center w-24">ID Kategori</th>
                    <th class="px-5 py-3">Nama Kategori</th>
                    <th class="px-5 py-3 text-center w-44">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="hover:bg-zinc-50 border-b border-zinc-200 last:border-none">
                        <td class="px-5 py-4 text-sm text-center text-zinc-600">
                            {{ $category->ID_KATEGORI }}
                        </td>
                        <td class="px-5 py-4 text-sm font-semibold text-zinc-900">
                            {{ $category->NAMA_KATEGORI }}
                        </td>
                        <td class="px-5 py-4 text-sm text-center space-x-4">
                            <a href="{{ route('admin.categories.edit', $category->ID_KATEGORI) }}" class="text-amber-600 hover:text-amber-900 font-semibold">Edit</a>
                            
                            <form action="{{ route('admin.categories.destroy', $category->ID_KATEGORI) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-5 py-8 text-center text-zinc-500 bg-white text-sm">
                            Belum ada data kategori.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection