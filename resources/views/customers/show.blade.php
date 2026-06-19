@extends('layouts.app', ['pageTitle' => 'Profil Pelanggan'])

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('admin.customers.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">&larr; Kembali ke Daftar Pelanggan</a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm space-y-4 h-fit">
            <div class="flex items-center gap-3 border-b border-zinc-100 pb-3">
                <div class="h-10 w-10 rounded-full bg-zinc-200 flex items-center justify-center font-bold text-zinc-700 uppercase">BS</div>
                <div>
                    <h3 class="text-base font-semibold text-zinc-950">Budi Santoso</h3>
                    <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-0.5 text-xs font-medium text-purple-700 border border-purple-200">Tier: Gold</span>
                </div>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Email Utama</p>
                <p class="text-sm font-medium text-zinc-950 mt-0.5">budi@email.com</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Alamat Utama</p>
                <p class="text-sm text-zinc-600 mt-0.5 leading-relaxed">Jl. Kenangan No. 12, Kota Surabaya, Jawa Timur</p>
            </div>
        </div>

        <div class="lg:col-span-2 rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
            <div class="px-4 py-4 sm:px-6 border-b border-zinc-200">
                <h3 class="text-base font-semibold text-zinc-950">Riwayat Pembelian</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 text-left text-sm">
                    <thead class="bg-zinc-50 text-xs font-semibold uppercase text-zinc-600">
                        <tr>
                            <th class="px-6 py-3">ID Pesanan</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Total Belanja</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 bg-white text-zinc-700">
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 font-semibold text-zinc-950">#100234</td>
                            <td class="whitespace-nowrap px-6 py-4">19 Juni 2026</td>
                            <td class="whitespace-nowrap px-6 py-4">Rp 450.000</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-800 border border-emerald-200">Selesai</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $history->ID_PESANAN) }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700"> Lihat Nota
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection