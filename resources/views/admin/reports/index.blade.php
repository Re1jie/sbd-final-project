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

    {{-- KOTAK 2: INFOGRAFIS --}}
    @if(isset($transactions))
        <div class="mb-4">
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Hasil Penelusuran</h2>
            <p class="text-sm font-medium text-slate-500">Periode: <span class="font-bold text-emerald-700">{{ \Carbon\Carbon::parse($start_date)->format('d M Y') }}</span> s/d <span class="font-bold text-emerald-700">{{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}</span></p>
        </div>

        {{-- Infografis Charts --}}
        @if(($categoryStats && count($categoryStats) > 0) || ($monthlyRevenue && count($monthlyRevenue) > 0))
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            
            {{-- Chart 1: Kategori Paling Banyak Dibeli --}}
            @if($categoryStats && count($categoryStats) > 0)
            <div class="overflow-hidden rounded-2xl border border-slate-200/60 bg-white shadow-sm">
                <div class="bg-slate-800 px-4 py-2.5 flex items-center gap-2.5">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-violet-500 text-white">
                        <i class="fa-solid fa-chart-pie text-sm"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white tracking-tight">Kategori Terlaris</h3>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-center" style="height: 280px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                    <div class="mt-4 space-y-2">
                        @foreach($categoryStats as $index => $cat)
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <span class="inline-block h-3 w-3 rounded-full" id="catColor{{ $index }}"></span>
                                <span class="font-semibold text-slate-700">{{ $cat->NAMA_KATEGORI }}</span>
                            </div>
                            <span class="font-extrabold text-slate-900">{{ $cat->total_terjual }} item</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Chart 2: Penghasilan Per Bulan --}}
            @if($monthlyRevenue && count($monthlyRevenue) > 0)
            <div class="overflow-hidden rounded-2xl border border-slate-200/60 bg-white shadow-sm">
                <div class="bg-slate-800 px-4 py-2.5 flex items-center gap-2.5">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-amber-500 text-white">
                        <i class="fa-solid fa-chart-column text-sm"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white tracking-tight">Penghasilan Per Bulan</h3>
                </div>
                <div class="p-4">
                    <div style="height: 280px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                    <div class="mt-4 space-y-2">
                        @foreach($monthlyRevenue as $rev)
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-semibold text-slate-700">
                                {{ \Carbon\Carbon::parse($rev->bulan . '-01')->translatedFormat('F Y') }}
                            </span>
                            <span class="font-extrabold text-emerald-700">Rp {{ number_format($rev->total_pendapatan, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>
        @endif

        {{-- Tabel Transaksi --}}
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

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ======== Validasi Tanggal ========
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');

        startDate.addEventListener('change', function () {
            endDate.min = this.value;
            if (endDate.value && endDate.value < this.value) {
                endDate.value = this.value;
            }
        });

        endDate.addEventListener('change', function () {
            startDate.max = this.value;
            if (startDate.value && startDate.value > this.value) {
                startDate.value = this.value;
            }
        });

        if (startDate.value) {
            endDate.min = startDate.value;
        }
        if (endDate.value) {
            startDate.max = endDate.value;
        }

        // ======== Chart: Kategori Terlaris (Doughnut) ========
        const categoryCanvas = document.getElementById('categoryChart');
        if (categoryCanvas) {
            const categoryLabels = {!! isset($categoryStats) && $categoryStats ? json_encode($categoryStats->pluck('NAMA_KATEGORI')) : '[]' !!};
            const categoryData = {!! isset($categoryStats) && $categoryStats ? json_encode($categoryStats->pluck('total_terjual')) : '[]' !!};

            const chartColors = [
                '#6366f1', '#8b5cf6', '#a855f7', '#d946ef', '#ec4899',
                '#f43f5e', '#f97316', '#eab308', '#22c55e', '#14b8a6',
                '#06b6d4', '#3b82f6'
            ];

            // Set warna legend dots
            categoryLabels.forEach((_, i) => {
                const dot = document.getElementById('catColor' + i);
                if (dot) dot.style.backgroundColor = chartColors[i % chartColors.length];
            });

            new Chart(categoryCanvas, {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryData,
                        backgroundColor: chartColors.slice(0, categoryLabels.length),
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { weight: 'bold', size: 13 },
                            bodyFont: { size: 12 },
                            cornerRadius: 8,
                            padding: 10,
                            callbacks: {
                                label: function(ctx) {
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = ((ctx.raw / total) * 100).toFixed(1);
                                    return ` ${ctx.raw} item (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // ======== Chart: Penghasilan Per Bulan (Bar) ========
        const revenueCanvas = document.getElementById('revenueChart');
        if (revenueCanvas) {
            const revenueLabels = {!! isset($monthlyRevenue) && $monthlyRevenue ? json_encode($monthlyRevenue->pluck('bulan')) : '[]' !!};
            const revenueData = {!! isset($monthlyRevenue) && $monthlyRevenue ? json_encode($monthlyRevenue->pluck('total_pendapatan')) : '[]' !!};

            // Format label bulan
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const formattedLabels = revenueLabels.map(label => {
                const [year, month] = label.split('-');
                return monthNames[parseInt(month) - 1] + ' ' + year;
            });

            new Chart(revenueCanvas, {
                type: 'bar',
                data: {
                    labels: formattedLabels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: revenueData,
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderColor: '#059669',
                        borderWidth: 1,
                        borderRadius: 8,
                        borderSkipped: false,
                        maxBarThickness: 48
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                font: { size: 11, weight: 'bold' },
                                color: '#64748b',
                                callback: function(value) {
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + ' jt';
                                    if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' rb';
                                    return 'Rp ' + value;
                                }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 11, weight: 'bold' },
                                color: '#64748b'
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { weight: 'bold', size: 13 },
                            bodyFont: { size: 12 },
                            cornerRadius: 8,
                            padding: 10,
                            callbacks: {
                                label: function(ctx) {
                                    return ' Rp ' + new Intl.NumberFormat('id-ID').format(ctx.raw);
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection