<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Digunakan jika menggunakan Query Builder untuk MS SQL

class OrderController extends Controller
{
    // 1. Menampilkan Halaman Daftar Pesanan
    public function index(Request $request)
    {
        $search = $request->input('search');
        $isClient = \Illuminate\Support\Facades\Auth::user()->isClient();
        $userEmail = \Illuminate\Support\Facades\Auth::user()->EMAIL;

        $ordersQuery = DB::table('PESANAN')
            ->leftJoin('STATUS_PESANAN', 'PESANAN.ID_STATUS', '=', 'STATUS_PESANAN.ID_STATUS')
            ->select('PESANAN.*', 'STATUS_PESANAN.NAMA_STATUS');

        if ($isClient) {
            $ordersQuery->where('PESANAN.EMAIL', $userEmail);
        }

        $orders = $ordersQuery->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereRaw('CAST(PESANAN.ID_PESANAN AS VARCHAR(20)) LIKE ?', ["%{$search}%"])
                        ->orWhere('PESANAN.EMAIL', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('PESANAN.TANGGAL_PESANAN')
            ->get();

        $statsQuery = DB::table('PESANAN');
        if ($isClient) {
            $statsQuery->where('EMAIL', $userEmail);
        }
        $totalOrders = (clone $statsQuery)->count();
        $pendingOrders = (clone $statsQuery)->whereIn('ID_STATUS', [1, 2])->count();
        $totalRevenue = (clone $statsQuery)->where('STATUS_PEMBAYARAN', 1)->sum('TOTAL_HARGA');

        return view('orders.index', compact(
            'orders',
            'search',
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'isClient'
        ));
    }

    public function cancellations(Request $request)
    {
        // Hanya untuk admin
        if (!\Illuminate\Support\Facades\Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $search = $request->input('search');

        // Ambil pesanan dengan ID_STATUS = 1 (Menunggu Pembayaran) yang sudah > 24 jam
        // Kita hitung selisih jam menggunakan DATEDIFF di SQL Server
        $orders = DB::table('PESANAN')
            ->leftJoin('STATUS_PESANAN', 'PESANAN.ID_STATUS', '=', 'STATUS_PESANAN.ID_STATUS')
            ->select('PESANAN.*', 'STATUS_PESANAN.NAMA_STATUS')
            ->where('PESANAN.ID_STATUS', 1)
            ->whereRaw("DATEDIFF(HOUR, PESANAN.TANGGAL_PESANAN, GETDATE()) >= 24")
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereRaw('CAST(PESANAN.ID_PESANAN AS VARCHAR(20)) LIKE ?', ["%{$search}%"])
                        ->orWhere('PESANAN.EMAIL', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('PESANAN.TANGGAL_PESANAN')
            ->get();

        return view('orders.cancellations', compact('orders', 'search'));
    }

    // 2. Menampilkan Halaman Detail Pesanan
    public function show($id)
    {
        // Mengambil detail satu pesanan berdasarkan ID_PESANAN
        $orderQuery = DB::table('PESANAN')
            ->leftJoin('STATUS_PESANAN', 'PESANAN.ID_STATUS', '=', 'STATUS_PESANAN.ID_STATUS')
            ->leftJoin('PELANGGAN', 'PESANAN.EMAIL', '=', 'PELANGGAN.EMAIL')
            ->select('PESANAN.*', 'STATUS_PESANAN.NAMA_STATUS', 'PELANGGAN.NAMA as NAMA_PELANGGAN', 'PELANGGAN.ALAMAT as ALAMAT_PELANGGAN')
            ->where('PESANAN.ID_PESANAN', $id);

        if (\Illuminate\Support\Facades\Auth::user()->isClient()) {
            $orderQuery->where('PESANAN.EMAIL', \Illuminate\Support\Facades\Auth::user()->EMAIL);
        }

        $order = $orderQuery->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        // Mengambil produk-produk yang ada di dalam pesanan tersebut
        $orderItems = DB::table('ORDERED_PRODUCT')
            ->join('PRODUK', 'ORDERED_PRODUCT.KODE_PRODUK', '=', 'PRODUK.KODE_PRODUK')
            ->where('ORDERED_PRODUCT.ID_PESANAN', $id)
            ->select('ORDERED_PRODUCT.*', 'PRODUK.NAMA_PRODUK', 'PRODUK.HARGA')
            ->get();

        return view('orders.show', compact('order', 'orderItems'));
    }

    // 3. Fitur Update Status Pesanan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2,3,4,5'
        ]);

        // Update ID_STATUS di database
        DB::table('PESANAN')
            ->where('ID_PESANAN', $id)
            ->update(['ID_STATUS' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    // 4. Fitur Selesaikan Pesanan (Client)
    public function completeOrder($id)
    {
        $orderQuery = DB::table('PESANAN')
            ->where('ID_PESANAN', $id)
            ->where('EMAIL', \Illuminate\Support\Facades\Auth::user()->EMAIL);

        $order = $orderQuery->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order->ID_STATUS != 3) {
            return redirect()->back()->with('error', 'Pesanan belum bisa diselesaikan.');
        }

        $orderQuery->update(['ID_STATUS' => 4]);

        return redirect()->back()->with('success', 'Terima kasih! Pesanan telah selesai.');
    }

    // 5. Fitur Batalkan Banyak Pesanan Sekaligus (Bulk Cancel)
    public function bulkCancel(Request $request)
    {
        // Pastikan hanya admin yang bisa mengakses
        if (!\Illuminate\Support\Facades\Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'required'
        ]);

        // Update semua ID pesanan yang dicentang menjadi status 5 (Batal)
        // Kita tambahkan where('ID_STATUS', 1) untuk keamanan ganda agar hanya yang 'Menunggu Pembayaran' yang dibatalkan
        DB::table('PESANAN')
            ->whereIn('ID_PESANAN', $request->order_ids)
            ->where('ID_STATUS', 1)
            ->update(['ID_STATUS' => 5]);

        return redirect()->back()->with('success', count($request->order_ids) . ' pesanan berhasil dibatalkan!');
    }
}
