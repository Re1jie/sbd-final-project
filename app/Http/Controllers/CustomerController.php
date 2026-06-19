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
        // Mengambil data profil pelanggan berdasarkan email (primary key)
        $customer = DB::table('PELANGGAN')
            ->leftJoin('LOYALITAS', 'PELANGGAN.ID_LOYALITAS', '=', 'LOYALITAS.ID_LOYALITAS')
            ->where('EMAIL', $email)
            ->first();

        // Mengambil semua riwayat transaksi/pesanan milik pelanggan tersebut
        $purchaseHistory = DB::table('PESANAN')
            ->where('EMAIL', $email)
            ->orderBy('TANGGAL_PESANAN', 'desc')
            ->get();

        return view('customers.show', compact('customer', 'purchaseHistory'));
    }
}