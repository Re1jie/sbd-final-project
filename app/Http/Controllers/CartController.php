<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja untuk pembeli.
     * Mengarah ke resources/views/cart/index.blade.php
     */
    public function index()
    {
        // Mengambil data cart pembeli dari session, default array kosong jika belum ada
        $cart = session()->get('cart', []);
        
        return view('cart.index', compact('cart'));
    }

    /**
     * Menambahkan produk ke dalam keranjang belanja.
     */
    public function add(Request $request, $id)
    {
        // Ambil data produk berdasarkan kode produk menggunakan query sql manual
        $product = DB::select("SELECT * FROM PRODUK WHERE KODE_PRODUK = ?", [$id]);
        
        if (empty($product)) {
            abort(404, 'Produk tidak ditemukan');
        }

        $product = $product[0];
        
        // Mencegah produk yang stoknya habis masuk ke keranjang
        if ($product->STOK <= 0) {
            return redirect()->back()->with('error', 'Produk ini sudah habis!');
        }

        $cart = session()->get('cart', []);

        // Jika produk sudah ada di dalam keranjang, tambahkan jumlahnya
        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] + 1 > $product->STOK) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia!');
            }
            $cart[$id]['quantity']++;
        } else {
            // Jika produk belum ada di dalam keranjang pembeli, masukkan data baru
            $cart[$id] = [
                "id" => $product->KODE_PRODUK,
                "name" => $product->NAMA_PRODUK,
                "quantity" => 1,
                "price" => $product->HARGA,
                "max_stock" => $product->STOK
            ];
        }

        // Simpan kembali perubahan ke dalam session
        session()->put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Memperbarui kuantitas produk di dalam keranjang belanja.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Validasi ketersediaan stok produk secara real-time
            if ($request->quantity > $cart[$id]['max_stock']) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi!');
            }
            
            // Perbarui jumlah kuantitas
            $cart[$id]['quantity'] = $request->quantity;
            
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang belanja berhasil diperbarui!');
    }

    /**
     * Menghapus item produk tertentu dari keranjang belanja.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}