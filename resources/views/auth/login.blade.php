@extends('layouts.app', ['pageTitle' => 'Login - KOPDESShop'])

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-4xl w-full bg-white rounded-2xl shadow-xl border border-zinc-100 overflow-hidden flex flex-col md:flex-row">
        
        <div class="md:w-1/2 bg-zinc-100 hidden md:block relative">
            <img 
                src="https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                alt="KOPDESShop Aesthetic Market" 
                class="absolute inset-0 w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-emerald-900/40 mix-blend-multiply"></div>
            
            <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/80 to-transparent">
                <div class="inline-block px-3 py-1 bg-emerald-600 text-white text-xs font-bold rounded-full mb-3 shadow-sm">
                    KOPDESShop
                </div>
                <h3 class="text-white text-2xl font-bold">Belanja Harian Lebih Mudah</h3>
                <p class="text-zinc-200 text-sm mt-2">Dukung produk lokal dan penuhi kebutuhan keluarga Anda dengan harga terbaik dan kualitas terjamin dari Koperasi Desa.</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center bg-white">
            
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 mb-4 shadow-sm">
                    <i class="fa-solid fa-basket-shopping text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-zinc-900">Selamat Datang!</h2>
                <p class="text-sm text-zinc-500 mt-2">Masuk ke akun <span class="font-semibold text-emerald-600">KOPDESShop</span> Anda.</p>
            </div>

            {{-- PENANGKAP PESAN SUKSES DARI REGISTER --}}
            @if(session('success'))
                <div class="mb-6 rounded-lg bg-emerald-50 p-4 border border-emerald-200 shadow-sm">
                    <div class="flex items-center justify-center gap-2 text-sm font-semibold text-emerald-700">
                        <i class="fa-solid fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- PENANGKAP PESAN ERROR --}}
            @if(session('error'))
                <div class="mb-6 rounded-lg bg-red-50 p-4 border border-red-200 shadow-sm">
                    <div class="flex items-center justify-center gap-2 text-sm font-semibold text-red-700">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}" class="space-y-5">
                @csrf
                
                <div>
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
                            autofocus
                        >
                    </div>
                    @error('EMAIL') 
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
                            placeholder="••••••••"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center items-center gap-2 py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all mt-6">
                    Masuk Sekarang <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-zinc-500 border-t border-zinc-100 pt-6">
                Warga desa yang belum bergabung? 
                <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition-all">
                    Daftar di sini
                </a>
            </div>

        </div>
    </div>
</div>
@endsection