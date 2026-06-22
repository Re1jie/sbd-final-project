<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
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