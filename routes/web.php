<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
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

        // Pengguna
        // a. customer
        Route::get('/pengguna/customer', [CustomerController::class, 'index'])
            ->name('customer.index');

        // b. admin
        Route::get('/pengguna/admin', [AdminController::class, 'index'])
            ->name('admin.index');
    });


    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
