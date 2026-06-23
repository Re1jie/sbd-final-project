@extends('layouts.app', ['pageTitle' => 'Detail Pesanan #100234'])

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        @if(Auth::check() && Auth::user()->isClient())
            <a href="{{ route('orders.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">&larr; Kembali ke Pesanan Saya</a>
        @else
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">&larr; Kembali ke Daftar Pesanan</a>
        @endif
        @if(Auth::check() && !Auth::user()->isClient())
        <form action="{{ route('admin.orders.updateStatus', $order->ID_PESANAN) }}" method="POST" class="flex items-center gap-2">
            @csrf
            @method('PUT')
            <label for="status" class="text-sm font-medium text-zinc-700">Status Pesanan:</label>
            <select id="status" name="status" class="rounded-md border border-zinc-300 px-3 py-1.5 text-sm focus:border-emerald-500 focus:outline-none bg-white">
                <option value="1" {{ $order->ID_STATUS == 1 ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="2" {{ $order->ID_STATUS == 2 ? 'selected' : '' }}>Diproses</option>
                <option value="3" {{ $order->ID_STATUS == 3 ? 'selected' : '' }}>Dikirim</option>
                <option value="4" {{ $order->ID_STATUS == 4 ? 'selected' : '' }}>Selesai</option>
                <option value="5" {{ $order->ID_STATUS == 5 ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500">Perbarui</button>
        </form>
        @else
        <div class="flex items-center gap-2">
            <span class="text-sm font-medium text-zinc-700">Status Pesanan:</span>
            <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-800 border border-amber-200">
                {{ $order->NAMA_STATUS ?? 'Diproses' }}
            </span>
        </div>
        @endif
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
                        @php $calculatedSubtotal = 0; @endphp
                        @foreach($orderItems as $item)
                        @php 
                            // Hitung subtotal berdasarkan HARGA * JUMLAH atau HARGA_SATUAN * JUMLAH jika ada
                            // Berdasarkan ERD, ORDERED_PRODUCT hanya punya ID_PESANAN, KODE_PRODUK
                            // Namun jika harga saat itu tidak disimpan, kita ambil dari tabel PRODUK
                            $jumlah = $item->JUMLAH ?? 1; // Asumsi jumlah 1 jika tidak ada kolom JUMLAH
                            $harga = $item->HARGA ?? 0;
                            $sub = $jumlah * $harga;
                            $calculatedSubtotal += $sub;
                        @endphp
                        <tr>
                            <td class="px-6 py-4 font-medium text-zinc-950">{{ $item->NAMA_PRODUK }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">{{ $jumlah }}</td>
                            <td class="px-6 py-4 text-right">Rp {{ number_format($sub, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="border-t border-zinc-200 bg-zinc-50 px-6 py-4 space-y-2 text-sm text-zinc-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-medium text-zinc-950">Rp {{ number_format($calculatedSubtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Ongkir (ONGKIR)</span>
                        <span class="font-medium text-zinc-950">Rp {{ number_format($order->ONGKIR ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between border-t border-zinc-200 pt-2 text-base font-bold text-zinc-950">
                        <span>Total Pesanan</span>
                        <span class="text-emerald-700">Rp {{ number_format($order->TOTAL_HARGA + ($order->ONGKIR ?? 0), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm space-y-4">
                <h3 class="text-base font-semibold text-zinc-950 border-b border-zinc-100 pb-2">Informasi Pelanggan</h3>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Nama Pelanggan</p>
                    <p class="text-sm font-medium text-zinc-950 mt-0.5">{{ $order->NAMA_PELANGGAN ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Email</p>
                    <p class="text-sm font-medium text-zinc-950 mt-0.5">{{ $order->EMAIL }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Alamat Pengiriman</p>
                    <p class="text-sm text-zinc-600 mt-0.5 leading-relaxed">{{ $order->ALAMAT_PELANGGAN ?? 'Tidak ada alamat' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Tanggal Transaksi</p>
                    <p class="text-sm text-zinc-600 mt-0.5">{{ date('d F Y, H:i', strtotime($order->TANGGAL_PESANAN)) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection