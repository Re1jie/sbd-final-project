<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi KOPDESShop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            padding-bottom: 50px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #047857;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #047857;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            font-style: italic;
            color: #999;
            padding: 10px 0;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>KOPDESShop</h1>
        <p>Laporan Rekapitulasi Transaksi Pelanggan</p>
        <p>Periode: <strong>{{ \Carbon\Carbon::parse($start_date)->format('d F Y') }}</strong> s/d <strong>{{ \Carbon\Carbon::parse($end_date)->format('d F Y') }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="15%">ID Pesanan</th>
                <th width="20%">Tanggal Transaksi</th>
                <th width="25%">Nama Pelanggan</th>
                <th width="15%">Status</th>
                <th class="text-right" width="20%">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $totalPendapatan = 0; @endphp
            @forelse($transactions as $index => $trx)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>#{{ $trx->ID_PESANAN }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->TANGGAL_PESANAN)->format('d M Y, H:i') }}</td>
                    <td>{{ $trx->NAMA }}</td>
                    <td>{{ $trx->NAMA_STATUS }}</td>
                    <td class="text-right">Rp {{ number_format($trx->TOTAL_HARGA, 0, ',', '.') }}</td>
                </tr>
                @php 
                    // Jika butuh menghitung total omset (hanya pesanan selesai/diproses, disesuaikan)
                    if($trx->NAMA_STATUS !== 'Dibatalkan') {
                        $totalPendapatan += $trx->TOTAL_HARGA; 
                    }
                @endphp
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi pada rentang tanggal tersebut.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total Pendapatan (Diluar Batal) :</th>
                <th class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dokumen ini di-generate otomatis oleh Sistem Toko Online KOPDESShop pada {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d F Y H:i') }} WIB
    </div>

</body>
</html>