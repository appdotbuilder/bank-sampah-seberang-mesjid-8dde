<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\TransaksiSetoranController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin only routes
    Route::middleware(['auth', \App\Http\Middleware\AdminOnly::class])->group(function () {
        // Master data routes
        Route::resource('nasabah', NasabahController::class);
        
        // Transaction routes
        Route::prefix('transaksi')->name('transaksi.')->group(function () {
            Route::resource('setoran', TransaksiSetoranController::class);
        });
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
