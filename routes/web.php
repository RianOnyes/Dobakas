<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\OrganisasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

// Redirect authenticated users to their role-specific dashboard
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return redirect()->route(auth()->user()->getDashboardRoute());
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Statistics & Reports (Combined)
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
    Route::get('/statistics/export', [AdminController::class, 'exportStatistics'])->name('statistics.export');
    Route::get('/create-sample-data', [AdminController::class, 'createSampleDataManual'])->name('create-sample-data');
    Route::get('/debug-counts', [AdminController::class, 'debugCounts'])->name('debug-counts');
    
    // Donation management
    Route::get('/donations', [AdminController::class, 'donations'])->name('donations');
    Route::get('/donations/{donation}', [AdminController::class, 'showDonation'])->name('donations.show');
    Route::patch('/donations/{donation}/status', [AdminController::class, 'updateDonationStatus'])->name('donations.status');
    
    // Organization management
    Route::get('/organizations', [AdminController::class, 'organizations'])->name('organizations');
    Route::get('/organizations/{organization}', [AdminController::class, 'showOrganization'])->name('organizations.show');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::patch('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});

// Donatur Routes
Route::middleware(['auth', 'verified', 'donatur'])->prefix('donatur')->name('donatur.')->group(function () {
    Route::get('/dashboard', [DonaturController::class, 'dashboard'])->name('dashboard');
    Route::get('/cari-bantuan', [DonaturController::class, 'cariBantuan'])->name('cari-bantuan');
    Route::get('/organisasi/{organization}', [DonaturController::class, 'showOrganization'])->name('organization.show');
    
    // Donation Management
    Route::get('/buat-donasi', [DonaturController::class, 'selectDonationType'])->name('buat-donasi');
    Route::get('/buat-donasi/barang', [DonaturController::class, 'createDonation'])->name('buat-donasi-barang');
    Route::post('/buat-donasi/barang', [DonaturController::class, 'storeDonation'])->name('store-donasi-barang');
    Route::get('/buat-donasi/uang', [DonaturController::class, 'createMoneyDonation'])->name('buat-donasi-uang');
    Route::post('/buat-donasi/uang', [DonaturController::class, 'storeMoneyDonation'])->name('store-donasi-uang');
    Route::get('/donasi-saya', [DonaturController::class, 'donasiSaya'])->name('donasi-saya');
    Route::get('/riwayat', [DonaturController::class, 'riwayat'])->name('riwayat');
    Route::get('/donasi/{donation}', [DonaturController::class, 'showDonation'])->name('donation.show');
    Route::patch('/donasi/{donation}/cancel', [DonaturController::class, 'cancelDonation'])->name('donation.cancel');
});

// Organisasi Routes
Route::middleware(['auth', 'verified', 'organisasi'])->prefix('organisasi')->name('organisasi.')->group(function () {
    Route::get('/dashboard', [OrganisasiController::class, 'dashboard'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [OrganisasiController::class, 'profile'])->name('profile');
    Route::patch('/profile', [OrganisasiController::class, 'updateProfile'])->name('profile.update');
    
    // Claimed Donations Management
    Route::get('/donasi-diklaim', [OrganisasiController::class, 'claimedDonations'])->name('claimed-donations');
    Route::patch('/donasi/{donation}/complete', [OrganisasiController::class, 'completeDonation'])->name('donation.complete');
    
    // Warehouse Donations Browsing
    Route::get('/gudang-admin', [OrganisasiController::class, 'warehouseDonations'])->name('warehouse-donations');
    Route::get('/donasi/{donation}', [OrganisasiController::class, 'showDonation'])->name('donation.show');
    Route::patch('/donasi/{donation}/claim', [OrganisasiController::class, 'claimDonation'])->name('donation.claim');
    
    // Request Management
    Route::get('/permintaan', [OrganisasiController::class, 'requests'])->name('requests');
    Route::get('/buat-permintaan', [OrganisasiController::class, 'createRequest'])->name('create-request');
    Route::post('/buat-permintaan', [OrganisasiController::class, 'storeRequest'])->name('store-request');
    Route::get('/permintaan/{request}', [OrganisasiController::class, 'showRequest'])->name('request.show');
    Route::patch('/permintaan/{request}/status', [OrganisasiController::class, 'updateRequestStatus'])->name('request.status');
    Route::delete('/permintaan/{request}', [OrganisasiController::class, 'deleteRequest'])->name('request.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

use Illuminate\Support\Facades\Artisan;

Route::get('/run-migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrasi berhasil dijalankan!';
});

Route::get('/run-seed', function () {
    Artisan::call('db:seed', ['--force' => true]);
    return 'Seeder berhasil dijalankan!';
});
