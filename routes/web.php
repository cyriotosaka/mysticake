<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MysteryBoxController;
use App\Http\Controllers\CartController;

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
    
    // Search Routes (sesuai sequence diagram)
    Route::get('/search', [ProductController::class, 'showSearchPage'])->name('search');
    Route::post('/search', [ProductController::class, 'searchProduct'])->name('search.submit');

    // Rating & Feedback
    Route::get('/product/{id}/ratings', [ProductController::class, 'showRatings'])->name('product.ratings');

    // --- LOGOUT ROUTE ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

    // --- SETTINGS ROUTES ---
    // Profile Settings
    Route::get('/settings/profile', [SettingsController::class, 'editprofile'])->name('settings.profile');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.updateProfile');

    // More Settings & Change Password
    Route::get('/settings/more', [SettingsController::class, 'moreSettings'])->name('settings.more');
    Route::get('/settings/password', [SettingsController::class, 'changepassword'])->name('settings.password');

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

    //Lihat Product
    Route::get('/product/{id}', [ProductController::class, 'showProductDetail'])->name('product.detail');

    //Gacha
    Route::get('/gacha', [MysteryBoxController::class, 'showGachaPage'])->name('gacha.index');
    Route::post('/gacha/roll', [MysteryBoxController::class, 'rollGacha'])->name('gacha.roll');
    Route::get('/gacha/history', [MysteryBoxController::class, 'showGachaHistory'])->name('gacha.history');
    Route::get('/gacha/droprate', [MysteryBoxController::class, 'getDropRates'])->name('gacha.droprates');

    // CART ROUTES
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'removeItem'])->name('cart.delete');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // ORDER/CHECKOUT FLOW ROUTES
    Route::get('/order/payment', [\App\Http\Controllers\OrderController::class, 'showPayment'])->name('order.payment');
    
    // Address Management in Checkout
    Route::get('/order/address/select', [\App\Http\Controllers\OrderController::class, 'selectAddress'])->name('order.address.select');
    Route::get('/order/address/details/{id?}', [\App\Http\Controllers\OrderController::class, 'showAddressDetails'])->name('order.address.details');
    Route::post('/order/address/save', [\App\Http\Controllers\OrderController::class, 'saveAddress'])->name('order.address.save');
    Route::delete('/order/address/delete/{id}', [\App\Http\Controllers\OrderController::class, 'deleteAddress'])->name('order.address.delete');
    
    // Delivery Selection
    Route::get('/order/delivery', [\App\Http\Controllers\OrderController::class, 'showDeliveryOptions'])->name('order.delivery');
    Route::post('/order/delivery/{id}', [\App\Http\Controllers\OrderController::class, 'selectDelivery'])->name('order.delivery.select');
    
    // Payment Method Selection
    Route::get('/order/payment-methods', [\App\Http\Controllers\OrderController::class, 'showPaymentMethods'])->name('order.payment.methods');
    Route::post('/order/payment-method/{id}', [\App\Http\Controllers\OrderController::class, 'selectPaymentMethod'])->name('order.payment.method.select');
    
    // Order Processing & Confirmation
    Route::post('/order/process', [\App\Http\Controllers\OrderController::class, 'processOrder'])->name('order.process');
    Route::get('/order/confirmation/{id}', [\App\Http\Controllers\OrderController::class, 'showOrderConfirmation'])->name('order.confirmation');
    
    // Order History
    Route::get('/order/history', [\App\Http\Controllers\OrderController::class, 'orderHistory'])->name('order.history');
    Route::get('/order/{id}', [\App\Http\Controllers\OrderController::class, 'orderDetails'])->name('order.details');

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
