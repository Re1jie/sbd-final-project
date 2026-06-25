@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-6xl py-6">
    
    {{-- KOTAK 1: FILTER TANGGAL (Minimalis) --}}
    <div class="mx-auto max-w-6xl mb-8 overflow-hidden rounded-2xl border border-slate-200/60 bg-white shadow-sm">
        <div class="bg-slate-800 px-4 py-2.5 flex items-center gap-2.5">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-500 text-white">
                <i class="fa-solid fa-file-invoice text-sm"></i>
            </div>
            <h3 class="text-sm font-bold text-white tracking-tight">Laporan Transaksi</h3>
        </div>

        <div class="px-4 py-4">
            <form action="{{ route('admin.reports.index') }}" method="GET">
                <div class="flex flex-col sm:flex-row items-end gap-3">
                    <div class="w-full sm:flex-1">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" id="startDate" value="{{ $start_date ?? '' }}" required 
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-semibold text-slate-900 transition-all focus:border-emerald-500 focus:bg-white focus:outline-none">
                    </div>
                    <div class="w-full sm:flex-1">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="endDate" value="{{ $end_date ?? '' }}" required 
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-semibold text-slate-900 transition-all focus:border-emerald-500 focus:bg-white focus:outline-none">
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" name="action" value="filter" 
                            class="flex-1 sm:flex-none inline-flex justify-center items-center gap-1.5 rounded-lg bg-slate-800 px-4 py-2 text-sm font-bold text-white hover:bg-slate-700 transition-all active:scale-95">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            <span>Tampilkan</span>
                        </button>
                        <button type="submit" name="action" value="download" 
                            class="flex-1 sm:flex-none inline-flex justify-center items-center gap-1.5 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-500 transition-all active:scale-95">
                            <i class="fa-solid fa-download text-xs"></i>
                            <span>PDF</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- KOTAK 2: HASIL TABEL --}}
    @if(isset($transactions))
        <div class="mb-4">
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Hasil Penelusuran</h2>
            <p class="text-sm font-medium text-slate-500">Periode: <span class="font-bold text-emerald-700">{{ \Carbon\Carbon::parse($start_date)->format('d M Y') }}</span> s/d <span class="font-bold text-emerald-700">{{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}</span></p>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm mb-10">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-[11px] font-extrabold uppercase tracking-wider text-slate-500">ID Pesanan</th>
                            <th class="px-6 py-4 text-left text-[11px] font-extrabold uppercase tracking-wider text-slate-500">Tanggal</th>
                            <th class="px-6 py-4 text-left text-[11px] font-extrabold uppercase tracking-wider text-slate-500">Pelanggan</th>
                            <th class="px-6 py-4 text-left text-[11px] font-extrabold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-4 text-right text-[11px] font-extrabold uppercase tracking-wider text-slate-500">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @php $totalPendapatan = 0; @endphp
                        @forelse($transactions as $trx)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-bold text-slate-900">#{{ $trx->ID_PESANAN }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ \Carbon\Carbon::parse($trx->TANGGAL_PESANAN)->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-slate-700">{{ $trx->NAMA }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold
                                        {{ $trx->NAMA_STATUS == 'Selesai' ? 'bg-emerald-100 text-emerald-800' : 
                                          ($trx->NAMA_STATUS == 'Dibatalkan' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                        {{ $trx->NAMA_STATUS }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-extrabold text-emerald-600">
                                    Rp {{ number_format($trx->TOTAL_HARGA, 0, ',', '.') }}
                                </td>
                            </tr>
                            @php 
                                if($trx->NAMA_STATUS !== 'Dibatalkan') {
                                    $totalPendapatan += $trx->TOTAL_HARGA; 
                                }
                            @endphp
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm font-medium text-slate-500">
                                    Tidak ada data transaksi yang ditemukan pada rentang tanggal tersebut.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-slate-50">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right text-sm font-extrabold text-slate-700 uppercase tracking-wider">Total Pendapatan (Diluar Batal) :</td>
                            <td class="px-6 py-4 text-right text-lg font-black text-emerald-700">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif

</div>

{{-- Script: Validasi tanggal agar end_date tidak bisa mundur dari start_date --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');

        // Ketika start_date berubah, set min untuk end_date
        startDate.addEventListener('change', function () {
            endDate.min = this.value;
            // Jika end_date saat ini lebih kecil dari start_date, reset end_date
            if (endDate.value && endDate.value < this.value) {
                endDate.value = this.value;
            }
        });

        // Ketika end_date berubah, set max untuk start_date
        endDate.addEventListener('change', function () {
            startDate.max = this.value;
            // Jika start_date saat ini lebih besar dari end_date, reset start_date
            if (startDate.value && startDate.value > this.value) {
                startDate.value = this.value;
            }
        });

        // Inisialisasi constraint jika sudah ada nilai dari server
        if (startDate.value) {
            endDate.min = startDate.value;
        }
        if (endDate.value) {
            startDate.max = endDate.value;
        }
    });
</script>
@endsection