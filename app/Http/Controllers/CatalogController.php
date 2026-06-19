<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function index()
    {
        // Raw SQL ambil produk aktif beserta nama kategorinya
        $products = DB::select("
            SELECT P.*, K.NAMA_KATEGORI 
            FROM PRODUK P 
            LEFT JOIN KATEGORI K ON P.ID_KATEGORI = K.ID_KATEGORI
        ");
        return view('catalog.index', compact('products'));
    }

    public function show($id)
    {
        $product = DB::select("
            SELECT P.*, K.NAMA_KATEGORI 
            FROM PRODUK P 
            LEFT JOIN KATEGORI K ON P.ID_KATEGORI = K.ID_KATEGORI 
            WHERE P.KODE_PRODUK = ?
        ", [$id]);

        if (empty($product)) {
            abort(404, 'Produk tidak ditemukan');
        }

        return view('catalog.show', ['product' => $product[0]]);
    }
}