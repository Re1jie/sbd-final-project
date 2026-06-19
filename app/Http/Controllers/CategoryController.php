<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // 1. Menampilkan Daftar Kategori
    public function index()
    {
        $categories = DB::select("SELECT * FROM KATEGORI ORDER BY ID_KATEGORI DESC");
        return view('admin.categories.index', compact('categories'));
    }

    // 2. Menampilkan Form Tambah Kategori
    public function create()
    {
        return view('admin.categories.create');
    }

    // 3. Menyimpan Kategori Baru ke Database dengan Input ID Manual
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'ID_KATEGORI'   => 'required|numeric|min:1',
            'NAMA_KATEGORI' => 'required|string|max:100',
        ], [
            'ID_KATEGORI.required'   => 'ID Kategori wajib diisi.',
            'ID_KATEGORI.numeric'    => 'ID Kategori harus berupa angka.',
            'NAMA_KATEGORI.required' => 'Nama kategori wajib diisi.',
        ]);

        // Cek keunikan ID_KATEGORI secara manual karena menggunakan Non-ORM Raw SQL
        $exists = DB::select("SELECT 1 FROM KATEGORI WHERE ID_KATEGORI = ?", [$request->ID_KATEGORI]);
        if (!empty($exists)) {
            return redirect()->back()->withInput()->withErrors(['ID_KATEGORI' => 'ID Kategori sudah terdaftar! Gunakan ID lain.']);
        }

        // Masukkan data beserta ID_KATEGORI yang diinput user
        DB::insert("
            INSERT INTO KATEGORI (ID_KATEGORI, NAMA_KATEGORI) 
            VALUES (?, ?)
        ", [
            $request->ID_KATEGORI,
            $request->NAMA_KATEGORI,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // 4. Menampilkan Form Edit Kategori
    public function edit($id)
    {
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
        ], [
            'NAMA_KATEGORI.required' => 'Nama kategori wajib diisi.',
        ]);

        DB::update("
            UPDATE KATEGORI 
            SET NAMA_KATEGORI = ? 
            WHERE ID_KATEGORI = ?
        ", [
            $request->NAMA_KATEGORI,
            $id
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // 6. Menghapus Kategori
    public function destroy($id)
    {
        try {
            DB::delete("DELETE FROM KATEGORI WHERE ID_KATEGORI = ?", [$id]);
            return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh produk.');
        }
    }
}