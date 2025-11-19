<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AddressController;

Route::get('/', [AuthController::class, 'landing'])->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
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

    // Panggil HomeController class index
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Route Search Baru
    Route::get('/search', [HomeController::class, 'search'])->name('search');

Route::middleware('auth')->group(function () {
    // ... route home lainnya ...

    // --- SETTINGS ROUTES ---
    Route::get('/settings/profile', [SettingsController::class, 'editProfile'])->name('settings.profile');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.updateProfile'); // Proses Update Profil

    Route::get('/settings/more', [SettingsController::class, 'moreSettings'])->name('settings.more');
    Route::get('/settings/password', [SettingsController::class, 'changePassword'])->name('settings.password');

    // --- ADDRESS ROUTES (CRUD) ---
    Route::get('/settings/address', [AddressController::class, 'index'])->name('address.index');
    Route::get('/settings/address/create', [AddressController::class, 'create'])->name('address.create');
    Route::post('/settings/address', [AddressController::class, 'store'])->name('address.store');
    Route::get('/settings/address/{id}/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/settings/address/{id}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/settings/address/{id}', [AddressController::class, 'destroy'])->name('address.destroy');
});
