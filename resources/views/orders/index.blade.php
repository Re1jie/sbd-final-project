@extends('layouts.app', ['pageTitle' => 'Daftar Pesanan'])

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="rounded-lg bg-white p-5 shadow-sm border border-zinc-200">
            <p class="text-sm font-medium text-zinc-500">Total Pesanan</p>
            <p class="mt-2 text-3xl font-bold text-zinc-950">1,240</p>
        </div>
        <div class="rounded-lg bg-white p-5 shadow-sm border border-zinc-200">
            <p class="text-sm font-medium text-zinc-500">Menunggu Proses</p>
            <p class="mt-2 text-3xl font-bold text-amber-600">45</p>
        </div>
        <div class="rounded-lg bg-white p-5 shadow-sm border border-zinc-200">
            <p class="text-sm font-medium text-zinc-500">Total Pendapatan</p>
            <p class="mt-2 text-3xl font-bold text-emerald-600">Rp 142.500.000</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm">
        <div class="px-4 py-5 sm:px-6 border-b border-zinc-200 flex items-center justify-between">
            <h3 class="text-base font-semibold leading-6 text-zinc-950">Semua Transaksi</h3>
            <input type="text" placeholder="Cari ID Pesanan / Email..." class="rounded-md border border-zinc-300 px-3 py-1.5 text-sm focus:border-emerald-500 focus:outline-none">
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 text-left text-sm">
                <thead class="bg-zinc-50 text-xs font-semibold uppercase tracking-wider text-zinc-600">
                    <tr>
                        <th class="px-6 py-3">ID Pesanan</th>
                        <th class="px-6 py-3">Pelanggan (Email)</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Total Harga</th>
                        <th class="px-6 py-3">Pembayaran</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white text-zinc-700">
                    {{-- @foreach($pesanans as $pesanan) --}}
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 font-semibold text-zinc-950">#100234</td>
                        <td class="whitespace-nowrap px-6 py-4">budi@email.com</td>
                        <td class="whitespace-nowrap px-6 py-4">19 Juni 2026</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Rp 450.000</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 border border-emerald-200">Dibayar</span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-800 border border-amber-200">Diproses</span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <a href="#" class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-xs font-semibold text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 hover:bg-zinc-50">Detail</a>
                        </td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection