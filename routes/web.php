<?php

use Illuminate\Support\Facades\Route;

// Import Controller Sisi Admin
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;

// Import Controller Sisi Client / Pelanggan
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| 1. RUTEL KLIEN / PELANGGAN (Fitur Belanja Anggota 4)
|--------------------------------------------------------------------------
*/

// Katalog & Detail Produk
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/product/{id}', [CatalogController::class, 'show'])->name('catalog.show');

// Pengelolaan Keranjang Belanja (Session-based)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Alur Checkout Pelanggan
Route::middleware([])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});


/*
|--------------------------------------------------------------------------
| 2. RUTE ADMIN (Dashboard & Back-Office Toko)
|--------------------------------------------------------------------------
*/

// Halaman Utama Admin (Dashboard)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Group Route untuk Semua Fitur Manajemen Admin
Route::prefix('admin')->name('admin.')->group(function () {
    
    // ==========================================
    // MODUL PESANAN (Anggota 2)
    // ==========================================
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index'); 
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show'); 
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus'); 

    // ==========================================
    // MODUL PELANGGAN (Anggota 2)
    // ==========================================
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index'); 
    Route::get('/customers/{email}', [CustomerController::class, 'show'])->name('customers.show'); 

    // ==========================================
    // CRUD PRODUK (Anggota 1)
    // ==========================================
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // ==========================================
    // CRUD KATEGORI (Anggota 1)
    // ==========================================
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});