# Instruksi Pembagian Tugas Tim

## Proyek

Proyek ini adalah aplikasi **Sistem Manajemen Toko Online** untuk toko online kecil. Aplikasi harus mampu mengelola data produk, kategori, pelanggan, pesanan, stok, keranjang belanja, checkout, dan riwayat pembelian pelanggan.

Dokumen ini disusun berdasarkan `requirements.pdf` dan rencana awal fitur yang terdiri dari:

- Dashboard Admin
- Page Produk
- Form input produk
- Form input kategori
- Page detail pelanggan
- Login/Register client
- Page belanja
- Keranjang
- Checkout

Karena tim terdiri dari 5 orang, pembagian tugas dibuat agar beban tiap anggota relatif seimbang, tetapi Project Manager tetap memiliki porsi teknis yang lebih berbobot melalui tanggung jawab arsitektur, database, integrasi, dan business logic utama.

## Ringkasan Requirement Utama

Berikut aturan bisnis utama yang wajib dipenuhi:

1. Setiap produk memiliki kode unik, nama produk, kategori, harga, dan stok tersedia.
2. Pelanggan harus terdaftar dengan nama, alamat pengiriman, dan email untuk bisa melakukan pesanan.
3. Satu pesanan hanya bisa dilakukan oleh satu pelanggan.
4. Dalam satu pesanan, pelanggan bisa membeli lebih dari satu jenis produk dengan jumlah berbeda.
5. Sistem harus mencatat total harga pesanan dan biaya ongkir jika ada.
6. Status pesanan harus selalu diperbarui: diproses, dikirim, selesai, atau dibatalkan.
7. Pesanan yang belum dibayar dalam 24 jam otomatis dibatalkan.
8. Stok produk harus berkurang sesuai jumlah pesanan yang terkonfirmasi.
9. Jika stok habis, produk harus ditandai sebagai "Habis" dan tidak bisa dipesan sampai stok ditambah lagi.
10. Toko ingin melacak riwayat pembelian tiap pelanggan untuk memberikan promo khusus pelanggan loyal.

## Struktur Modul Aplikasi

### Modul Admin

- Dashboard Admin
- Manajemen Produk
- Manajemen Kategori
- Manajemen Stok
- Manajemen Pesanan
- Detail Pesanan
- Manajemen Pelanggan
- Detail Pelanggan
- Riwayat Pembelian Pelanggan
- Promo atau Loyal Customer
- Laporan Penjualan

### Modul Client

- Register
- Login
- Katalog Produk
- Detail Produk
- Keranjang
- Checkout
- Riwayat Pesanan
- Detail Pesanan
- Profil Pelanggan

## Pembagian Tugas Tim

## 1. Project Manager / Tech Lead

### Fokus Utama

Project Manager bertanggung jawab sebagai pengarah proyek sekaligus pemegang bagian teknis inti. Peran ini tidak hanya membagi pekerjaan, tetapi juga memastikan arsitektur, database, relasi data, dan flow transaksi berjalan sesuai requirement.

### Tanggung Jawab Utama

- Menentukan struktur arsitektur aplikasi.
- Membuat rancangan ERD.
- Menentukan struktur tabel database.
- Membuat migration utama.
- Membuat model dan relasi utama.
- Menentukan standar penamaan route, controller, model, migration, dan view.
- Membuat atau mengarahkan flow checkout.
- Mengatur business logic stok produk.
- Mengatur business logic pesanan.
- Mengatur auto-cancel pesanan yang belum dibayar dalam 24 jam.
- Melakukan integrasi akhir antar modul.
- Melakukan code review.
- Mengatur timeline pengerjaan.
- Memastikan seluruh anggota bekerja sesuai scope.

### Modul yang Dipegang

- Database design
- Relasi model
- Flow checkout inti
- Order processing
- Stock handling
- Auto-cancel unpaid order
- Integrasi modul
- Final testing

### Detail Teknis yang Dikerjakan

#### Database dan ERD

Minimal tabel yang perlu disiapkan:

- `users`
- `categories`
- `products`
- `orders`
- `order_items`
- `carts` atau mekanisme keranjang lain
- `cart_items` jika keranjang disimpan di database
- `promos` jika promo digunakan
- `customer_promos` jika promo diberikan ke pelanggan tertentu

#### Relasi Model

Relasi utama yang perlu dibuat:

- `Category hasMany Product`
- `Product belongsTo Category`
- `User hasMany Order`
- `Order belongsTo User`
- `Order hasMany OrderItem`
- `OrderItem belongsTo Order`
- `OrderItem belongsTo Product`

#### Business Logic Pesanan

Project Manager wajib memastikan:

- Pesanan hanya bisa dibuat oleh pelanggan yang sudah login.
- Satu pesanan hanya dimiliki oleh satu pelanggan.
- Satu pesanan dapat memiliki banyak item produk.
- Total harga dihitung dari subtotal tiap item.
- Ongkir dicatat dalam pesanan.
- Total akhir dihitung dari subtotal ditambah ongkir.
- Status pesanan menggunakan nilai yang konsisten.
- Pesanan belum dibayar lebih dari 24 jam otomatis dibatalkan.
- Stok hanya berkurang ketika pesanan sudah terkonfirmasi sesuai aturan yang disepakati.
- Produk dengan stok 0 otomatis berstatus "Habis".
- Produk habis tidak bisa ditambahkan ke keranjang atau dipesan.

### Deliverable

- ERD.
- Migration utama.
- Model utama dan relasinya.
- Dokumentasi struktur database.
- Flow checkout.
- Logic pengurangan stok.
- Logic auto-cancel order.
- Review dan integrasi akhir.

## 2. Anggota 1 - Modul Produk dan Kategori

### Fokus Utama

Anggota 1 bertanggung jawab pada seluruh pengelolaan produk dan kategori di sisi admin. Modul ini menjadi sumber data utama yang akan digunakan oleh katalog client, keranjang, checkout, dan laporan.

### Tanggung Jawab Utama

- Membuat CRUD kategori.
- Membuat CRUD produk.
- Membuat form input produk.
- Membuat form edit produk.
- Membuat form input kategori.
- Membuat form edit kategori.
- Menampilkan daftar produk.
- Menampilkan daftar kategori.
- Menangani validasi kode produk unik.
- Menangani validasi harga dan stok.
- Menampilkan status produk tersedia atau habis.
- Menyiapkan data produk agar bisa digunakan di halaman belanja client.

### Field Produk yang Wajib Ada

- Kode produk
- Nama produk
- Kategori
- Harga
- Stok
- Status produk
- Foto produk jika digunakan
- Deskripsi produk jika digunakan

### Field Kategori yang Wajib Ada

- Nama kategori
- Deskripsi kategori jika diperlukan

### Validasi

- Kode produk wajib unik.
- Nama produk wajib diisi.
- Produk wajib memiliki kategori.
- Harga tidak boleh negatif.
- Stok tidak boleh negatif.
- Produk dengan stok 0 harus ditandai sebagai "Habis".

### Halaman yang Dikerjakan

- Admin daftar produk
- Admin tambah produk
- Admin edit produk
- Admin detail produk jika diperlukan
- Admin daftar kategori
- Admin tambah kategori
- Admin edit kategori

### Deliverable

- CRUD produk selesai.
- CRUD kategori selesai.
- Validasi produk dan kategori selesai.
- Status stok tampil dengan benar.
- Produk siap digunakan oleh modul katalog client.

## 3. Anggota 2 - Modul Pesanan dan Pelanggan Admin

### Fokus Utama

Anggota 2 bertanggung jawab pada pengelolaan pesanan dan pelanggan dari sisi admin. Modul ini penting karena admin perlu memantau transaksi, memperbarui status pesanan, melihat detail pelanggan, dan membaca riwayat pembelian.

### Tanggung Jawab Utama

- Membuat halaman daftar pesanan admin.
- Membuat halaman detail pesanan admin.
- Menampilkan produk-produk dalam satu pesanan.
- Menampilkan jumlah tiap produk dalam pesanan.
- Menampilkan subtotal, ongkir, dan total harga.
- Membuat fitur update status pesanan.
- Membuat halaman daftar pelanggan.
- Membuat halaman detail pelanggan.
- Menampilkan riwayat pembelian tiap pelanggan.
- Menampilkan pelanggan loyal berdasarkan jumlah atau total transaksi.

### Status Pesanan

Status pesanan yang harus digunakan:

- `diproses`
- `dikirim`
- `selesai`
- `dibatalkan`

Jika sistem pembayaran dibuat, status tambahan dapat dipertimbangkan:

- `menunggu_pembayaran`
- `dibayar`

Namun penggunaan status tambahan harus disepakati dengan Project Manager agar tidak mengganggu requirement utama.

### Halaman yang Dikerjakan

- Admin daftar pesanan
- Admin detail pesanan
- Admin update status pesanan
- Admin daftar pelanggan
- Admin detail pelanggan
- Admin riwayat pembelian pelanggan
- Admin daftar pelanggan loyal jika waktu mencukupi

### Data yang Harus Ditampilkan di Detail Pesanan

- Nomor pesanan
- Nama pelanggan
- Email pelanggan
- Alamat pengiriman
- Daftar produk
- Harga produk saat dipesan
- Jumlah produk
- Subtotal tiap produk
- Biaya ongkir
- Total pesanan
- Status pesanan
- Tanggal pesanan

### Deliverable

- Halaman pesanan admin selesai.
- Detail pesanan admin selesai.
- Update status pesanan selesai.
- Halaman pelanggan selesai.
- Riwayat pembelian pelanggan tampil.

## 4. Anggota 3 - Modul Auth, Role, dan Profil Client

### Fokus Utama

Anggota 3 bertanggung jawab pada autentikasi, registrasi pelanggan, pembagian role, proteksi halaman, dan profil pelanggan. Modul ini menjadi fondasi agar hanya pelanggan terdaftar yang bisa melakukan pemesanan.

### Tanggung Jawab Utama

- Membuat halaman register.
- Membuat halaman login.
- Membuat logout.
- Mengatur role admin dan client.
- Membuat middleware akses admin.
- Membuat middleware akses client.
- Membuat halaman profil pelanggan.
- Membuat fitur edit profil pelanggan.
- Membuat fitur edit alamat pengiriman.
- Memastikan pelanggan memiliki nama, email, dan alamat pengiriman.

### Data Pelanggan yang Wajib Ada

- Nama
- Email
- Password
- Alamat pengiriman

### Halaman yang Dikerjakan

- Register client
- Login client
- Logout
- Profil pelanggan
- Edit profil pelanggan
- Edit alamat pengiriman

### Aturan Akses

- Admin hanya boleh masuk ke halaman admin.
- Client hanya boleh masuk ke halaman client.
- Checkout hanya boleh dilakukan oleh client yang sudah login.
- Riwayat pesanan hanya menampilkan pesanan milik client tersebut.
- Profil hanya bisa dilihat dan diedit oleh pemilik akun.

### Deliverable

- Register selesai.
- Login selesai.
- Logout selesai.
- Role admin dan client berjalan.
- Middleware akses berjalan.
- Profil dan alamat pengiriman bisa diedit.

## 5. Anggota 4 - Modul Belanja, Keranjang, dan Checkout Client

### Fokus Utama

Anggota 4 bertanggung jawab pada pengalaman belanja client, mulai dari melihat produk, memasukkan produk ke keranjang, mengubah jumlah barang, hingga checkout.

### Tanggung Jawab Utama

- Membuat halaman katalog produk.
- Membuat halaman detail produk.
- Membuat fitur tambah ke keranjang.
- Membuat halaman keranjang.
- Membuat fitur update jumlah produk di keranjang.
- Membuat fitur hapus produk dari keranjang.
- Membuat halaman checkout.
- Menampilkan ringkasan pesanan.
- Menampilkan subtotal, ongkir, dan total harga.
- Mencegah produk habis masuk ke keranjang.
- Mencegah checkout jika stok tidak cukup.

### Halaman yang Dikerjakan

- Katalog produk
- Detail produk
- Keranjang
- Checkout
- Konfirmasi checkout

### Fitur Katalog

- Menampilkan daftar produk.
- Menampilkan nama produk.
- Menampilkan harga produk.
- Menampilkan kategori produk.
- Menampilkan stok atau status produk.
- Menampilkan tombol tambah ke keranjang.
- Tombol tambah ke keranjang harus nonaktif jika produk habis.

### Fitur Keranjang

- Menampilkan produk yang dipilih.
- Menampilkan jumlah tiap produk.
- Menampilkan harga satuan.
- Menampilkan subtotal.
- Mengubah jumlah produk.
- Menghapus produk.
- Menampilkan total sementara.

### Fitur Checkout

- Menampilkan ringkasan keranjang.
- Menampilkan alamat pengiriman pelanggan.
- Menampilkan biaya ongkir.
- Menampilkan total akhir.
- Membuat pesanan baru.
- Mengosongkan keranjang setelah checkout berhasil jika flow sudah disepakati.

### Deliverable

- Katalog produk selesai.
- Detail produk selesai.
- Keranjang selesai.
- Checkout selesai.
- Validasi stok pada keranjang dan checkout selesai.

## Dependency Antar Anggota

### Dependency Utama

- Anggota 1 membutuhkan struktur tabel dari Project Manager.
- Anggota 4 membutuhkan data produk dari Anggota 1.
- Anggota 4 membutuhkan auth client dari Anggota 3.
- Anggota 2 membutuhkan struktur `orders` dan `order_items` dari Project Manager.
- Anggota 2 membutuhkan data order yang dibuat oleh modul checkout Anggota 4.
- Anggota 3 membutuhkan keputusan struktur `users` dan role dari Project Manager.
- Project Manager membutuhkan hasil semua modul untuk integrasi akhir.

### Urutan Pengerjaan Disarankan

1. Project Manager membuat ERD, migration dasar, model, dan relasi utama.
2. Anggota 3 mengerjakan auth, role, dan middleware.
3. Anggota 1 mengerjakan produk dan kategori.
4. Anggota 4 mengerjakan katalog dan keranjang setelah produk tersedia.
5. Project Manager dan Anggota 4 mengintegrasikan checkout ke `orders` dan `order_items`.
6. Anggota 2 mengerjakan pesanan admin dan pelanggan setelah struktur order siap.
7. Project Manager mengerjakan auto-cancel 24 jam, validasi stok final, dan integrasi akhir.
8. Semua anggota melakukan testing modul masing-masing.
9. Project Manager melakukan final review dan merge.

## Standar Teknis Tim

### Penamaan

- Nama tabel menggunakan bentuk jamak, contoh: `products`, `categories`, `orders`.
- Nama model menggunakan singular PascalCase, contoh: `Product`, `Category`, `Order`.
- Nama controller menggunakan PascalCase dan akhiran `Controller`, contoh: `ProductController`.
- Nama route menggunakan pola yang konsisten, contoh: `admin.products.index`.

### Validasi Umum

- Semua input form wajib divalidasi.
- Harga tidak boleh negatif.
- Stok tidak boleh negatif.
- Email pelanggan harus unik.
- Produk tidak boleh dipesan jika stok habis.
- Jumlah checkout tidak boleh melebihi stok tersedia.

### Aturan Git

- Setiap anggota sebaiknya bekerja pada branch masing-masing.
- Nama branch disarankan:
  - `feature/admin-products`
  - `feature/admin-orders`
  - `feature/auth-profile`
  - `feature/client-shopping`
  - `feature/core-order-flow`
- Commit harus menjelaskan perubahan dengan jelas.
- Pull request atau merge dilakukan setelah modul dites.
- Project Manager melakukan review sebelum merge ke branch utama.

## Checklist Integrasi Akhir

### Produk dan Kategori

- Produk bisa ditambah.
- Produk bisa diedit.
- Produk bisa dihapus jika belum digunakan transaksi atau sesuai aturan sistem.
- Kategori bisa ditambah.
- Kategori bisa diedit.
- Kode produk unik.
- Stok 0 tampil sebagai "Habis".

### Auth dan Pelanggan

- Client bisa register.
- Client bisa login.
- Client bisa logout.
- Admin tidak tercampur dengan client.
- Client bisa mengedit profil.
- Client memiliki alamat pengiriman.

### Belanja dan Checkout

- Produk tampil di katalog.
- Produk habis tidak bisa dipesan.
- Produk bisa masuk keranjang.
- Jumlah produk di keranjang bisa diubah.
- Checkout membuat data pesanan.
- Checkout membuat data item pesanan.
- Total harga benar.
- Ongkir tercatat.

### Pesanan dan Stok

- Pesanan memiliki pelanggan.
- Pesanan memiliki banyak item.
- Status pesanan bisa diperbarui.
- Stok berkurang setelah pesanan terkonfirmasi sesuai aturan.
- Stok tidak boleh minus.
- Pesanan belum dibayar 24 jam otomatis dibatalkan.
- Pesanan dibatalkan tidak boleh mengurangi stok jika belum terkonfirmasi.

### Pelanggan Loyal dan Riwayat

- Riwayat pembelian pelanggan tampil.
- Admin bisa melihat total transaksi pelanggan.
- Admin bisa mengidentifikasi pelanggan loyal.
- Promo pelanggan loyal bisa ditambahkan jika waktu mencukupi.

## Prioritas Pengerjaan

### Prioritas Wajib

- Auth client dan admin.
- CRUD produk.
- CRUD kategori.
- Katalog produk.
- Keranjang.
- Checkout.
- Pesanan dan detail pesanan.
- Update status pesanan.
- Pengurangan stok.
- Status produk habis.
- Riwayat pembelian pelanggan.

### Prioritas Tambahan

- Promo pelanggan loyal.
- Laporan penjualan.
- Produk terlaris.
- Filter produk berdasarkan kategori.
- Pencarian produk.
- Upload gambar produk.
- Dashboard statistik admin.

## Catatan Project Manager

Project Manager memiliki porsi teknis paling besar karena bertanggung jawab terhadap bagian yang menjadi inti aplikasi, yaitu database, relasi data, flow pesanan, stok, dan integrasi akhir. Anggota lain tetap memiliki beban yang seimbang karena masing-masing memegang modul dengan halaman, validasi, dan fitur yang jelas.

Target utama proyek bukan hanya membuat halaman tampil, tetapi memastikan alur toko online berjalan dari awal sampai akhir:

1. Pelanggan register dan login.
2. Admin menginput kategori dan produk.
3. Client melihat produk.
4. Client memasukkan produk ke keranjang.
5. Client melakukan checkout.
6. Sistem membuat pesanan.
7. Admin memproses pesanan.
8. Stok produk diperbarui.
9. Client dan admin bisa melihat riwayat pesanan.
10. Data riwayat bisa digunakan untuk menentukan pelanggan loyal.
