<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Transaksi


    // admin only
    Route::middleware('role:admin')->group(function () {
        // Data Master
        // a. Kategori
        // b. Produk

        // c. Supplier
        Route::get('/data-master/supplier', [SupplierController::class, 'index'])
            ->name('supplier.index');
        Route::get('/data-master/supplier/create', [SupplierController::class, 'create'])
            ->name('supplier.create');
        Route::post('/data-master/supplier/store', [SupplierController::class, 'store'])
            ->name('supplier.store');
        Route::get('/data-master/supplier/{id}/edit', [SupplierController::class, 'edit'])
            ->name('supplier.edit');
        Route::put('/data-master/supplier/{id}/update', [SupplierController::class, 'update'])
            ->name('supplier.update');
        Route::delete('/data-master/supplier/{id}', [SupplierController::class, 'destroy'])
            ->name('supplier.destroy');

        // Pengguna
        // a. customer
        Route::get('/pengguna/customer', [CustomerController::class, 'index'])
            ->name('customer.index');

        // b. admin
        Route::get('/pengguna/admin', [AdminController::class, 'index'])
            ->name('admin.index');
        Route::get('/pengguna/admin/create', [AdminController::class, 'create'])
            ->name('admin.create');
        Route::post('/pengguna/admin/store', [AdminController::class, 'store'])
            ->name('admin.store');
        Route::get('/pengguna/admin/{id}/edit', [AdminController::class, 'edit'])
            ->name('admin.edit');
        Route::put('/pengguna/admin/{id}/update', [AdminController::class, 'update'])
            ->name('admin.update');
        Route::delete('/pengguna/admin/{id}', [AdminController::class, 'destroy'])
            ->name('admin.destroy');
    });


    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
