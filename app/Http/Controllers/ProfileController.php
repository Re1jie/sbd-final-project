<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userEmail = $user->EMAIL;

        // 1. Hitung total pembelian user (hanya pesanan yang sudah dibayar)
        $totalSpent = (int) DB::table('PESANAN')
            ->where('EMAIL', $userEmail)
            ->where('STATUS_PEMBAYARAN', 1)
            ->sum('TOTAL_HARGA');

        // 2. Definisi tier (hardcoded — tanpa ubah tabel LOYALITAS)
        $tiers = collect([
            (object) [
                'ID_LOYALITAS' => 1, 'JENIS_TINGKATAN' => 'Bronze',
                'MIN_AMOUNT' => 0, 'MAX_AMOUNT' => 999999,
                'COLOR_CODE' => '#CD7F32', 'BADGE_ICON' => '🥉',
                'BENEFITS' => 'Akses katalog lengkap;Ongkir flat Rp 5.000',
            ],
            (object) [
                'ID_LOYALITAS' => 2, 'JENIS_TINGKATAN' => 'Silver',
                'MIN_AMOUNT' => 1000000, 'MAX_AMOUNT' => 2499999,
                'COLOR_CODE' => '#C0C0C0', 'BADGE_ICON' => '🥈',
                'BENEFITS' => 'Semua benefit Bronze;Gratis ongkir untuk semua pesanan',
            ],
            (object) [
                'ID_LOYALITAS' => 3, 'JENIS_TINGKATAN' => 'Gold',
                'MIN_AMOUNT' => 2500000, 'MAX_AMOUNT' => 4999999,
                'COLOR_CODE' => '#FFD700', 'BADGE_ICON' => '🥇',
                'BENEFITS' => 'Gratis ongkir untuk semua pesanan;Diskon 5% setiap pembelian',
            ],
            (object) [
                'ID_LOYALITAS' => 4, 'JENIS_TINGKATAN' => 'Platinum',
                'MIN_AMOUNT' => 5000000, 'MAX_AMOUNT' => null,
                'COLOR_CODE' => '#E5E4E2', 'BADGE_ICON' => '💎',
                'BENEFITS' => 'Gratis ongkir untuk semua pesanan;Diskon 10% setiap pembelian',
            ],
        ]);

        // 3. Cari tier saat ini
        $currentTier = $tiers->first(function ($tier) use ($totalSpent) {
            return $totalSpent >= $tier->MIN_AMOUNT
                && ($tier->MAX_AMOUNT === null || $totalSpent <= $tier->MAX_AMOUNT);
        });

        // 4. Cari tier berikutnya
        $nextTier = $tiers->first(function ($tier) use ($totalSpent) {
            return $tier->MIN_AMOUNT > $totalSpent;
        });

        // 5. Hitung progress ke tier berikutnya (%)
        $progressPercentage = 100;
        if ($nextTier && $currentTier) {
            $range = $nextTier->MIN_AMOUNT - $currentTier->MIN_AMOUNT;
            $progressPercentage = $range > 0
                ? round((($totalSpent - $currentTier->MIN_AMOUNT) / $range) * 100)
                : 100;
        }

        // 6. Sisa nominal yang dibutuhkan untuk naik tier
        $amountToNextTier = $nextTier
            ? $nextTier->MIN_AMOUNT - $totalSpent
            : 0;

        // 7. Sinkronkan ID_LOYALITAS di tabel PELANGGAN
        if ($currentTier) {
            DB::table('PELANGGAN')
                ->where('EMAIL', $userEmail)
                ->update(['ID_LOYALITAS' => $currentTier->ID_LOYALITAS]);
        }

        // 8. Kirim semua tier juga untuk overview di view
        $allTiers = $tiers;

        return view('profile.index', compact(
            'user',
            'totalSpent',
            'currentTier',
            'nextTier',
            'progressPercentage',
            'amountToNextTier',
            'allTiers'
        ));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'NAMA' => ['required', 'string', 'max:255'],
            // --- SESUAIKAN BARIS UNIQUE EMAIL MENJADI SEPERTI INI ---
            'EMAIL' => ['required', 'string', 'email', 'max:255', 'unique:PELANGGAN,EMAIL,' . $user->EMAIL . ',EMAIL'],
            'ALAMAT' => ['required', 'string'],
        ]);

        $user->update($validated);

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}