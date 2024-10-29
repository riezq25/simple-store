<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Transaksi

    // Data Master
    // a. Kategori
    // b. Produk
    // c. Supplier

    // Pengguna
    // a. customer
    Route::get('/pengguna/customer', [CustomerController::class, 'index'])
        ->name('customer.index');


    // b. admin

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
