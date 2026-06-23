<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pageTitle = 'Dashboard Toko Online';

        // Mengambil jumlah total data dari masing-masing tabel
        $totalProducts = DB::table('PRODUK')->count();
        $totalCategories = DB::table('KATEGORI')->count();
        $totalCustomers = DB::table('PELANGGAN')->count();
        $totalOrders = DB::table('PESANAN')->count();

        // Mengambil 5 pesanan terbaru beserta nama statusnya
        $recentOrders = DB::table('PESANAN')
            ->leftJoin('STATUS_PESANAN', 'PESANAN.ID_STATUS', '=', 'STATUS_PESANAN.ID_STATUS')
            ->select('PESANAN.*', 'STATUS_PESANAN.NAMA_STATUS')
            ->orderByDesc('PESANAN.TANGGAL_PESANAN')
            ->limit(5)
            ->get();

        // Mengambil semua kategori untuk opsi di form cepat
        $categories = DB::table('KATEGORI')->get();

        return view('dashboard.index', compact(
            'pageTitle', 
            'totalProducts', 
            'totalCategories', 
            'totalCustomers', 
            'totalOrders',
            'recentOrders',
            'categories'
        ));
    }
}