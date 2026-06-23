<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        $totalBelanja = 0;
        foreach ($cart as $item) {
            $totalBelanja += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'totalBelanja'));
    }

   public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();

        try {
            $emailCustomer = Auth::user()->EMAIL;
            
            $totalHarga = 0;
            foreach ($cart as $item) {
                $totalHarga += $item['price'] * $item['quantity'];
            }

            // 1. GENERATE ID_PESANAN SECARA MANUAL (kolom bukan IDENTITY/auto-increment)
            $result = DB::select("SELECT ISNULL(MAX(ID_PESANAN), 0) + 1 AS next_id FROM PESANAN");
            $idPesanan = $result[0]->next_id;

            // 2. INSERT KE TABEL PESANAN
            DB::insert("INSERT INTO PESANAN (ID_PESANAN, EMAIL, TOTAL_HARGA, ID_STATUS, TANGGAL_PESANAN) VALUES (?, ?, ?, ?, GETDATE())", [
                $idPesanan,
                $emailCustomer,
                $totalHarga,
                1 // ID_STATUS untuk 'Menunggu Pembayaran'
            ]);

            // 3. INSERT KE TABEL ORDERED_PRODUCT
            foreach ($cart as $id => $item) {
                DB::insert("INSERT INTO ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK) VALUES (?, ?)", [
                    $idPesanan,
                    $item['id']
                ]);

                // Update stok produk
                DB::update("UPDATE PRODUK SET STOK = STOK - ? WHERE KODE_PRODUK = ?", [
                    $item['quantity'],
                    $item['id']
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('payment.show', $idPesanan)->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}