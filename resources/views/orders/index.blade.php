@extends('layouts.app', ['pageTitle' => 'Daftar Pesanan'])

@section('content')
<div class="space-y-6">
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
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white text-zinc-700">
                    @foreach($orders as $order)
                    <tr class="hover:bg-zinc-50 transition">
                        {{-- ID Pesanan dijadikan link interaktif utama --}}
                        <td class="whitespace-nowrap px-6 py-4 font-semibold">
                            <a href="{{ route('admin.orders.show', $order->ID_PESANAN) }}" class="text-emerald-600 hover:text-emerald-700 hover:underline">
                                #{{ $order->ID_PESANAN }}
                            </a>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $order->EMAIL }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ date('d M Y', strtotime($order->TANGGAL_PESANAN)) }}</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Rp {{ number_format($order->TOTAL_HARGA, 0, ',', '.') }}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-800 border border-amber-200">
                                {{ ucfirst($order->NAMA_STATUS ?? 'Diproses') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection