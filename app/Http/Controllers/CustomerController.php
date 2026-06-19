<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // 1. Halaman Daftar Pelanggan & Pelanggan Loyal
    public function index()
    {
        // Mengambil semua pelanggan beserta informasi tingkat loyalitasnya
        $customers = DB::table('PELANGGAN')
            ->leftJoin('LOYALITAS', 'PELANGGAN.ID_LOYALITAS', '=', 'LOYALITAS.ID_LOYALITAS')
            ->get();

        return view('customers.index', compact('customers'));
    }

    // 2. Halaman Detail & Riwayat Pembelian Pelanggan
    public function show($email)
{
    //# Mengambil data profil pelanggan
    $customer = DB::table('PELANGGAN')
        ->leftJoin('LOYALITAS', 'PELANGGAN.ID_LOYALITAS', '=', 'LOYALITAS.ID_LOYALITAS')
        ->where('EMAIL', $email)
        ->first();

    //# Mengambil riwayat pesanan + JOIN ke STATUS_PESANAN berdasarkan ID_STATUS
    $purchaseHistory = DB::table('PESANAN')
        ->join('STATUS_PESANAN', 'PESANAN.ID_STATUS', '=', 'STATUS_PESANAN.ID_STATUS')
        ->where('PESANAN.EMAIL', $email)
        ->orderBy('PESANAN.TANGGAL_PESANAN')
        ->get(); // Ini akan membawa semua kolom dari kedua tabel, termasuk NAMA_STATUS

    return view('customers.show', compact('customer', 'purchaseHistory'));
}
}