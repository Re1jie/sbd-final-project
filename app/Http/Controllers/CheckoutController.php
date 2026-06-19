<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('catalog.index')->with('error', 'Keranjang Anda kosong!');
        }

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $ongkir = 15000; // Contoh Ongkir Flat statis sesuai permintaan modul
        $total = $subtotal + $ongkir;

        return view('checkout.index', compact('cart', 'subtotal', 'ongkir', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('catalog.index');

        // 1. Validasi Stok Final sebelum menulis ke database
        foreach ($cart as $item) {
            $dbProduct = DB::select("SELECT STOK FROM PRODUK WHERE KODE_PRODUK = ?", [$item['id']]);
            if (empty($dbProduct) || $dbProduct[0]->STOK < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', 'Maaf, stok ' . $item['name'] . ' mendadak tidak mencukupi. Silakan sesuaikan kembali.');
            }
        }

        // Ambil ID Pelanggan (misal default 1 jika login modul Anggota 3 belum terpasang penuh)
        $idPelanggan = auth()->id() ?? 1; 
        $ongkir = 15000;
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $total = $subtotal + $ongkir;

        // Ambil ID Order baru (Manual Increment/Check Max ID sesuai konvensi Non-ORM proyek Anda)
        $maxOrder = DB::select("SELECT MAX(ID_PESANAN) as max_id FROM PESANAN");
        $idPesananBaru = (!empty($maxOrder) && $maxOrder[0]->max_id !== null) ? ($maxOrder[0]->max_id + 1) : 1;

        // 2. Simpan ke tabel PESANAN (Master Order)
        DB::insert("
            INSERT INTO PESANAN (ID_PESANAN, ID_PELANGGAN, TANGGAL_PESANAN, TOTAL_HARGA, BIAYA_ONGKIR, STATUS_PESANAN) 
            VALUES (?, ?, GETDATE(), ?, ?, 'Belum Bayar')
        ", [$idPesananBaru, $idPelanggan, $total, $ongkir]);

        // 3. Simpan ke tabel ITEM_PESANAN & Potong Stok Produk langsung
        foreach ($cart as $item) {
            DB::insert("
                INSERT INTO ITEM_PESANAN (ID_PESANAN, KODE_PRODUK, JUMLAH, HARGA_SATUAN) 
                VALUES (?, ?, ?, ?)
            ", [$idPesananBaru, $item['id'], $item['quantity'], $item['price']]);

            // Potong stok produk di database
            DB::update("
                UPDATE PRODUK 
                SET STOK = STOK - ? 
                WHERE KODE_PRODUK = ?
            ", [$item['quantity'], $item['id']]);
        }

        // 4. Kosongkan keranjang belanja setelah checkout berhasil
        session()->forget('cart');

        return redirect()->route('checkout.success')->with('order_id', $idPesananBaru);
    }

    public function success()
    {
        return view('checkout.success');
    }
}