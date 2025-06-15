<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\WaiterController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginWeb']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'registerWeb']);


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logoutWeb'])->name('logout');
    
    Route::middleware('role:admin')->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/transaksi', [AdminController::class, 'indexTransaksi'])->name('transaksi');
            Route::get('/kasir', [AdminController::class, 'indexKasir'])->name('kasir.index');
            Route::get('/kasir/create', [AdminController::class, 'createKasir'])->name('kasir.create');
            Route::post('/kasir', [AdminController::class, 'storeKasir'])->name('kasir.store');
            Route::delete('/kasir/{id}', [AdminController::class, 'destroyKasir'])->name('kasir.destroy');
            Route::get('/waiter', [AdminController::class, 'indexWaiter'])->name('waiter.index');
            Route::get('/waiter/create', [AdminController::class, 'createWaiter'])->name('waiter.create');
            Route::post('/waiter', [AdminController::class, 'storeWaiter'])->name('waiter.store');
            Route::delete('/waiter/{id}', [AdminController::class, 'destroyWaiter'])->name('waiter.destroy');
            Route::get('/pelanggan', [AdminController::class, 'indexPelanggan'])->name('pelanggan.index');
        });
    });
    
    Route::middleware('role:pelanggan')->group(function () {
        Route::get('/pesanan', [PelangganController::class, 'index'])->name('pesanan.index');
        Route::get('/pesan', [PelangganController::class, 'create'])->name('pesanan.create');
        Route::post('/pesan', [PelangganController::class, 'store'])->name('pesanan.store');
    });

    
    Route::middleware('role:waiter')->group(function () {
        Route::get('/waiter/orders', [WaiterController::class, 'listOrders'])->name('waiter.list-orders');
        Route::get('/waiter/orders/create', [WaiterController::class, 'showCreateOrder'])->name('waiter.show-create-order');
        Route::post('/waiter/orders', [WaiterController::class, 'createOrder'])->name('waiter.create-order');
        Route::patch('/waiter/orders/{orderId}/status', [WaiterController::class, 'updateStatus'])->name('waiter.update-status');
    });
    
    Route::middleware('role:kasir')->group(function () {
        Route::get('/kasir/orders', [KasirController::class, 'index'])->name('kasir.list-orders');
        Route::patch('/kasir/orders/{id}/pembayaran', [KasirController::class, 'prosesPembayaran'])->name('kasir.proses-pembayaran');
    });
});