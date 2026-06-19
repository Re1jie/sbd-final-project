<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // 1. Menampilkan Daftar Kategori
    public function index()
    {
        // Mengambil semua data dari tabel KATEGORI menggunakan Raw SQL
        $categories = DB::select("SELECT * FROM KATEGORI ORDER BY ID_KATEGORI DESC");
        
        return view('admin.categories.index', compact('categories'));
    }

    // 2. Menampilkan Form Tambah Kategori
    public function create()
    {
        return view('admin.categories.create');
    }

    // 3. Menyimpan Kategori Baru ke Database
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'NAMA_KATEGORI' => 'required|string|max:100',
            'DESKRIPSI'     => 'nullable|string',
        ], [
            'NAMA_KATEGORI.required' => 'Nama kategori wajib diisi.',
        ]);

        // Insert ke database SQL Server menggunakan Raw SQL
        DB::insert("
            INSERT INTO KATEGORI (NAMA_KATEGORI, DESKRIPSI) 
            VALUES (?, ?)
        ", [
            $request->NAMA_KATEGORI,
            $request->DESKRIPSI
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // 4. Menampilkan Form Edit Kategori
    public function edit($id)
    {
        // Mencari data kategori berdasarkan ID_KATEGORI
        $category = DB::select("SELECT * FROM KATEGORI WHERE ID_KATEGORI = ?", [$id]);
        
        if (empty($category)) {
            abort(404, 'Kategori tidak ditemukan');
        }

        return view('admin.categories.edit', ['category' => $category[0]]);
    }

    // 5. Memperbarui Data Kategori di Database
    public function update(Request $request, $id)
    {
        $request->validate([
            'NAMA_KATEGORI' => 'required|string|max:100',
            'DESKRIPSI'     => 'nullable|string',
        ], [
            'NAMA_KATEGORI.required' => 'Nama kategori wajib diisi.',
        ]);

        // Update data menggunakan Raw SQL
        DB::update("
            UPDATE KATEGORI 
            SET NAMA_KATEGORI = ?, DESKRIPSI = ? 
            WHERE ID_KATEGORI = ?
        ", [
            $request->NAMA_KATEGORI,
            $request->DESKRIPSI,
            $id
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // 6. Menghapus Kategori
    public function destroy($id)
    {
        try {
            // Hapus data berdasarkan ID_KATEGORI
            DB::delete("DELETE FROM KATEGORI WHERE ID_KATEGORI = ?", [$id]);
            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            // Jaga-jaga jika kategori gagal dihapus karena masih terikat dengan data PRODUK (Foreign Key Constraint)
            return redirect()->route('admin.categories.index')->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh produk.');
        }
    }
}