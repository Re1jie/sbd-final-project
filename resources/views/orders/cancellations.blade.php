@extends('layouts.app', ['pageTitle' => 'Kelola Pembatalan Pesanan'])

@section('content')
<div class="space-y-6">
    @if(Auth::check() && Auth::user()->isAdmin())
    <div class="flex items-center gap-4 border-b border-zinc-200 pb-2">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 text-sm font-semibold text-zinc-500 hover:text-zinc-700 hover:border-zinc-300 border-b-2 border-transparent">Semua Transaksi</a>
        <a href="{{ route('admin.orders.cancellations') }}" class="px-4 py-2 text-sm font-semibold border-b-2 border-emerald-600 text-emerald-600">Kelola Pembatalan</a>
    </div>
    @endif

    <div class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm">
        <div class="px-4 py-5 sm:px-6 border-b border-zinc-200 flex items-center justify-between bg-red-50/30">
            <div>
                <h3 class="text-base font-semibold leading-6 text-zinc-950">Pesanan Kedaluwarsa (> 24 Jam)</h3>
                <p class="text-xs text-zinc-500 mt-1">Daftar pesanan yang belum dibayar selama lebih dari 24 jam dan siap dibatalkan.</p>
            </div>
            <form action="{{ route('admin.orders.cancellations') }}" method="GET">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari ID Pesanan / Email..." class="rounded-md border border-zinc-300 px-3 py-1.5 text-sm focus:border-emerald-500 focus:outline-none">
            </form>
        </div>

        <form action="{{ route('admin.orders.bulkCancel') }}" method="POST" id="bulkCancelForm">
            @csrf
            
            @if(count($orders) > 0)
            <div class="px-4 py-3 bg-zinc-50 border-b border-zinc-200 flex justify-start">
                <button type="button" onclick="confirmBulkCancel()" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-red-500 transition-all focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fa-solid fa-ban"></i> Batalkan Terpilih (<span id="selectedCount">0</span>)
                </button>
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 text-left text-sm">
                    <thead class="bg-zinc-50 text-xs font-semibold uppercase tracking-wider text-zinc-600">
                        <tr>
                            <th class="px-6 py-3 w-10 text-center">
                                <input type="checkbox" id="selectAllCheckbox" class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-600 cursor-pointer">
                            </th>
                            <th class="px-6 py-3">ID Pesanan</th>
                            <th class="px-6 py-3">Pelanggan (Email)</th>
                            <th class="px-6 py-3">Waktu Pemesanan</th>
                            <th class="px-6 py-3 text-center">Aksi Satuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 bg-white text-zinc-700">
                        @forelse($orders as $order)
                        <tr class="hover:bg-zinc-50 transition">
                            <td class="px-6 py-4 text-center">
                                <input type="checkbox" name="order_ids[]" value="{{ $order->ID_PESANAN }}" class="order-checkbox h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-600 cursor-pointer">
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 font-semibold">
                                <a href="{{ route('admin.orders.show', $order->ID_PESANAN) }}" class="text-emerald-600 hover:text-emerald-700 hover:underline">
                                    #{{ $order->ID_PESANAN }}
                                </a>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $order->EMAIL }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                {{ date('d M Y, H:i', strtotime($order->TANGGAL_PESANAN)) }}
                                <br>
                                <span class="text-xs text-red-500 font-medium">
                                    @php
                                        $diff = \Carbon\Carbon::parse($order->TANGGAL_PESANAN)->diffInHours(\Carbon\Carbon::now());
                                    @endphp
                                    Telat {{ round($diff) }} jam
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <button type="button" onclick="cancelSingleOrder('{{ $order->ID_PESANAN }}')" class="inline-flex items-center gap-1.5 rounded-lg bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700 shadow-sm hover:bg-red-200 transition-all">
                                    <i class="fa-solid fa-ban"></i> Batal
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-zinc-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-check-circle text-4xl text-emerald-400 mb-2"></i>
                                    <p class="font-medium text-zinc-600">Tidak ada pesanan yang perlu dibatalkan.</p>
                                    <p class="text-xs">Semua pesanan masih dalam batas waktu pembayaran 24 jam.</p>
                                </div>
                            </td>
                        </tr>
                        @endempty
                    </tbody>
                </table>
            </div>
        </form>

        <form id="singleCancelForm" method="POST" class="hidden">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="5">
        </form>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const orderCheckboxes = document.querySelectorAll('.order-checkbox');
        const selectedCountSpan = document.getElementById('selectedCount');

        // Fungsi Update Counter
        function updateCounter() {
            if(selectedCountSpan) {
                const checkedCount = document.querySelectorAll('.order-checkbox:checked').length;
                selectedCountSpan.textContent = checkedCount;
            }
        }

        // Logic Select All
        if(selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                orderCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateCounter();
            });
        }

        // Logic individual checkbox (kalau semua dicentang manual, select all ikut nyala)
        orderCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = document.querySelectorAll('.order-checkbox:checked').length === orderCheckboxes.length;
                selectAllCheckbox.checked = allChecked;
                updateCounter();
            });
        });
    });

    // Fungsi konfirmasi untuk Bulk Cancel
    function confirmBulkCancel() {
        const checkedCount = document.querySelectorAll('.order-checkbox:checked').length;
        
        if(checkedCount === 0) {
            alert('Silakan pilih minimal satu pesanan yang ingin dibatalkan.');
            return;
        }

        if(confirm(`Apakah Anda yakin ingin membatalkan ${checkedCount} pesanan yang dipilih?`)) {
            document.getElementById('bulkCancelForm').submit();
        }
    }

    // Fungsi konfirmasi untuk Cancel Satuan (agar tidak bentrok dengan tag <form> yang membungkus table)
    function cancelSingleOrder(idPesanan) {
        if(confirm('Batalkan pesanan ini karena melewati batas waktu pembayaran 24 jam?')) {
            const form = document.getElementById('singleCancelForm');
            // Ganti URL action form dengan route pembatalan satuan yang ada di web.php
            // Karena route JS tidak bisa baca fungsi route() laravel secara dinamis, kita bentuk URL-nya secara manual atau bisa disesuaikan:
            form.action = `/admin/orders/${idPesanan}/update-status`; 
            form.submit();
        }
    }
</script>
@endsection