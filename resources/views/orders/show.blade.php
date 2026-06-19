@extends('layouts.app', ['pageTitle' => 'Detail Pesanan #100234'])

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="#" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">&larr; Kembali ke Daftar Pesanan</a>
        
        <form action="#" method="POST" class="flex items-center gap-2">
            @csrf
            @method('PUT')
            <label for="status" class="text-sm font-medium text-zinc-700">Status Pesanan:</label>
            <select id="status" name="status" class="rounded-md border border-zinc-300 px-3 py-1.5 text-sm focus:border-emerald-500 focus:outline-none bg-white">
                <option value="diproses" selected>Diproses</option>
                <option value="dikirim">Dikirim</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
            <button type="submit" class="rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500">Perbarui</button>
        </form>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-lg border border-zinc-200 bg-white shadow-sm">
                <div class="px-4 py-4 sm:px-6 border-b border-zinc-200">
                    <h3 class="text-base font-semibold text-zinc-950">Daftar Produk</h3>
                </div>
                <table class="min-w-full divide-y divide-zinc-200 text-sm">
                    <thead class="bg-zinc-50 font-medium text-zinc-600 text-left">
                        <tr>
                            <th class="px-6 py-3">Nama Produk</th>
                            <th class="px-6 py-3">Harga Satuan</th>
                            <th class="px-6 py-3 text-center">Jumlah</th>
                            <th class="px-6 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 text-zinc-700">
                        <tr>
                            <td class="px-6 py-4 font-medium text-zinc-950">Sepatu Running Aero</td>
                            <td class="px-6 py-4">Rp 200.000</td>
                            <td class="px-6 py-4 text-center">2</td>
                            <td class="px-6 py-4 text-right">Rp 400.000</td>
                        </tr>
                    </tbody>
                </table>
                <div class="border-t border-zinc-200 bg-zinc-50 px-6 py-4 space-y-2 text-sm text-zinc-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-medium text-zinc-950">Rp 400.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Ongkir (ONGKIR)</span>
                        <span class="font-medium text-zinc-950">Rp 50.000</span>
                    </div>
                    <div class="flex justify-between border-t border-zinc-200 pt-2 text-base font-bold text-zinc-950">
                        <span>Total Pesanan</span>
                        <span class="text-emerald-700">Rp 450.000</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm space-y-4">
                <h3 class="text-base font-semibold text-zinc-950 border-b border-zinc-100 pb-2">Informasi Pelanggan</h3>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Nama Pelanggan</p>
                    <p class="text-sm font-medium text-zinc-950 mt-0.5">Budi Santoso</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Email</p>
                    <p class="text-sm font-medium text-zinc-950 mt-0.5">budi@email.com</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Alamat Pengiriman</p>
                    <p class="text-sm text-zinc-600 mt-0.5 leading-relaxed">Jl. Kenangan No. 12, Kota Surabaya, Jawa Timur, 60123</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Tanggal Transaksi</p>
                    <p class="text-sm text-zinc-600 mt-0.5">19 Juni 2026 14:20</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection