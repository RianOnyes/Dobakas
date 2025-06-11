<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
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
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
});

// Donatur Routes
Route::middleware(['auth', 'verified', 'donatur'])->prefix('donatur')->name('donatur.')->group(function () {
    Route::get('/dashboard', function () {
        return view('donatur.dashboard');
    })->name('dashboard');
});

// Organisasi Routes
Route::middleware(['auth', 'verified', 'organisasi'])->prefix('organisasi')->name('organisasi.')->group(function () {
    Route::get('/dashboard', function () {
        return view('organisasi.dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
