@extends('layouts.app', ['pageTitle' => 'Daftar Akun - KOPDESShop'])

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-5xl w-full bg-white rounded-2xl shadow-xl border border-zinc-100 overflow-hidden flex flex-col md:flex-row">
        
        <div class="md:w-5/12 bg-zinc-100 hidden md:block relative">
            <img 
                src="https://images.unsplash.com/photo-1533900298318-6b8da08a523e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                alt="KOPDESShop Fresh Market" 
                class="absolute inset-0 w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-emerald-900/50 mix-blend-multiply"></div>
            
            <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/90 to-transparent">
                <div class="inline-block px-3 py-1 bg-emerald-600 text-white text-xs font-bold rounded-full mb-3 shadow-sm">
                    KOPDESShop
                </div>
                <h3 class="text-white text-2xl font-bold">Mari Majukan Ekonomi Desa</h3>
                <p class="text-zinc-200 text-sm mt-2">Daftarkan diri Anda sekarang. Belanja kebutuhan pokok lebih praktis, hemat, dan turut memberdayakan produk-produk lokal kita.</p>
            </div>
        </div>

        <div class="w-full md:w-7/12 p-8 sm:p-10 flex flex-col justify-center bg-white">
            
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 mb-4 shadow-sm">
                    <i class="fa-solid fa-user-plus text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-zinc-900">Buat Akun Baru</h2>
                <p class="text-sm text-zinc-500 mt-2">Lengkapi data diri Anda untuk bergabung dengan <span class="font-semibold text-emerald-600">KOPDESShop</span>.</p>
            </div>

            <form method="POST" action="{{ route('register.process') }}" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label for="NAMA" class="block text-sm font-medium text-zinc-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-user text-zinc-400"></i>
                            </div>
                            <input 
                                type="text" 
                                id="NAMA"
                                name="NAMA" 
                                class="block w-full pl-10 pr-3 py-2.5 border border-zinc-300 rounded-lg text-sm placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm" 
                                placeholder="Masukkan nama Anda"
                                value="{{ old('NAMA') }}" 
                                required 
                                autofocus
                            >
                        </div>
                        @error('NAMA') 
                            <p class="mt-1.5 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p> 
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="EMAIL" class="block text-sm font-medium text-zinc-700 mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-regular fa-envelope text-zinc-400"></i>
                            </div>
                            <input 
                                type="email" 
                                id="EMAIL"
                                name="EMAIL" 
                                class="block w-full pl-10 pr-3 py-2.5 border border-zinc-300 rounded-lg text-sm placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm" 
                                placeholder="nama@email.com"
                                value="{{ old('EMAIL') }}" 
                                required
                            >
                        </div>
                        @error('EMAIL') 
                            <p class="mt-1.5 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p> 
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="ALAMAT" class="block text-sm font-medium text-zinc-700 mb-1.5">Alamat Lengkap Pengiriman</label>
                        <div class="relative">
                            <div class="absolute top-3 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-map-location-dot text-zinc-400"></i>
                            </div>
                            <textarea 
                                id="ALAMAT"
                                name="ALAMAT" 
                                rows="3"
                                class="block w-full pl-10 pr-3 py-2.5 border border-zinc-300 rounded-lg text-sm placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm resize-none" 
                                placeholder="Contoh: Jl. Desa Makmur Raya No. 12, RT 01 / RW 02..."
                                required
                            >{{ old('ALAMAT') }}</textarea>
                        </div>
                        @error('ALAMAT') 
                            <p class="mt-1.5 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p> 
                        @enderror
                    </div>

                    <div>
                        <label for="PASSWORD" class="block text-sm font-medium text-zinc-700 mb-1.5">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-zinc-400"></i>
                            </div>
                            <input 
                                type="password" 
                                id="PASSWORD"
                                name="PASSWORD" 
                                class="block w-full pl-10 pr-3 py-2.5 border border-zinc-300 rounded-lg text-sm placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm" 
                                placeholder="Minimal 8 karakter"
                                required
                            >
                        </div>
                        @error('PASSWORD') 
                            <p class="mt-1.5 text-sm text-red-600"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p> 
                        @enderror
                    </div>

                    <div>
                        <label for="PASSWORD_confirmation" class="block text-sm font-medium text-zinc-700 mb-1.5">Konfirmasi Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-check-double text-zinc-400"></i>
                            </div>
                            <input 
                                type="password" 
                                id="PASSWORD_confirmation"
                                name="PASSWORD_confirmation" 
                                class="block w-full pl-10 pr-3 py-2.5 border border-zinc-300 rounded-lg text-sm placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all shadow-sm" 
                                placeholder="Ulangi sandi"
                                required
                            >
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center items-center gap-2 py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all mt-6">
                    Daftar Akun <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-zinc-500 border-t border-zinc-100 pt-5">
                Sudah terdaftar sebagai warga koperasi? 
                <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-all">
                    Masuk di sini
                </a>
            </div>

        </div>
    </div>
</div>
@endsection