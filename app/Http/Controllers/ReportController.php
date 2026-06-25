<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $transactions = null;
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $action = $request->input('action'); // Mendeteksi tombol mana yang diklik

        // Validasi server-side: end_date tidak boleh mundur dari start_date
        if ($start_date && $end_date) {
            $request->validate([
                'start_date' => 'required|date',
                'end_date'   => 'required|date|after_or_equal:start_date',
            ]);
        }

        // Jika ada input tanggal, sistem akan memproses kueri
        if ($start_date && $end_date) {
            $start = $start_date . ' 00:00:00';
            $end   = $end_date . ' 23:59:59';

            $transactions = DB::table('PESANAN')
                ->join('PELANGGAN', 'PESANAN.EMAIL', '=', 'PELANGGAN.EMAIL')
                ->join('STATUS_PESANAN', 'PESANAN.ID_STATUS', '=', 'STATUS_PESANAN.ID_STATUS')
                ->whereBetween('PESANAN.TANGGAL_PESANAN', [$start, $end])
                ->orderBy('PESANAN.TANGGAL_PESANAN', 'ASC')
                ->get();

            // Jika tombol 'Download PDF' yang diklik, langsung cetak
            if ($action === 'download') {
                $data = [
                    'title'        => 'Laporan Transaksi KOPDESShop',
                    'start_date'   => $start_date,
                    'end_date'     => $end_date,
                    'transactions' => $transactions,
                ];

                $pdf = Pdf::loadView('admin.reports.pdf', $data);
                $pdf->setPaper('A4', 'landscape');
                
                return $pdf->download('Laporan_Transaksi_' . $start_date . '_sd_' . $end_date . '.pdf');
            }
        }

        // Jika buka halaman pertama kali / klik tombol 'Tampilkan Data'
        return view('admin.reports.index', compact('transactions', 'start_date', 'end_date'));
    }
}