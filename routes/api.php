<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\AdminApiController;
use App\Http\Controllers\Api\PelangganApiController;
use App\Http\Controllers\Api\WaiterApiController;
use App\Http\Controllers\Api\KasirApiController;

Route::get('/', fn () => response()->json(['message' => 'API Warkom Ready']))->name('api.home');

Route::post('/login', [AuthApiController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.logout');

    Route::middleware('role:admin')->prefix('admin')->name('api.admin.')->group(function () {
        Route::get('/transaksi', [AdminApiController::class, 'indexTransaksi'])->name('transaksi');
        Route::get('/kasir', [AdminApiController::class, 'indexKasir'])->name('kasir.index');
        Route::post('/kasir', [AdminApiController::class, 'storeKasir'])->name('kasir.store');
        Route::delete('/kasir/{id}', [AdminApiController::class, 'destroyKasir'])->name('kasir.destroy');
        Route::get('/waiter', [AdminApiController::class, 'indexWaiter'])->name('waiter.index');
        Route::post('/waiter', [AdminApiController::class, 'storeWaiter'])->name('waiter.store');
        Route::delete('/waiter/{id}', [AdminApiController::class, 'destroyWaiter'])->name('waiter.destroy');
        Route::get('/pelanggan', [AdminApiController::class, 'indexPelanggan'])->name('pelanggan.index');
    });

    Route::middleware('role:pelanggan')->prefix('pelanggan')->name('api.pelanggan.')->group(function () {
        Route::get('/pesanan', [PelangganApiController::class, 'index'])->name('pesanan.index');
        Route::post('/pesanan', [PelangganApiController::class, 'store'])->name('pesanan.store');
    });

    Route::middleware('role:waiter')->prefix('waiter')->name('api.waiter.')->group(function () {
        Route::get('/orders', [WaiterApiController::class, 'listOrders'])->name('orders.index');
        Route::post('/orders', [WaiterApiController::class, 'createOrder'])->name('orders.store');
        Route::patch('/orders/{orderId}/status', [WaiterApiController::class, 'updateStatus'])->name('orders.update-status');
    });

    Route::middleware('role:kasir')->prefix('kasir')->name('api.kasir.')->group(function () {
        Route::get('/orders', [KasirApiController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{id}/pembayaran', [KasirApiController::class, 'prosesPembayaran'])->name('orders.proses-pembayaran');
    });
});
