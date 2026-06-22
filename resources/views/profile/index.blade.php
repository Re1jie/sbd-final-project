@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl py-6">
    
    {{-- Notifikasi Sukses Update --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl bg-emerald-500 p-4 text-sm font-bold text-white shadow-lg shadow-emerald-500/25">
            <i class="fa-solid fa-circle-check text-xl"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-xl shadow-slate-100">
        
        {{-- HEADER CARD --}}
        <div class="flex flex-col gap-4 bg-slate-900 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <div class="flex items-center gap-3.5">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white shadow-md shadow-emerald-500/20">
                    <i class="fa-solid fa-user-check text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-white tracking-tight">Profil Pelanggan</h3>
                    <p class="text-xs font-medium text-slate-400">Informasi identitas dan lokasi pengiriman pesanan</p>
                </div>
            </div>

            {{-- KELOMPOK TOMBOL AKSI --}}
            <div class="flex items-center gap-2.5">
                
                {{-- TOMBOL EDIT PROFIL (Warna Kuning Amber, Teks Hitam kontras) --}}
                <a href="{{ route('profile.edit') }}" 
                    class="inline-flex items-center gap-2 rounded-xl bg-amber-400 px-4 py-2.5 text-xs font-extrabold text-slate-950 shadow-md shadow-amber-400/20 hover:bg-amber-300 transition-all active:scale-95">
                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                    <span>Edit Profil</span>
                </a>

                {{-- TOMBOL LOGOUT (Warna Rose Merah) --}}
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar dari akun?')" 
                        class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-4 py-2.5 text-xs font-bold text-white shadow-md shadow-rose-600/20 hover:bg-rose-500 transition-all active:scale-95">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>

            </div>
        </div>

        {{-- BODY INFORMASI --}}
        <div class="p-6 sm:p-8 space-y-6">
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 border-b border-slate-100 pb-6">
                <div>
                    <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Nama Lengkap</span>
                    <div class="mt-1 text-base font-extrabold text-slate-900">{{ $user->NAMA }}</div>
                </div>
                <div>
                    <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Alamat Email</span>
                    <div class="mt-1 text-base font-extrabold text-slate-900">{{ $user->EMAIL }}</div>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Alamat Pengiriman Lengkap</span>
                    <span class="text-[10px] font-extrabold text-emerald-700 bg-emerald-50 border border-emerald-200/60 px-2.5 py-0.5 rounded-full">
                        Otomatis ditarik saat Checkout
                    </span>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4 border border-slate-200/60 text-sm font-semibold text-slate-700 leading-relaxed">
                    {{ $user->ALAMAT ?? 'Belum ada alamat pengiriman yang didaftarkan.' }}
                </div>
            </div>

        </div>

    </div>
</div>
@endsection