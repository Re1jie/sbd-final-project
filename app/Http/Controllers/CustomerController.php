<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // 1. Halaman Daftar Pelanggan & Pelanggan Loyal
    public function index(Request $request)
    {
        // Mengambil semua pelanggan KECUALI yang memiliki ROLE 'admin'
        $query = DB::table('PELANGGAN')
            ->leftJoin('LOYALITAS', 'PELANGGAN.ID_LOYALITAS', '=', 'LOYALITAS.ID_LOYALITAS')
            ->where('PELANGGAN.ROLE', '!=', 'admin');

        if ($request->has('filter_loyalitas') && $request->filter_loyalitas != '') {
            $query->where('LOYALITAS.JENIS_TINGKATAN', $request->filter_loyalitas);
        }

        $customers = $query->get();

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
            ->get(); 

        return view('customers.show', compact('customer', 'purchaseHistory'));
    }
}