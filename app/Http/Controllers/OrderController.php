<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Digunakan jika menggunakan Query Builder untuk MS SQL

class OrderController extends Controller
{
    // 1. Menampilkan Halaman Daftar Pesanan
    public function index(Request $request)
    {
        // Contoh mengambil data dari tabel PESANAN (sesuai migrasi SQL Anda)
        // Anda bisa menambahkan fitur pencarian/search di sini
        $orders = DB::table('PESANAN')->get(); 

        return view('orders.index', compact('orders'));
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