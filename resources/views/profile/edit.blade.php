@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl py-6">
    <div class="overflow-hidden rounded-3xl border border-amber-500/30 bg-white shadow-2xl shadow-amber-500/10">
        
        {{-- HEADER FORM EDIT --}}
        <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-5 sm:px-8 flex items-center gap-3.5">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/20 text-slate-950 backdrop-blur-md">
                <i class="fa-solid fa-pen-nib text-xl font-extrabold"></i>
            </div>
            <div>
                <h3 class="text-lg font-extrabold text-slate-950 tracking-tight">Edit Data & Alamat</h3>
                <p class="text-xs font-medium text-slate-900/80">Pastikan alamat diisi selengkap mungkin untuk kurir</p>
            </div>
        </div>

        {{-- FORM INPUT (NAMA, EMAIL, ALAMAT kapital) --}}
        <form method="POST" action="{{ route('profile.update') }}" class="p-6 sm:p-8 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-600 mb-1.5">Nama Lengkap</label>
                <input type="text" name="NAMA" value="{{ old('NAMA', $user->NAMA) }}" required 
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-900 transition-all focus:border-amber-500 focus:bg-white focus:outline-hidden shadow-2xs">
                @error('NAMA') <small class="font-bold text-rose-500">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-600 mb-1.5">Alamat Email</label>
                <input type="email" name="EMAIL" value="{{ old('EMAIL', $user->EMAIL) }}" required 
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-bold text-slate-900 transition-all focus:border-amber-500 focus:bg-white focus:outline-hidden shadow-2xs">
                @error('EMAIL') <small class="font-bold text-rose-500">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-600 mb-1.5">Alamat Pengiriman</label>
                <textarea name="ALAMAT" rows="4" required placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, dan kode pos..."
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm font-bold text-slate-900 transition-all focus:border-amber-500 focus:bg-white focus:outline-hidden shadow-2xs leading-relaxed">{{ old('ALAMAT', $user->ALAMAT) }}</textarea>
                @error('ALAMAT') <small class="font-bold text-rose-500">{{ $message }}</small> @enderror
            </div>

            {{-- TOMBOL SIMPAN & BATAL --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('profile.index') }}" 
                    class="rounded-xl px-5 py-3 text-xs font-bold text-slate-500 hover:bg-slate-100 transition-all">
                    Batal
                </a>
                <button type="submit" 
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-3 text-xs font-extrabold text-slate-950 shadow-lg shadow-amber-500/25 hover:from-amber-400 hover:to-orange-400 transition-all active:scale-95">
                    <i class="fa-solid fa-floppy-disk text-sm"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>

        </form>

    </div>
</div>
@endsection