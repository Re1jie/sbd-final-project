<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Digunakan jika menggunakan Query Builder untuk MS SQL

class OrderController extends Controller
{
    // 1. Menampilkan Halaman Daftar Pesanan
    public function index(Request $request)
    {
        $search = $request->input('search');

        $orders = DB::table('PESANAN')
            ->leftJoin('STATUS_PESANAN', 'PESANAN.ID_STATUS', '=', 'STATUS_PESANAN.ID_STATUS')
            ->select('PESANAN.*', 'STATUS_PESANAN.NAMA_STATUS')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereRaw('CAST(PESANAN.ID_PESANAN AS VARCHAR(20)) LIKE ?', ["%{$search}%"])
                        ->orWhere('PESANAN.EMAIL', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('PESANAN.TANGGAL_PESANAN')
            ->get();

        $totalOrders = DB::table('PESANAN')->count();
        $pendingOrders = DB::table('PESANAN')
            ->whereIn('ID_STATUS', [1, 2])
            ->count();
        $totalRevenue = DB::table('PESANAN')
            ->where('STATUS_PEMBAYARAN', 1)
            ->sum('TOTAL_HARGA');

        return view('orders.index', compact(
            'orders',
            'search',
            'totalOrders',
            'pendingOrders',
            'totalRevenue'
        ));
    }

    // 2. Menampilkan Halaman Detail Pesanan
    public function show($id)
    {
        // Mengambil detail satu pesanan berdasarkan ID_PESANAN
        $order = DB::table('PESANAN')->where('ID_PESANAN', $id)->first();

        // Mengambil produk-produk yang ada di dalam pesanan tersebut (tabel relasi/pivot jika ada)
        $orderItems = DB::table('DETAIL_PESANAN')
            ->join('PRODUK', 'DETAIL_PESANAN.ID_PRODUK', '=', 'PRODUK.ID_PRODUK')
            ->where('DETAIL_PESANAN.ID_PESANAN', $id)
            ->get();

        return view('orders.show', compact('order', 'orderItems'));
    }

    // 3. Fitur Update Status Pesanan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,dikirim,selesai,dibatalkan'
        ]);

        // Update STATUS_PESANAN di database
        DB::table('PESANAN')
            ->where('ID_PESANAN', $id)
            ->update(['STATUS_PESANAN' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
