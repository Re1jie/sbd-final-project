/*==============================================================*/
/* DBMS name:      Microsoft SQL Server 2017                    */
/* Created on:     18/06/2026 16:30:03                          */
/*==============================================================*/


if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('ORDERED_PRODUCT') and o.name = 'FK_ORDERED__ORDERED_P_PESANAN')
alter table ORDERED_PRODUCT
   drop constraint FK_ORDERED__ORDERED_P_PESANAN
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('ORDERED_PRODUCT') and o.name = 'FK_ORDERED__ORDERED_P_PRODUK')
alter table ORDERED_PRODUCT
   drop constraint FK_ORDERED__ORDERED_P_PRODUK
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('PELANGGAN') and o.name = 'FK_PELANGGA_MENDAPATK_LOYALITA')
alter table PELANGGAN
   drop constraint FK_PELANGGA_MENDAPATK_LOYALITA
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('PESANAN') and o.name = 'FK_PESANAN_MEMESAN_PELANGGA')
alter table PESANAN
   drop constraint FK_PESANAN_MEMESAN_PELANGGA
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('PESANAN') and o.name = 'FK_PESANAN_MEMPERBAR_STATUS_P')
alter table PESANAN
   drop constraint FK_PESANAN_MEMPERBAR_STATUS_P
go

if exists (select 1
   from sys.sysreferences r join sys.sysobjects o on (o.id = r.constid and o.type = 'F')
   where r.fkeyid = object_id('PRODUK') and o.name = 'FK_PRODUK_MEMILIKI_KATEGORI')
alter table PRODUK
   drop constraint FK_PRODUK_MEMILIKI_KATEGORI
go

if exists (select 1
            from  sysobjects
           where  id = object_id('KATEGORI')
            and   type = 'U')
   drop table KATEGORI
go

if exists (select 1
            from  sysobjects
           where  id = object_id('LOYALITAS')
            and   type = 'U')
   drop table LOYALITAS
go

if exists (select 1
            from  sysindexes
           where  id    = object_id('ORDERED_PRODUCT')
            and   name  = 'ORDERED_PRODUCT2_FK'
            and   indid > 0
            and   indid < 255)
   drop index ORDERED_PRODUCT.ORDERED_PRODUCT2_FK
go

if exists (select 1
            from  sysindexes
           where  id    = object_id('ORDERED_PRODUCT')
            and   name  = 'ORDERED_PRODUCT_FK'
            and   indid > 0
            and   indid < 255)
   drop index ORDERED_PRODUCT.ORDERED_PRODUCT_FK
go

if exists (select 1
            from  sysobjects
           where  id = object_id('ORDERED_PRODUCT')
            and   type = 'U')
   drop table ORDERED_PRODUCT
go

if exists (select 1
            from  sysindexes
           where  id    = object_id('PELANGGAN')
            and   name  = 'MENDAPATKAN_STATUS_FK'
            and   indid > 0
            and   indid < 255)
   drop index PELANGGAN.MENDAPATKAN_STATUS_FK
go

if exists (select 1
            from  sysobjects
           where  id = object_id('PELANGGAN')
            and   type = 'U')
   drop table PELANGGAN
go

if exists (select 1
            from  sysindexes
           where  id    = object_id('PESANAN')
            and   name  = 'MEMPERBARUI_FK'
            and   indid > 0
            and   indid < 255)
   drop index PESANAN.MEMPERBARUI_FK
go

if exists (select 1
            from  sysindexes
           where  id    = object_id('PESANAN')
            and   name  = 'MEMESAN_FK'
            and   indid > 0
            and   indid < 255)
   drop index PESANAN.MEMESAN_FK
go

if exists (select 1
            from  sysobjects
           where  id = object_id('PESANAN')
            and   type = 'U')
   drop table PESANAN
go

if exists (select 1
            from  sysindexes
           where  id    = object_id('PRODUK')
            and   name  = 'MEMILIKI_FK'
            and   indid > 0
            and   indid < 255)
   drop index PRODUK.MEMILIKI_FK
go

if exists (select 1
            from  sysobjects
           where  id = object_id('PRODUK')
            and   type = 'U')
   drop table PRODUK
go

if exists (select 1
            from  sysobjects
           where  id = object_id('STATUS_PESANAN')
            and   type = 'U')
   drop table STATUS_PESANAN
go

/*==============================================================*/
/* Table: KATEGORI                                              */
/*==============================================================*/
create table KATEGORI (
   ID_KATEGORI          bigint               not null,
   NAMA_KATEGORI        varchar(50)          null,
   constraint PK_KATEGORI primary key (ID_KATEGORI)
)
go

/*==============================================================*/
/* Table: LOYALITAS                                             */
/*==============================================================*/
create table LOYALITAS (
   ID_LOYALITAS         bigint               not null,
   JENIS_TINGKATAN      char(10)             null,
   constraint PK_LOYALITAS primary key (ID_LOYALITAS)
)
go

/*==============================================================*/
/* Table: ORDERED_PRODUCT                                       */
/*==============================================================*/
create table ORDERED_PRODUCT (
   ID_PESANAN           bigint               not null,
   KODE_PRODUK          bigint               not null,
   constraint PK_ORDERED_PRODUCT primary key (ID_PESANAN, KODE_PRODUK)
)
go

/*==============================================================*/
/* Index: ORDERED_PRODUCT_FK                                    */
/*==============================================================*/




create nonclustered index ORDERED_PRODUCT_FK on ORDERED_PRODUCT (ID_PESANAN ASC)
go

/*==============================================================*/
/* Index: ORDERED_PRODUCT2_FK                                   */
/*==============================================================*/




create nonclustered index ORDERED_PRODUCT2_FK on ORDERED_PRODUCT (KODE_PRODUK ASC)
go

/*==============================================================*/
/* Table: PELANGGAN                                             */
/*==============================================================*/
create table PELANGGAN (
   EMAIL                varchar(50)          not null,
   ID_LOYALITAS         bigint               null,
   NAMA                 varchar(50)          null,
   ALAMAT               varchar(100)         null,
   constraint PK_PELANGGAN primary key (EMAIL)
)
go

/*==============================================================*/
/* Index: MENDAPATKAN_STATUS_FK                                 */
/*==============================================================*/




create nonclustered index MENDAPATKAN_STATUS_FK on PELANGGAN (ID_LOYALITAS ASC)
go

/*==============================================================*/
/* Table: PESANAN                                               */
/*==============================================================*/
create table PESANAN (
   ID_PESANAN           bigint               not null,
   ID_STATUS            bigint               not null,
   EMAIL                varchar(50)          not null,
   TOTAL_HARGA          int                  null,
   ONGKIR               int                  null,
   STATUS_PEMBAYARAN    bit                  null,
   TANGGAL_PESANAN      datetime             null,
   constraint PK_PESANAN primary key (ID_PESANAN)
)
go

/*==============================================================*/
/* Index: MEMESAN_FK                                            */
/*==============================================================*/




create nonclustered index MEMESAN_FK on PESANAN (EMAIL ASC)
go

/*==============================================================*/
/* Index: MEMPERBARUI_FK                                        */
/*==============================================================*/




create nonclustered index MEMPERBARUI_FK on PESANAN (ID_STATUS ASC)
go

/*==============================================================*/
/* Table: PRODUK                                                */
/*==============================================================*/
create table PRODUK (
   KODE_PRODUK          bigint               not null,
   ID_KATEGORI          bigint               null,
   NAMA_PRODUK          varchar(100)         null,
   HARGA                bigint               null,
   STOK                 int                  null,
   constraint PK_PRODUK primary key (KODE_PRODUK)
)
go

/*==============================================================*/
/* Index: MEMILIKI_FK                                           */
/*==============================================================*/




create nonclustered index MEMILIKI_FK on PRODUK (ID_KATEGORI ASC)
go

/*==============================================================*/
/* Table: STATUS_PESANAN                                        */
/*==============================================================*/
create table STATUS_PESANAN (
   ID_STATUS            bigint               not null,
   NAMA_STATUS          varchar(50)          null,
   constraint PK_STATUS_PESANAN primary key (ID_STATUS)
)
go

alter table ORDERED_PRODUCT
   add constraint FK_ORDERED__ORDERED_P_PESANAN foreign key (ID_PESANAN)
      references PESANAN (ID_PESANAN)
go

alter table ORDERED_PRODUCT
   add constraint FK_ORDERED__ORDERED_P_PRODUK foreign key (KODE_PRODUK)
      references PRODUK (KODE_PRODUK)
go

alter table PELANGGAN
   add constraint FK_PELANGGA_MENDAPATK_LOYALITA foreign key (ID_LOYALITAS)
      references LOYALITAS (ID_LOYALITAS)
go

alter table PESANAN
   add constraint FK_PESANAN_MEMESAN_PELANGGA foreign key (EMAIL)
      references PELANGGAN (EMAIL)
go

alter table PESANAN
   add constraint FK_PESANAN_MEMPERBAR_STATUS_P foreign key (ID_STATUS)
      references STATUS_PESANAN (ID_STATUS)
go

alter table PRODUK
   add constraint FK_PRODUK_MEMILIKI_KATEGORI foreign key (ID_KATEGORI)
      references KATEGORI (ID_KATEGORI)
go

