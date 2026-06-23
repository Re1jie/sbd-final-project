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

    {{-- ================================================================
         SECTION LOYALTY TIER CARD
    ================================================================ --}}
    @if($currentTier)
    <div class="mb-6 overflow-hidden rounded-3xl border shadow-xl transition-all duration-500 hover:shadow-2xl 
        {{ $currentTier->JENIS_TINGKATAN === 'Platinum' ? 'loyalty-platinum-card' : '' }}"
        style="border-color: {{ $currentTier->COLOR_CODE }}33;">
        
        {{-- TIER HEADER — Gradient Background --}}
        <div class="relative overflow-hidden px-6 py-6 sm:px-8"
             style="background: linear-gradient(135deg, {{ $currentTier->COLOR_CODE }}22 0%, {{ $currentTier->COLOR_CODE }}44 50%, {{ $currentTier->COLOR_CODE }}22 100%);">
            
            {{-- Background decorative circles --}}
            <div class="absolute -top-10 -right-10 h-40 w-40 rounded-full opacity-20"
                 style="background: radial-gradient(circle, {{ $currentTier->COLOR_CODE }} 0%, transparent 70%);"></div>
            <div class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full opacity-15"
                 style="background: radial-gradient(circle, {{ $currentTier->COLOR_CODE }} 0%, transparent 70%);"></div>

            <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                
                {{-- Badge + Tier Name --}}
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl shadow-lg transition-transform duration-300 hover:scale-110
                        {{ $currentTier->JENIS_TINGKATAN === 'Platinum' ? 'loyalty-badge-glow' : '' }}"
                         style="background: linear-gradient(145deg, {{ $currentTier->COLOR_CODE }}88, {{ $currentTier->COLOR_CODE }}); box-shadow: 0 8px 32px {{ $currentTier->COLOR_CODE }}55;">
                        <span class="text-3xl">{{ $currentTier->BADGE_ICON }}</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-500">Tier Loyalitas Anda</p>
                        <h3 class="text-2xl font-extrabold tracking-tight text-slate-900"
                            style="text-shadow: 0 0 40px {{ $currentTier->COLOR_CODE }}44;">
                            {{ $currentTier->JENIS_TINGKATAN }}
                        </h3>
                        <p class="text-xs font-semibold text-slate-500">Member sejak bergabung</p>
                    </div>
                </div>

                {{-- Total Belanja Badge --}}
                <div class="rounded-2xl border bg-white/70 px-5 py-3 text-right shadow-sm backdrop-blur-sm"
                     style="border-color: {{ $currentTier->COLOR_CODE }}44;">
                    <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">Total Belanja</p>
                    <p class="text-xl font-extrabold text-slate-900">
                        Rp {{ number_format($totalSpent, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- TIER BODY — Progress & Benefits --}}
        <div class="bg-white px-6 py-5 sm:px-8">

            {{-- Progress Bar ke Tier Berikutnya --}}
            <div class="mb-5">
                @if($nextTier)
                    <div class="mb-2 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-500">
                            <i class="fa-solid fa-arrow-trend-up mr-1" style="color: {{ $currentTier->COLOR_CODE }};"></i>
                            Progress ke <span class="font-extrabold text-slate-800">{{ $nextTier->JENIS_TINGKATAN }}</span>
                        </span>
                        <span class="text-xs font-extrabold" style="color: {{ $currentTier->COLOR_CODE }};">{{ $progressPercentage }}%</span>
                    </div>
                    
                    {{-- Progress Bar --}}
                    <div class="relative h-3 w-full overflow-hidden rounded-full bg-slate-100 shadow-inner">
                        <div class="absolute inset-y-0 left-0 rounded-full transition-all duration-1000 ease-out loyalty-progress-bar"
                             style="width: {{ $progressPercentage }}%; background: linear-gradient(90deg, {{ $currentTier->COLOR_CODE }}aa, {{ $currentTier->COLOR_CODE }}, {{ $nextTier->COLOR_CODE }}aa); box-shadow: 0 0 12px {{ $currentTier->COLOR_CODE }}66;">
                        </div>
                    </div>

                    {{-- Motivasi --}}
                    <div class="mt-3 flex items-center gap-2 rounded-xl border px-4 py-2.5"
                         style="background: {{ $nextTier->COLOR_CODE }}08; border-color: {{ $nextTier->COLOR_CODE }}22;">
                        <span class="text-lg">{{ $nextTier->BADGE_ICON }}</span>
                        <p class="text-xs font-bold text-slate-600">
                            Belanja <span class="font-extrabold text-slate-900">Rp {{ number_format($amountToNextTier, 0, ',', '.') }}</span> 
                            lagi untuk mencapai tier 
                            <span class="font-extrabold" style="color: {{ $nextTier->COLOR_CODE }};">{{ $nextTier->JENIS_TINGKATAN }}</span>!
                        </p>
                    </div>
                @else
                    {{-- Sudah Platinum / Tier Tertinggi --}}
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-500">
                            <i class="fa-solid fa-crown mr-1" style="color: {{ $currentTier->COLOR_CODE }};"></i>
                            Level Tier
                        </span>
                        <span class="text-xs font-extrabold" style="color: {{ $currentTier->COLOR_CODE }};">MAX</span>
                    </div>
                    <div class="relative h-3 w-full overflow-hidden rounded-full bg-slate-100 shadow-inner">
                        <div class="absolute inset-y-0 left-0 rounded-full loyalty-progress-bar"
                             style="width: 100%; background: linear-gradient(90deg, {{ $currentTier->COLOR_CODE }}aa, {{ $currentTier->COLOR_CODE }}); box-shadow: 0 0 12px {{ $currentTier->COLOR_CODE }}66;">
                        </div>
                    </div>
                    <div class="mt-3 flex items-center gap-2 rounded-xl border px-4 py-2.5"
                         style="background: {{ $currentTier->COLOR_CODE }}0d; border-color: {{ $currentTier->COLOR_CODE }}22;">
                        <span class="text-lg">🎉</span>
                        <p class="text-xs font-bold text-slate-600">
                            Selamat! Anda sudah berada di <span class="font-extrabold" style="color: {{ $currentTier->COLOR_CODE }};">tier tertinggi</span>. 
                            Nikmati semua benefit eksklusif!
                        </p>
                    </div>
                @endif
            </div>

            {{-- Benefit List --}}
            @if($currentTier->BENEFITS)
                <div class="border-t border-slate-100 pt-4">
                    <p class="mb-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400">
                        <i class="fa-solid fa-gift mr-1"></i> Benefit Tier {{ $currentTier->JENIS_TINGKATAN }}
                    </p>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                        @foreach(explode(';', $currentTier->BENEFITS) as $benefit)
                            <div class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-slate-50/80 px-3 py-2 transition-all duration-200 hover:border-slate-200 hover:bg-white hover:shadow-sm">
                                <div class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full"
                                     style="background: {{ $currentTier->COLOR_CODE }}22;">
                                    <i class="fa-solid fa-check text-[9px]" style="color: {{ $currentTier->COLOR_CODE }};"></i>
                                </div>
                                <span class="text-xs font-semibold text-slate-700">{{ trim($benefit) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Tier Overview (semua tier mini) --}}
            <div class="mt-5 border-t border-slate-100 pt-4">
                <p class="mb-3 text-[10px] font-extrabold uppercase tracking-widest text-slate-400">
                    <i class="fa-solid fa-layer-group mr-1"></i> Semua Level Tier
                </p>
                <div class="flex items-center gap-1.5">
                    @foreach($allTiers as $tier)
                        <div class="flex flex-1 items-center gap-1.5 rounded-xl px-2.5 py-2 text-center transition-all duration-200
                            {{ $tier->ID_LOYALITAS === $currentTier->ID_LOYALITAS ? 'ring-2 shadow-md scale-105' : 'opacity-50' }}"
                             style="background: {{ $tier->COLOR_CODE }}15;
                                    {{ $tier->ID_LOYALITAS === $currentTier->ID_LOYALITAS ? 'ring-color: ' . $tier->COLOR_CODE . '; box-shadow: 0 4px 16px ' . $tier->COLOR_CODE . '33;' : '' }}">
                            <span class="text-sm">{{ $tier->BADGE_ICON }}</span>
                            <span class="text-[10px] font-extrabold text-slate-700 truncate">{{ $tier->JENIS_TINGKATAN }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ================================================================
         CARD PROFIL PELANGGAN (EXISTING)
    ================================================================ --}}
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

{{-- ================================================================
     CUSTOM CSS ANIMATIONS FOR LOYALTY TIER
================================================================ --}}
<style>
    /* Progress bar entrance animation */
    .loyalty-progress-bar {
        animation: progressSlide 1.5s ease-out forwards;
    }
    @keyframes progressSlide {
        from { width: 0 !important; }
    }

    /* Platinum card shimmer effect */
    .loyalty-platinum-card {
        position: relative;
        background: linear-gradient(135deg, #fafafa 0%, #f0f0f0 50%, #fafafa 100%);
    }
    .loyalty-platinum-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(229, 228, 226, 0.15) 40%,
            rgba(229, 228, 226, 0.35) 50%,
            rgba(229, 228, 226, 0.15) 60%,
            transparent 100%
        );
        animation: shimmer 3s infinite;
        z-index: 1;
        pointer-events: none;
        border-radius: inherit;
    }
    @keyframes shimmer {
        0%   { left: -100%; }
        100% { left: 100%; }
    }

    /* Platinum badge glow pulse */
    .loyalty-badge-glow {
        animation: badgeGlow 2s ease-in-out infinite alternate;
    }
    @keyframes badgeGlow {
        0%   { box-shadow: 0 8px 32px rgba(229, 228, 226, 0.4); }
        100% { box-shadow: 0 8px 48px rgba(229, 228, 226, 0.7), 0 0 20px rgba(229, 228, 226, 0.3); }
    }
</style>
@endsection