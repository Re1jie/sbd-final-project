@extends('layouts.app')

@section('content')
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <p class="text-sm font-medium text-zinc-500">Produk</p>
            <p class="mt-3 text-3xl font-bold text-zinc-950">0</p>
            <p class="mt-2 text-sm text-zinc-500">Placeholder data produk.</p>
        </div>
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <p class="text-sm font-medium text-zinc-500">Kategori</p>
            <p class="mt-3 text-3xl font-bold text-zinc-950">0</p>
            <p class="mt-2 text-sm text-zinc-500">Placeholder kategori barang.</p>
        </div>
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <p class="text-sm font-medium text-zinc-500">Pelanggan</p>
            <p class="mt-3 text-3xl font-bold text-zinc-950">0</p>
            <p class="mt-2 text-sm text-zinc-500">Placeholder akun pelanggan.</p>
        </div>
        <div class="rounded-lg border border-zinc-200 bg-white p-5">
            <p class="text-sm font-medium text-zinc-500">Pesanan</p>
            <p class="mt-3 text-3xl font-bold text-zinc-950">0</p>
            <p class="mt-2 text-sm text-zinc-500">Placeholder transaksi masuk.</p>
        </div>
    </section>

    <section class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="rounded-lg border border-zinc-200 bg-white lg:col-span-2">
            <div class="border-b border-zinc-200 px-5 py-4">
                <h3 class="text-base font-semibold text-zinc-950">Daftar Pesanan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 text-sm">
                    <thead class="bg-zinc-50 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                        <tr>
                            <th class="px-5 py-3">Kode</th>
                            <th class="px-5 py-3">Pelanggan</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white">
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-zinc-500">
                                Belum ada data pesanan.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white">
            <div class="border-b border-zinc-200 px-5 py-4">
                <h3 class="text-base font-semibold text-zinc-950">Form Cepat</h3>
            </div>
            <form class="space-y-4 p-5">
                <div>
                    <label for="nama_produk" class="block text-sm font-medium text-zinc-700">Nama Produk</label>
                    <input id="nama_produk" type="text" class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="Contoh: Kemeja Linen">
                </div>
                <div>
                    <label for="kategori" class="block text-sm font-medium text-zinc-700">Kategori</label>
                    <select id="kategori" class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                        <option>Pilih kategori</option>
                    </select>
                </div>
                <div>
                    <label for="harga" class="block text-sm font-medium text-zinc-700">Harga</label>
                    <input id="harga" type="text" class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="Rp 0">
                </div>
                <button type="button" class="w-full rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                    Simpan Placeholder
                </button>
            </form>
        </div>
    </section>
@endsection
