/*==============================================================*/
/* DBMS name:      Microsoft SQL Server 2017                    */
/* Description:    Menambahkan kolom detail tier loyalitas       */
/*                 ke tabel LOYALITAS yang sudah ada.            */
/* Created on:     24/06/2026                                   */
/*==============================================================*/

-- 1. Tambah kolom baru ke tabel LOYALITAS
ALTER TABLE LOYALITAS ADD
    MIN_AMOUNT   BIGINT       NOT NULL DEFAULT 0,
    MAX_AMOUNT   BIGINT       NULL,
    BENEFITS     VARCHAR(500) NULL,
    COLOR_CODE   VARCHAR(10)  NULL,
    BADGE_ICON   NVARCHAR(10) NULL;
GO

-- 2. Update data tier Bronze (ID_LOYALITAS = 1)
UPDATE LOYALITAS SET 
    MIN_AMOUNT = 0,
    MAX_AMOUNT = 999999,
    COLOR_CODE = '#CD7F32',
    BADGE_ICON = N'🥉',
    BENEFITS   = 'Akses katalog lengkap;Notifikasi promo reguler;Poin dasar setiap pembelian'
WHERE ID_LOYALITAS = 1;
GO

-- 3. Update data tier Silver (ID_LOYALITAS = 2)
UPDATE LOYALITAS SET 
    MIN_AMOUNT = 1000000,
    MAX_AMOUNT = 2499999,
    COLOR_CODE = '#C0C0C0',
    BADGE_ICON = N'🥈',
    BENEFITS   = 'Semua benefit Bronze;Diskon 5% untuk pembelian berikutnya;Akses early sale'
WHERE ID_LOYALITAS = 2;
GO

-- 4. Update data tier Gold (ID_LOYALITAS = 3)
UPDATE LOYALITAS SET 
    MIN_AMOUNT = 2500000,
    MAX_AMOUNT = 4999999,
    COLOR_CODE = '#FFD700',
    BADGE_ICON = N'🥇',
    BENEFITS   = 'Semua benefit Silver;Diskon 10% untuk pembelian berikutnya;Gratis ongkir;Priority customer service'
WHERE ID_LOYALITAS = 3;
GO

-- 5. Update data tier Platinum (ID_LOYALITAS = 4)
UPDATE LOYALITAS SET 
    MIN_AMOUNT = 5000000,
    MAX_AMOUNT = NULL,
    COLOR_CODE = '#E5E4E2',
    BADGE_ICON = N'💎',
    BENEFITS   = 'Semua benefit Gold;Diskon 15% untuk pembelian berikutnya;Gratis ongkir tanpa minimum;Akses eksklusif produk baru;Personal shopping assistant'
WHERE ID_LOYALITAS = 4;
GO
