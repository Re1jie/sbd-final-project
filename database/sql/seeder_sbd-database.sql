/*==============================================================*/
/* Seeder: SBD Database                                         */
/* DBMS name: Microsoft SQL Server 2017                         */
/*==============================================================*/

set nocount on
go

/*==============================================================*/
/* Master data: LOYALITAS                                       */
/*==============================================================*/
if not exists (select 1 from LOYALITAS where ID_LOYALITAS = 1)
   insert into LOYALITAS (ID_LOYALITAS, JENIS_TINGKATAN)
   values (1, 'Bronze')
go

if not exists (select 1 from LOYALITAS where ID_LOYALITAS = 2)
   insert into LOYALITAS (ID_LOYALITAS, JENIS_TINGKATAN)
   values (2, 'Silver')
go

if not exists (select 1 from LOYALITAS where ID_LOYALITAS = 3)
   insert into LOYALITAS (ID_LOYALITAS, JENIS_TINGKATAN)
   values (3, 'Gold')
go

if not exists (select 1 from LOYALITAS where ID_LOYALITAS = 4)
   insert into LOYALITAS (ID_LOYALITAS, JENIS_TINGKATAN)
   values (4, 'Platinum')
go

/*==============================================================*/
/* Master data: KATEGORI                                        */
/*==============================================================*/
if not exists (select 1 from KATEGORI where ID_KATEGORI = 1)
   insert into KATEGORI (ID_KATEGORI, NAMA_KATEGORI)
   values (1, 'Minuman')
go

if not exists (select 1 from KATEGORI where ID_KATEGORI = 2)
   insert into KATEGORI (ID_KATEGORI, NAMA_KATEGORI)
   values (2, 'Sembako')
go

if not exists (select 1 from KATEGORI where ID_KATEGORI = 3)
   insert into KATEGORI (ID_KATEGORI, NAMA_KATEGORI)
   values (3, 'Perawatan')
go

if not exists (select 1 from KATEGORI where ID_KATEGORI = 4)
   insert into KATEGORI (ID_KATEGORI, NAMA_KATEGORI)
   values (4, 'Alat Tulis')
go

if not exists (select 1 from KATEGORI where ID_KATEGORI = 5)
   insert into KATEGORI (ID_KATEGORI, NAMA_KATEGORI)
   values (5, 'Pakaian')
go

if not exists (select 1 from KATEGORI where ID_KATEGORI = 6)
   insert into KATEGORI (ID_KATEGORI, NAMA_KATEGORI)
   values (6, 'Aksesori')
go

/*==============================================================*/
/* Master data: STATUS_PESANAN                                  */
/*==============================================================*/
if not exists (select 1 from STATUS_PESANAN where ID_STATUS = 1)
   insert into STATUS_PESANAN (ID_STATUS, NAMA_STATUS)
   values (1, 'Menunggu Pembayaran')
go

if not exists (select 1 from STATUS_PESANAN where ID_STATUS = 2)
   insert into STATUS_PESANAN (ID_STATUS, NAMA_STATUS)
   values (2, 'Diproses')
go

if not exists (select 1 from STATUS_PESANAN where ID_STATUS = 3)
   insert into STATUS_PESANAN (ID_STATUS, NAMA_STATUS)
   values (3, 'Dikirim')
go

if not exists (select 1 from STATUS_PESANAN where ID_STATUS = 4)
   insert into STATUS_PESANAN (ID_STATUS, NAMA_STATUS)
   values (4, 'Selesai')
go

if not exists (select 1 from STATUS_PESANAN where ID_STATUS = 5)
   insert into STATUS_PESANAN (ID_STATUS, NAMA_STATUS)
   values (5, 'Dibatalkan')
go

/*==============================================================*/
/* Data: PELANGGAN                                              */
/*==============================================================*/
if not exists (select 1 from PELANGGAN where EMAIL = 'alice@example.com')
   insert into PELANGGAN (EMAIL, ID_LOYALITAS, NAMA, ALAMAT)
   values ('alice@example.com', 1, 'Alice Putri', 'Jl. Merpati No. 12, Bandung')
go

if not exists (select 1 from PELANGGAN where EMAIL = 'budi@example.com')
   insert into PELANGGAN (EMAIL, ID_LOYALITAS, NAMA, ALAMAT)
   values ('budi@example.com', 2, 'Budi Santoso', 'Jl. Kenanga No. 7, Jakarta')
go

if not exists (select 1 from PELANGGAN where EMAIL = 'citra@example.com')
   insert into PELANGGAN (EMAIL, ID_LOYALITAS, NAMA, ALAMAT)
   values ('citra@example.com', 3, 'Citra Lestari', 'Jl. Mawar No. 18, Surabaya')
go

if not exists (select 1 from PELANGGAN where EMAIL = 'dewi@example.com')
   insert into PELANGGAN (EMAIL, ID_LOYALITAS, NAMA, ALAMAT)
   values ('dewi@example.com', 4, 'Dewi Anggraini', 'Jl. Melati No. 5, Yogyakarta')
go

if not exists (select 1 from PELANGGAN where EMAIL = 'eko@example.com')
   insert into PELANGGAN (EMAIL, ID_LOYALITAS, NAMA, ALAMAT)
   values ('eko@example.com', 1, 'Eko Prasetyo', 'Jl. Cendana No. 9, Semarang')
go

if not exists (select 1 from PELANGGAN where EMAIL = 'farah@example.com')
   insert into PELANGGAN (EMAIL, ID_LOYALITAS, NAMA, ALAMAT)
   values ('farah@example.com', 2, 'Farah Nabila', 'Jl. Flamboyan No. 21, Bekasi')
go

if not exists (select 1 from PELANGGAN where EMAIL = 'gilang@example.com')
   insert into PELANGGAN (EMAIL, ID_LOYALITAS, NAMA, ALAMAT)
   values ('gilang@example.com', 3, 'Gilang Ramadhan', 'Jl. Dahlia No. 3, Depok')
go

if not exists (select 1 from PELANGGAN where EMAIL = 'hani@example.com')
   insert into PELANGGAN (EMAIL, ID_LOYALITAS, NAMA, ALAMAT)
   values ('hani@example.com', 1, 'Hani Wulandari', 'Jl. Anggrek No. 14, Bogor')
go

if not exists (select 1 from PELANGGAN where EMAIL = 'indra@example.com')
   insert into PELANGGAN (EMAIL, ID_LOYALITAS, NAMA, ALAMAT)
   values ('indra@example.com', 2, 'Indra Wijaya', 'Jl. Teratai No. 8, Tangerang')
go

if not exists (select 1 from PELANGGAN where EMAIL = 'jihan@example.com')
   insert into PELANGGAN (EMAIL, ID_LOYALITAS, NAMA, ALAMAT)
   values ('jihan@example.com', 4, 'Jihan Safitri', 'Jl. Kemuning No. 16, Malang')
go

/*==============================================================*/
/* Data: PRODUK                                                 */
/*==============================================================*/
if not exists (select 1 from PRODUK where KODE_PRODUK = 1001)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (1001, 1, 'Kopi Arabika Gayo 250gr', 120000, 35)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 1002)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (1002, 1, 'Kopi Robusta Lampung 250gr', 95000, 40)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 1003)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (1003, 1, 'Teh Hijau Jawa 100gr', 45000, 60)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 1004)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (1004, 1, 'Cokelat Bubuk Premium 200gr', 80000, 28)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 2001)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (2001, 2, 'Beras Pandan Wangi 5kg', 75000, 80)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 2002)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (2002, 2, 'Minyak Goreng 2L', 38000, 75)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 2003)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (2003, 2, 'Gula Pasir 1kg', 17000, 100)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 2004)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (2004, 2, 'Mie Instan Goreng', 3500, 250)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 3001)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (3001, 3, 'Sabun Mandi Herbal', 18000, 90)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 3002)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (3002, 3, 'Sampo Anti Ketombe', 32000, 55)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 3003)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (3003, 3, 'Pasta Gigi Mint', 21000, 70)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 3004)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (3004, 3, 'Tisu Wajah', 15000, 65)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 4001)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (4001, 4, 'Buku Tulis A5', 12000, 120)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 4002)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (4002, 4, 'Pulpen Gel Hitam', 8000, 140)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 4003)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (4003, 4, 'Map Plastik', 6000, 110)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 5001)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (5001, 5, 'Kaos Polos Katun', 85000, 45)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 5002)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (5002, 5, 'Celana Jeans Slim Fit', 210000, 22)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 5003)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (5003, 5, 'Jaket Hoodie', 175000, 18)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 6001)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (6001, 6, 'Botol Minum Stainless', 65000, 50)
go

if not exists (select 1 from PRODUK where KODE_PRODUK = 6002)
   insert into PRODUK (KODE_PRODUK, ID_KATEGORI, NAMA_PRODUK, HARGA, STOK)
   values (6002, 6, 'Payung Lipat', 55000, 38)
go

/*==============================================================*/
/* Data: PESANAN                                                */
/*==============================================================*/
if not exists (select 1 from PESANAN where ID_PESANAN = 5001)
   insert into PESANAN (ID_PESANAN, ID_STATUS, EMAIL, TOTAL_HARGA, ONGKIR, STATUS_PEMBAYARAN, TANGGAL_PESANAN)
   values (5001, 1, 'alice@example.com', 195000, 15000, 0, '2026-06-01T09:15:00')
go

if not exists (select 1 from PESANAN where ID_PESANAN = 5002)
   insert into PESANAN (ID_PESANAN, ID_STATUS, EMAIL, TOTAL_HARGA, ONGKIR, STATUS_PEMBAYARAN, TANGGAL_PESANAN)
   values (5002, 2, 'budi@example.com', 59000, 12000, 1, '2026-06-02T11:30:00')
go

if not exists (select 1 from PESANAN where ID_PESANAN = 5003)
   insert into PESANAN (ID_PESANAN, ID_STATUS, EMAIL, TOTAL_HARGA, ONGKIR, STATUS_PEMBAYARAN, TANGGAL_PESANAN)
   values (5003, 3, 'citra@example.com', 260000, 20000, 1, '2026-06-03T14:20:00')
go

if not exists (select 1 from PESANAN where ID_PESANAN = 5004)
   insert into PESANAN (ID_PESANAN, ID_STATUS, EMAIL, TOTAL_HARGA, ONGKIR, STATUS_PEMBAYARAN, TANGGAL_PESANAN)
   values (5004, 4, 'dewi@example.com', 140000, 10000, 1, '2026-06-04T08:45:00')
go

if not exists (select 1 from PESANAN where ID_PESANAN = 5005)
   insert into PESANAN (ID_PESANAN, ID_STATUS, EMAIL, TOTAL_HARGA, ONGKIR, STATUS_PEMBAYARAN, TANGGAL_PESANAN)
   values (5005, 5, 'eko@example.com', 43000, 0, 0, '2026-06-05T16:10:00')
go

if not exists (select 1 from PESANAN where ID_PESANAN = 5006)
   insert into PESANAN (ID_PESANAN, ID_STATUS, EMAIL, TOTAL_HARGA, ONGKIR, STATUS_PEMBAYARAN, TANGGAL_PESANAN)
   values (5006, 4, 'farah@example.com', 275000, 18000, 1, '2026-06-06T10:05:00')
go

if not exists (select 1 from PESANAN where ID_PESANAN = 5007)
   insert into PESANAN (ID_PESANAN, ID_STATUS, EMAIL, TOTAL_HARGA, ONGKIR, STATUS_PEMBAYARAN, TANGGAL_PESANAN)
   values (5007, 2, 'gilang@example.com', 86000, 11000, 1, '2026-06-07T13:25:00')
go

if not exists (select 1 from PESANAN where ID_PESANAN = 5008)
   insert into PESANAN (ID_PESANAN, ID_STATUS, EMAIL, TOTAL_HARGA, ONGKIR, STATUS_PEMBAYARAN, TANGGAL_PESANAN)
   values (5008, 1, 'hani@example.com', 135000, 15000, 0, '2026-06-08T19:40:00')
go

if not exists (select 1 from PESANAN where ID_PESANAN = 5009)
   insert into PESANAN (ID_PESANAN, ID_STATUS, EMAIL, TOTAL_HARGA, ONGKIR, STATUS_PEMBAYARAN, TANGGAL_PESANAN)
   values (5009, 3, 'indra@example.com', 95500, 13000, 1, '2026-06-09T07:55:00')
go

if not exists (select 1 from PESANAN where ID_PESANAN = 5010)
   insert into PESANAN (ID_PESANAN, ID_STATUS, EMAIL, TOTAL_HARGA, ONGKIR, STATUS_PEMBAYARAN, TANGGAL_PESANAN)
   values (5010, 4, 'jihan@example.com', 253000, 17000, 1, '2026-06-10T15:35:00')
go

/*==============================================================*/
/* Data: ORDERED_PRODUCT                                        */
/*==============================================================*/
if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5001 and KODE_PRODUK = 1001)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5001, 1001)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5001 and KODE_PRODUK = 2001)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5001, 2001)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5002 and KODE_PRODUK = 2002)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5002, 2002)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5002 and KODE_PRODUK = 3003)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5002, 3003)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5003 and KODE_PRODUK = 5001)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5003, 5001)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5003 and KODE_PRODUK = 5003)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5003, 5003)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5004 and KODE_PRODUK = 1002)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5004, 1002)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5004 and KODE_PRODUK = 1003)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5004, 1003)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5005 and KODE_PRODUK = 2003)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5005, 2003)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5005 and KODE_PRODUK = 4001)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5005, 4001)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5005 and KODE_PRODUK = 4002)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5005, 4002)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5005 and KODE_PRODUK = 4003)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5005, 4003)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5006 and KODE_PRODUK = 5002)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5006, 5002)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5006 and KODE_PRODUK = 6001)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5006, 6001)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5007 and KODE_PRODUK = 3001)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5007, 3001)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5007 and KODE_PRODUK = 3002)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5007, 3002)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5007 and KODE_PRODUK = 3003)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5007, 3003)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5007 and KODE_PRODUK = 3004)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5007, 3004)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5008 and KODE_PRODUK = 1004)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5008, 1004)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5008 and KODE_PRODUK = 6002)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5008, 6002)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5009 and KODE_PRODUK = 2001)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5009, 2001)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5009 and KODE_PRODUK = 2003)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5009, 2003)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5009 and KODE_PRODUK = 2004)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5009, 2004)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5010 and KODE_PRODUK = 1001)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5010, 1001)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5010 and KODE_PRODUK = 1002)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5010, 1002)
go

if not exists (select 1 from ORDERED_PRODUCT where ID_PESANAN = 5010 and KODE_PRODUK = 2002)
   insert into ORDERED_PRODUCT (ID_PESANAN, KODE_PRODUK)
   values (5010, 2002)
go
