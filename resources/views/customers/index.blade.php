@extends('layouts.app', ['pageTitle' => 'Daftar Pelanggan'])

@section('content')
<div class="space-y-6">
    <div class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm">
        <div class="px-4 py-5 sm:px-6 border-b border-zinc-200 flex items-center justify-between">
            <h3 class="text-base font-semibold leading-6 text-zinc-950">Pelanggan Terdaftar</h3>
            <input type="text" placeholder="Cari nama atau email..." class="rounded-md border border-zinc-300 px-3 py-1.5 text-sm focus:border-emerald-500 focus:outline-none">
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 text-left text-sm">
                <thead class="bg-zinc-50 text-xs font-semibold uppercase tracking-wider text-zinc-600">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Email (ID Utama)</th>
                        <th class="px-6 py-3">Alamat</th>
                        <th class="px-6 py-3">Tingkat Loyalitas</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 bg-white text-zinc-700">
                    {{-- Looping data menggunakan variabel dari Controller --}}
                    @foreach($customers as $item)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 font-semibold text-zinc-950">{{ $item->NAMA }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $item->EMAIL }}</td>
                        <td class="px-6 py-4 max-w-xs truncate">{{ $item->ALAMAT }}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            {{-- Mengambil nama tingkatan dari hasil leftJoin tabel LOYALITAS --}}
                            <span class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-semibold text-purple-700 border border-purple-200">
                                {{ $item->NAMA_LOYALITAS ?? 'Regular' }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            {{-- Tombol aksi dinamis yang membawa Email unik pelanggan --}}
                            <a href="{{ route('admin.customers.show', $item->EMAIL) }}" class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-xs font-semibold text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 hover:bg-zinc-50">
                                Riwayat & Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection