@extends('layouts.app', ['pageTitle' => 'Daftar Pesanan'])

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="rounded-lg bg-white p-5 shadow-sm border border-zinc-200">
            <p class="text-sm font-medium text-zinc-500">Total Pesanan</p>
            <p class="mt-2 text-3xl font-bold text-zinc-950">{{ number_format($totalOrders, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-lg bg-white p-5 shadow-sm border border-zinc-200">
            <p class="text-sm font-medium text-zinc-500">Menunggu Proses</p>
            <p class="mt-2 text-3xl font-bold text-amber-600">{{ number_format($pendingOrders, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-lg bg-white p-5 shadow-sm border border-zinc-200">
            <p class="text-sm font-medium text-zinc-500">Total Pendapatan</p>
            <p class="mt-2 text-3xl font-bold text-emerald-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm">
        <div class="px-4 py-5 sm:px-6 border-b border-zinc-200 flex items-center justify-between">
            <h3 class="text-base font-semibold leading-6 text-zinc-950">Semua Transaksi</h3>
            <form action="{{ route('admin.orders.index') }}" method="GET">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari ID Pesanan / Email..." class="rounded-md border border-zinc-300 px-3 py-1.5 text-sm focus:border-emerald-500 focus:outline-none">
            </form>
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
                    @forelse($orders as $order)
                        @php
                            $statusName = $order->NAMA_STATUS ?? 'Status Tidak Diketahui';
                            $statusClass = match (strtolower($statusName)) {
                                'menunggu pembayaran' => 'bg-amber-50 text-amber-800 border-amber-200',
                                'diproses' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'dikirim' => 'bg-sky-50 text-sky-700 border-sky-200',
                                'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'dibatalkan' => 'bg-red-50 text-red-700 border-red-200',
                                default => 'bg-zinc-50 text-zinc-700 border-zinc-200',
                            };
                            $paymentClass = $order->STATUS_PEMBAYARAN
                                ? 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                : 'bg-amber-50 text-amber-800 border-amber-200';
                        @endphp
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 font-semibold text-zinc-950">#{{ $order->ID_PESANAN }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $order->EMAIL }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                {{ $order->TANGGAL_PESANAN ? \Carbon\Carbon::parse($order->TANGGAL_PESANAN)->translatedFormat('d F Y') : '-' }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 font-medium">Rp {{ number_format($order->TOTAL_HARGA ?? 0, 0, ',', '.') }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium border {{ $paymentClass }}">
                                    {{ $order->STATUS_PEMBAYARAN ? 'Dibayar' : 'Belum Dibayar' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium border {{ $statusClass }}">{{ $statusName }}</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order->ID_PESANAN) }}" class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-xs font-semibold text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 hover:bg-zinc-50">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-zinc-500">Belum ada pesanan yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
