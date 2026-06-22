<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'EMAIL' => ['required', 'email'],
            'PASSWORD' => ['required'],
        ]);

        // --- BYPASS BCRYPT (CARI MANUAL KE DATABASE) ---
        // Kita cari baris di tabel PELANGGAN yang EMAIL dan PASSWORD-nya persis sama
        $user = User::where('EMAIL', $request->EMAIL)
                    ->where('PASSWORD', $request->PASSWORD)
                    ->first();

        // Jika datanya ketemu (Email dan Password cocok)
        if ($user) {
            Auth::login($user); // Daftarkan paksa sesi loginnya ke sistem Laravel

            $request->session()->regenerate();

            if ($user->isAdmin()) {
                return redirect()->route('dashboard');
            }
            return redirect()->route('catalog.index');
        }

        // Jika tidak ketemu / salah
        return back()->withErrors([
            'EMAIL' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('EMAIL');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'NAMA' => ['required', 'string', 'max:255'],
            'EMAIL' => ['required', 'string', 'email', 'max:255', 'unique:PELANGGAN,EMAIL'],
            'PASSWORD' => ['required', 'string', 'min:8', 'confirmed'],
            'ALAMAT' => ['required', 'string'],
        ]);

        User::create([
            'NAMA' => $validated['NAMA'],
            'EMAIL' => $validated['EMAIL'],
            'PASSWORD' => $validated['PASSWORD'], // Simpan teks asli tanpa Bcrypt
            'ROLE' => 'PELANGGAN', 
            'ALAMAT' => $validated['ALAMAT'],
            'ID_LOYALITAS' => null,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan masukkan Email dan Password Anda untuk masuk.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Tambahkan with('success', ...) agar kotak hijau di halaman login menyala
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}