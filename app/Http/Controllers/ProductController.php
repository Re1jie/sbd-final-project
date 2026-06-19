<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Tampilkan Semua Produk
    public function index()
    {
        // Raw SQL Join untuk mengambil nama kategori
        $products = DB::select("
            SELECT P.*, K.NAMA_KATEGORI 
            FROM PRODUK P 
            LEFT JOIN KATEGORI K ON P.ID_KATEGORI = K.ID_KATEGORI
        ");
        
        return view('admin.products.index', compact('products'));
    }

    // Form Tambah Produk
    public function create()
    {
        $categories = DB::select("SELECT * FROM KATEGORI");
        return view('admin.products.create', compact('categories'));
    }

    // Simpan Produk Baru
    public function store(Request $request)
    {
        // Validasi sesuai instruksi
        $request->validate([
            'KODE_PRODUK' => 'required|numeric', // Validasi unik dilakukan via try-catch atau manual check karena non-ORM
            'NAMA_PRODUK' => 'required|string|max:100',
            'ID_KATEGORI' => 'required',
            'HARGA'       => 'required|numeric|min:0',
            'STOK'        => 'required|numeric|min:0',
        ]);

        // Cek duplikasi KODE_PRODUK secara manual
        $exists = DB::select("SELECT 1 FROM PRODUK WHERE KODE_PRODUK = ?", [$request->KODE_PRODUK]);
        if (!empty($exists)) {
            return redirect()->back()->withInput()->withErrors(['KODE_PRODUK' => 'Kode produk sudah terdaftar!']);
        }

        // Insert menggunakan Raw SQL
        DB::insert("
            INSERT INTO PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK) 
            VALUES (?, ?, ?, ?, ?)
        ", [
            $request->KODE_PRODUK,
            $request->ID_KATEGORI,
            $request->NAMA_PRODUK,
            $request->HARGA,
            $request->STOK
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Form Edit Produk
    public function edit($id)
    {
        $product = DB::select("SELECT * FROM PRODUK WHERE KODE_PRODUK = ?", [$id]);
        if (empty($product)) {
            abort(404);
        }
        
        $categories = DB::select("SELECT * FROM KATEGORI");
        return view('admin.products.edit', ['product' => $product[0], 'categories' => $categories]);
    }

    // Update Data Produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'NAMA_PRODUK' => 'required|string|max:100',
            'ID_KATEGORI' => 'required',
            'HARGA'       => 'required|numeric|min:0',
            'STOK'        => 'required|numeric|min:0',
        ]);

        DB::update("
            UPDATE PRODUK 
            SET ID_KATEGORI = ?, NAMA_PRODUK = ?, HARGA = ?, STOK = ? 
            WHERE KODE_PRODUK = ?
        ", [
            $request->ID_KATEGORI,
            $request->NAMA_PRODUK,
            $request->HARGA,
            $request->STOK,
            $id
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus Produk
    public function destroy($id)
    {
        DB::delete("DELETE FROM PRODUK WHERE KODE_PRODUK = ?", [$id]);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}