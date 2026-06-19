<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;

// Halaman Utama Admin (Dashboard)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Group Route untuk Semua Fitur Admin
Route::prefix('admin')->name('admin.')->group(function () {
    
    // ==========================================
    // MODUL PESANAN (Anggota 2)
    // ==========================================
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index'); // Jadi: admin.orders.index
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show'); // Jadi: admin.orders.show
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus'); // Jadi: admin.orders.updateStatus

    // ==========================================
    // MODUL PELANGGAN (Anggota 2)
    // ==========================================
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index'); // Jadi: admin.customers.index
    Route::get('/customers/{email}', [CustomerController::class, 'show'])->name('customers.show'); // Jadi: admin.customers.show

    // ==========================================
    // CRUD Produk (Anggota Lain)
    // ==========================================
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // ==========================================
    // CRUD Kategori (Anggota Lain)
    // ==========================================
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});