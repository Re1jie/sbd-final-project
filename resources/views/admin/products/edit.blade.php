@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
    <div class="border-b border-zinc-100 pb-4 mb-4">
        <h3 class="text-lg font-semibold text-zinc-950">Edit Produk</h3>
        <p class="text-sm text-zinc-500 mt-1">Ubah informasi data produk yang dipilih.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-600 border border-red-200">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->KODE_PRODUK) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT') 
        
        <div>
            <label class="block text-sm font-medium text-zinc-700">Kode Produk (Tidak dapat diubah)</label>
            <input type="text" disabled value="{{ $product->KODE_PRODUK }}" class="mt-2 w-full rounded-md border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-500 outline-none cursor-not-allowed">
        </div>

        <div>
            <label for="NAMA_PRODUK" class="block text-sm font-medium text-zinc-700">Nama Produk</label>
            <input id="NAMA_PRODUK" name="NAMA_PRODUK" type="text" required value="{{ old('NAMA_PRODUK', $product->NAMA_PRODUK) }}" class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="Contoh: Kemeja Linen">
        </div>

        <div>
            <label for="ID_KATEGORI" class="block text-sm font-medium text-zinc-700">Kategori</label>
            <select id="ID_KATEGORI" name="ID_KATEGORI" required class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->ID_KATEGORI }}" {{ old('ID_KATEGORI', $product->ID_KATEGORI) == $category->ID_KATEGORI ? 'selected' : '' }}>
                        {{ $category->NAMA_KATEGORI }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="HARGA" class="block text-sm font-medium text-zinc-700">Harga (Rp)</label>
                <input id="HARGA" name="HARGA" type="number" min="0" required value="{{ old('HARGA', $product->HARGA) }}" class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="0">
            </div>
            <div>
                <label for="STOK" class="block text-sm font-medium text-zinc-700">Stok Barang</label>
                <input id="STOK" name="STOK" type="number" min="0" required value="{{ old('STOK', $product->STOK) }}" class="mt-2 w-full rounded-md border border-zinc-300 px-3 py-2 text-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100" placeholder="0">
            </div>
        </div>

        <div>
            <label for="GAMBAR_PRODUK" class="block text-sm font-medium text-zinc-700">Gambar Produk</label>

            {{-- Preview gambar saat ini & gambar baru --}}
            <div class="mt-3 grid grid-cols-2 gap-4">
                {{-- Gambar Saat Ini --}}
                <div>
                    <p class="text-xs font-medium text-zinc-500 mb-2">Gambar saat ini:</p>
                    @if(!empty($product->GAMBAR_PRODUK))
                        <div class="relative group">
                            <img src="{{ asset($product->GAMBAR_PRODUK) }}" alt="Gambar Produk Saat Ini"
                                 class="h-40 w-full object-cover rounded-lg border border-zinc-200 shadow-sm bg-zinc-50">
                        </div>
                    @else
                        <div class="h-40 w-full rounded-lg border-2 border-dashed border-zinc-200 bg-zinc-50 flex flex-col items-center justify-center">
                            <svg class="h-8 w-8 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-xs text-zinc-400 mt-1">Belum ada gambar</p>
                        </div>
                    @endif
                </div>

                {{-- Preview Gambar Baru --}}
                <div>
                    <p class="text-xs font-medium text-zinc-500 mb-2">Gambar baru:</p>
                    <div id="newImagePreviewContainer" onclick="document.getElementById('GAMBAR_PRODUK').click()"
                         class="h-40 w-full rounded-lg border-2 border-dashed border-zinc-200 bg-zinc-50 flex flex-col items-center justify-center transition-all duration-200 cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/50">
                        <svg id="newImagePlaceholderIcon" class="h-8 w-8 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                        </svg>
                        <p id="newImagePlaceholderText" class="text-xs text-zinc-400 mt-1 text-center">Klik atau seret gambar ke sini</p>
                        <img id="newImagePreview" src="#" alt="Preview Gambar Baru"
                             class="hidden h-40 w-full object-cover rounded-lg">
                    </div>
                    {{-- File input tersembunyi --}}
                    <input id="GAMBAR_PRODUK" name="GAMBAR_PRODUK" type="file" accept="image/*" class="hidden">
                    <p class="text-xs text-zinc-400 mt-1">Format: JPG, JPEG, atau PNG. Maks 2MB.</p>
                    {{-- Tombol hapus preview --}}
                    <button type="button" id="removeNewImage" class="hidden mt-2 text-xs text-red-500 hover:text-red-700 font-medium transition">
                        ✕ Hapus gambar baru
                    </button>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-100 mt-6">
            <a href="{{ route('admin.products.index') }}" class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 hover:bg-zinc-50 transition">
                Batal
            </a>
            <button type="submit" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800 transition shadow-sm">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('GAMBAR_PRODUK');
        const previewContainer = document.getElementById('newImagePreviewContainer');
        const previewImg = document.getElementById('newImagePreview');
        const placeholderIcon = document.getElementById('newImagePlaceholderIcon');
        const placeholderText = document.getElementById('newImagePlaceholderText');
        const removeBtn = document.getElementById('removeNewImage');

        // Fungsi untuk menampilkan preview gambar
        function showPreview(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    previewImg.src = event.target.result;
                    previewImg.classList.remove('hidden');
                    placeholderIcon.classList.add('hidden');
                    placeholderText.classList.add('hidden');
                    previewContainer.classList.remove('border-dashed', 'border-zinc-200');
                    previewContainer.classList.add('border-solid', 'border-emerald-300');
                    removeBtn.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        // Fungsi untuk reset preview
        function resetPreview() {
            fileInput.value = '';
            previewImg.src = '#';
            previewImg.classList.add('hidden');
            placeholderIcon.classList.remove('hidden');
            placeholderText.classList.remove('hidden');
            previewContainer.classList.add('border-dashed', 'border-zinc-200');
            previewContainer.classList.remove('border-solid', 'border-emerald-300');
            removeBtn.classList.add('hidden');
        }

        // Event: pilih file via input
        fileInput.addEventListener('change', function (e) {
            showPreview(e.target.files[0]);
        });

        // Event: hapus preview
        removeBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            resetPreview();
        });

        // === Drag & Drop ===
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            previewContainer.addEventListener(eventName, function (e) {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        // Highlight saat drag masuk
        ['dragenter', 'dragover'].forEach(eventName => {
            previewContainer.addEventListener(eventName, function () {
                previewContainer.classList.add('border-emerald-400', 'bg-emerald-50', 'scale-[1.02]');
                previewContainer.classList.remove('border-zinc-200', 'bg-zinc-50');
            });
        });

        // Hilangkan highlight saat drag keluar
        ['dragleave', 'drop'].forEach(eventName => {
            previewContainer.addEventListener(eventName, function () {
                previewContainer.classList.remove('border-emerald-400', 'bg-emerald-50', 'scale-[1.02]');
                previewContainer.classList.add('border-zinc-200', 'bg-zinc-50');
            });
        });

        // Handle drop
        previewContainer.addEventListener('drop', function (e) {
            const droppedFile = e.dataTransfer.files[0];
            if (droppedFile && droppedFile.type.startsWith('image/')) {
                // Assign file ke input agar ikut tersubmit form
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(droppedFile);
                fileInput.files = dataTransfer.files;
                showPreview(droppedFile);
            }
        });
    });
</script>
@endpush