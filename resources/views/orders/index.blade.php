@extends('layouts.app', ['pageTitle' => 'Daftar Pesanan'])

@section('content')
<div class="space-y-6">
    @if(Auth::check() && Auth::user()->isAdmin())
    <div class="flex items-center gap-4 border-b border-zinc-200 pb-2">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 text-sm font-semibold border-b-2 border-emerald-600 text-emerald-600">Semua Transaksi</a>
        <a href="{{ route('admin.orders.cancellations') }}" class="px-4 py-2 text-sm font-semibold text-zinc-500 hover:text-zinc-700 hover:border-zinc-300 border-b-2 border-transparent">Kelola Pembatalan</a>
    </div>
    @endif

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
                        <th class="px-6 py-3">Tanggal dan Waktu</th>
                        <th class="px-6 py-3">Total Harga</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white text-zinc-700">
                    @foreach($orders as $order)
                    <tr class="hover:bg-zinc-50 transition">
                        <td class="whitespace-nowrap px-6 py-4 font-semibold">
                            @if(isset($isClient) && $isClient)
                                @if($order->ID_STATUS == 1)
                                    <a href="{{ route('payment.show', $order->ID_PESANAN) }}" class="text-amber-600 hover:text-amber-700 hover:underline" title="Lanjut Pembayaran">
                                        #{{ $order->ID_PESANAN }}
                                    </a>
                                @else
                                    <a href="{{ route('orders.show', $order->ID_PESANAN) }}" class="text-emerald-600 hover:text-emerald-700 hover:underline">
                                        #{{ $order->ID_PESANAN }}
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('admin.orders.show', $order->ID_PESANAN) }}" class="text-emerald-600 hover:text-emerald-700 hover:underline">
                                    #{{ $order->ID_PESANAN }}
                                </a>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $order->EMAIL }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ date('d M Y, H:i', strtotime($order->TANGGAL_PESANAN)) }}</td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium">Rp {{ number_format($order->TOTAL_HARGA, 0, ',', '.') }}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-800 border border-amber-200">
                                {{ ucfirst($order->NAMA_STATUS ?? 'Diproses') }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-center">
                            @if(isset($isClient) && $isClient)
                                @if($order->ID_STATUS == 1)
                                    <a href="{{ route('payment.show', $order->ID_PESANAN) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-amber-500 px-3 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-amber-600 transition-all">
                                        <i class="fa-solid fa-credit-card"></i> Bayar
                                    </a>
                                @elseif($order->ID_STATUS == 3)
                                    <form action="{{ route('orders.complete', $order->ID_PESANAN) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin pesanan telah diterima dengan baik dan ingin menyelesaikannya?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-500 transition-all">
                                            <i class="fa-solid fa-check-double"></i> Selesai
                                        </button>
                                    </form>
                                @else
                                    <span class="text-zinc-400 text-xs">-</span>
                                @endif
                            @else
                                {{-- Sisi Admin --}}
                                @if($order->ID_STATUS == 2)
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.orders.updateStatus', $order->ID_PESANAN) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="3">
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-blue-500 transition-all" title="Ubah status ke Dikirim">
                                                <i class="fa-solid fa-truck-fast"></i> Dikirim
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.orders.updateStatus', $order->ID_PESANAN) }}" method="POST" class="inline" onsubmit="return confirm('Selesaikan pesanan ini langsung?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="4">
                                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-500 transition-all" title="Ubah status ke Selesai">
                                                <i class="fa-solid fa-check-double"></i> Selesai
                                            </button>
                                        </form>
                                    </div>
                                @elseif($order->ID_STATUS == 3)
                                    <form action="{{ route('admin.orders.updateStatus', $order->ID_PESANAN) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="4">
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-emerald-500 transition-all">
                                            <i class="fa-solid fa-check-double"></i> Selesai
                                        </button>
                                    </form>
                                @else
                                    <span class="text-zinc-400 text-xs">-</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection