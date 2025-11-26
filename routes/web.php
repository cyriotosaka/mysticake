<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AddressController;

Route::get('/', [AuthController::class, 'landing'])->name('landing');

Route::middleware('guest')->group(function () {

    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegisterPage'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// 3. Khusus User (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    // Route Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {

    // --- HOME & SEARCH ROUTES ---
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/search', [HomeController::class, 'search'])->name('search');

    // --- LOGOUT ROUTE ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get'); // Alternative GET method

    // --- SETTINGS ROUTES ---
    // Profile Settings
    Route::get('/settings/profile', [SettingsController::class, 'editProfile'])->name('settings.profile');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.updateProfile');

    // More Settings & Change Password
    Route::get('/settings/more', [SettingsController::class, 'moreSettings'])->name('settings.more');
    Route::get('/settings/password', [SettingsController::class, 'changePassword'])->name('settings.password');

    // --- ADDRESS MANAGEMENT ROUTES (CRUD) ---
    // List all addresses
    Route::get('/settings/address', [AddressController::class, 'index'])->name('address.index');

    // Create new address
    Route::get('/settings/address/create', [AddressController::class, 'create'])->name('address.create');
    Route::post('/settings/address', [AddressController::class, 'store'])->name('address.store');

    // Edit existing address
    Route::get('/settings/address/{id}/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/settings/address/{id}', [AddressController::class, 'update'])->name('address.update');

    // Delete address
    Route::delete('/settings/address/{id}', [AddressController::class, 'destroy'])->name('address.destroy');
});

// ============================================
// ADDITIONAL ROUTES (Sesuai Use Case Diagram)
// ============================================

// Route untuk fitur-fitur yang akan dikembangkan sesuai use case diagram:
// - Melakukan pencarian dessert (sudah ada di /search)
// - Melihat rating dan feedback (akan ditambahkan)
// - Memilih rekomendasi dessert (sudah ada di /home)
// - Menambahkan dessert ke shopping cart (akan ditambahkan)
// - Melakukan pemesanan (akan ditambahkan)
// - Melakukan pembayaran (akan ditambahkan)
// - Top up coin (akan ditambahkan)
// - Chat dengan seller (akan ditambahkan)
// - Melakukan gacha dessert (akan ditambahkan)
// - Melihat history gacha (akan ditambahkan)
// - Melihat drop rate (akan ditambahkan)
