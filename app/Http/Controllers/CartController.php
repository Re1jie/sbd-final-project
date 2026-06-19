<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = DB::select("SELECT * FROM PRODUK WHERE KODE_PRODUK = ?", [$id]);
        if (empty($product)) abort(404);

        $product = $product[0];
        
        // Mencegah produk habis masuk ke keranjang
        if ($product->STOK <= 0) {
            return redirect()->back()->with('error', 'Produk ini sudah habis!');
        }

        $cart = session()->get('cart', []);

        // Jika produk sudah ada di keranjang, tambahkan jumlahnya
        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] + 1 > $product->STOK) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia!');
            }
            $cart[$id]['quantity']++;
        } else {
            // Jika produk belum ada di keranjang
            $cart[$id] = [
                "id" => $product->KODE_PRODUK,
                "name" => $product->NAMA_PRODUK,
                "quantity" => 1,
                "price" => $product->HARGA,
                "max_stock" => $product->STOK
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|numeric|min:1']);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Validasi kecukupan stok secara real-time
            if ($request->quantity > $cart[$id]['max_stock']) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi!');
            }
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang!');
    }
}