@extends('layouts.app')

@section('content')
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-lg border border-zinc-200 bg-slate-900 p-5">
            <p class="text-sm font-medium text-white">Produk</p>
            <p class="mt-3 text-3xl font-bold text-white">{{ $totalProducts }}</p>
            <p class="mt-2 text-sm text-white">Total data produk aktif.</p>
        </div>
        <div class="rounded-lg border border-zinc-200 bg-slate-900 p-5">
            <p class="text-sm font-medium text-white">Kategori</p>
            <p class="mt-3 text-3xl font-bold text-white">{{ $totalCategories }}</p>
            <p class="mt-2 text-sm text-white">Jumlah kategori barang.</p>
        </div>
        <div class="rounded-lg border border-zinc-200 bg-slate-900 p-5">
            <p class="text-sm font-medium text-white">Pelanggan</p>
            <p class="mt-3 text-3xl font-bold text-white">{{ $totalCustomers }}</p>
            <p class="mt-2 text-sm text-white">Jumlah akun pelanggan terdaftar.</p>
        </div>
        <div class="rounded-lg border border-zinc-200 bg-slate-900 p-5">
            <p class="text-sm font-medium text-white">Pesanan</p>
            <p class="mt-3 text-3xl font-bold text-white">{{ $totalOrders }}</p>
            <p class="mt-2 text-sm text-white">Total keseluruhan transaksi masuk.</p>
        </div>
    </section>

    <section class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="rounded-lg border border-zinc-200 bg-white lg:col-span-2">
            <div class="border-b border-zinc-200 px-5 py-4">
                <h3 class="text-base font-semibold text-zinc-950">Daftar Pesanan Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 text-sm">
                    <thead class="bg-zinc-50 text-left text-xs font-semibold uppercase tracking-wider text-zinc-500">
                        <tr>
                            <th class="px-5 py-3">Kode Pesanan</th>
                            <th class="px-5 py-3">Pelanggan</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="px-5 py-4 font-medium text-zinc-950">#{{ $order->ID_PESANAN }}</td>
                                <td class="px-5 py-4 text-zinc-600">{{ $order->EMAIL }}</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                        {{ $order->ID_STATUS == 4 ? 'bg-green-100 text-green-800' : ($order->ID_STATUS == 5 ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $order->NAMA_STATUS ?? 'Tidak Diketahui' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-zinc-950 font-semibold">Rp {{ number_format($order->TOTAL_HARGA, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-zinc-500">
                                    Belum ada data pesanan saat ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white">
            <div class="border-b border-zinc-200 px-5 py-4">
                <h3 class="text-base font-semibold text-zinc-950">Form Cepat Tambah Produk</h3>
            </div>
            <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-4 p-5">
                @csrf
                <div>
                    <label for="KODE_PRODUK" class="block text-sm font-medium text-zinc-700">Kode Produk</label>
                    <input id="KODE_PRODUK" name="KODE_PRODUK" type="number" required class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="Contoh: 10023">
                </div>
                <div>
                    <label for="NAMA_PRODUK" class="block text-sm font-medium text-zinc-700">Nama Produk</label>
                    <input id="NAMA_PRODUK" name="NAMA_PRODUK" type="text" required class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="Contoh: Kemeja Linen">
                </div>
                <div>
                    <label for="ID_KATEGORI" class="block text-sm font-medium text-zinc-700">Kategori</label>
                    <select id="ID_KATEGORI" name="ID_KATEGORI" required class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                        <option value="">Pilih kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->ID_KATEGORI }}">{{ $category->NAMA_KATEGORI }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="HARGA" class="block text-sm font-medium text-zinc-700">Harga</label>
                        <input id="HARGA" name="HARGA" type="number" min="0" required class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="0">
                    </div>
                    <div>
                        <label for="STOK" class="block text-sm font-medium text-zinc-700">Stok</label>
                        <input id="STOK" name="STOK" type="number" min="0" required class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="0">
                    </div>
                </div>
                <button type="submit" class="w-full rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">
                    Simpan Produk
                </button>
            </form>
        </div>
    </section>
@endsection