<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pembayaran untuk pesanan tertentu.
     */
    public function show($id)
    {
        $pesanan = DB::selectOne("
            SELECT p.*, sp.NAMA_STATUS 
            FROM PESANAN p 
            JOIN STATUS_PESANAN sp ON p.ID_STATUS = sp.ID_STATUS 
            WHERE p.ID_PESANAN = ? AND p.EMAIL = ?
        ", [$id, Auth::user()->EMAIL]);

        if (!$pesanan) {
            return redirect()->route('orders.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Ambil produk yang dipesan
        $items = DB::select("
            SELECT op.KODE_PRODUK, pr.NAMA_PRODUK, pr.HARGA
            FROM ORDERED_PRODUCT op
            JOIN PRODUK pr ON op.KODE_PRODUK = pr.KODE_PRODUK
            WHERE op.ID_PESANAN = ?
        ", [$id]);

        return view('payment.show', compact('pesanan', 'items'));
    }

    /**
     * Memproses pembayaran (dummy) — update ID_STATUS ke 2 (Diproses).
     */
    public function pay($id)
    {
        $pesanan = DB::selectOne("
            SELECT * FROM PESANAN WHERE ID_PESANAN = ? AND EMAIL = ?
        ", [$id, Auth::user()->EMAIL]);

        if (!$pesanan) {
            return redirect()->route('orders.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($pesanan->ID_STATUS != 1) {
            return redirect()->route('payment.show', $id)->with('error', 'Pesanan ini tidak dalam status menunggu pembayaran.');
        }

        DB::update("UPDATE PESANAN SET ID_STATUS = 2, STATUS_PEMBAYARAN = 1 WHERE ID_PESANAN = ?", [$id]);

        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil! Pesanan #' . $id . ' sedang diproses.');
    }

    /**
     * Membatalkan pesanan — update ID_STATUS ke 5 (Dibatalkan).
     */
    public function cancel($id)
    {
        $pesanan = DB::selectOne("
            SELECT * FROM PESANAN WHERE ID_PESANAN = ? AND EMAIL = ?
        ", [$id, Auth::user()->EMAIL]);

        if (!$pesanan) {
            return redirect()->route('orders.index')->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($pesanan->ID_STATUS != 1) {
            return redirect()->route('payment.show', $id)->with('error', 'Pesanan ini tidak bisa dibatalkan.');
        }

        DB::beginTransaction();
        try {
            // Update status pesanan ke 5 (Dibatalkan)
            DB::update("UPDATE PESANAN SET ID_STATUS = 5 WHERE ID_PESANAN = ?", [$id]);

            // Kembalikan stok produk
            $items = DB::select("
                SELECT op.KODE_PRODUK 
                FROM ORDERED_PRODUCT op 
                WHERE op.ID_PESANAN = ?
            ", [$id]);

            foreach ($items as $item) {
                DB::update("UPDATE PRODUK SET STOK = STOK + 1 WHERE KODE_PRODUK = ?", [
                    $item->KODE_PRODUK
                ]);
            }

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Pesanan #' . $id . ' berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('payment.show', $id)->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }
}
