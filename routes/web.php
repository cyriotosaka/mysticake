<?php
/**
 * Updated by Abdul Ghoni (5026231109)
 * - Menambahkan route review.update dan review.destroy untuk CRUD review
 * Updated by Lailatul Fitaliqoh (5026231229)
 */
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MysteryBoxController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController; 

// --- PUBLIC ROUTES ---
Route::get('/', [AuthController::class, 'landing'])->name('landing');

Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegisterPage'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// --- PROTECTED ROUTES (USER ONLY) ---
Route::middleware('auth')->group(function () {

    // --- HOME & SEARCH ---
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Search
    Route::get('/search', [ProductController::class, 'showSearchPage'])->name('search');
    Route::post('/search', [ProductController::class, 'searchProduct'])->name('search.submit');

    // --- PRODUCT & REVIEWS ---
    Route::get('/product/{id}', [ProductController::class, 'showProductDetail'])->name('product.detail');
    
    // Rating & Feedback
    Route::get('/product/{id}/ratings', [ProductController::class, 'showRatings'])->name('product.ratings');
    Route::post('/product/{id}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::put('/review/{id}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');
    Route::post('/review/{id}/like', [ReviewController::class, 'toggleLike'])->name('review.like');

    // --- AUTH ACTIONS ---
    // Logout (Support GET & POST)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get'); // Fallback jika diakses via URL
    
    // Switch Account
    Route::post('/switch-account', [AuthController::class, 'switchAccount'])->name('auth.switch');

    // --- SETTINGS ---
    // Profile
    Route::get('/settings/profile', [SettingsController::class, 'editprofile'])->name('settings.profile');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.updateProfile');

    // More Settings & Password
    Route::get('/settings/more', [SettingsController::class, 'moreSettings'])->name('settings.more');
    Route::get('/settings/password', [SettingsController::class, 'changepassword'])->name('settings.password');

    // --- ADDRESS MANAGEMENT (CRUD) ---
    Route::get('/settings/address', [AddressController::class, 'index'])->name('address.index');
    Route::get('/settings/address/create', [AddressController::class, 'create'])->name('address.create');
    Route::post('/settings/address', [AddressController::class, 'store'])->name('address.store');
    Route::get('/settings/address/{id}/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/settings/address/{id}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/settings/address/{id}', [AddressController::class, 'destroy'])->name('address.destroy');

    // --- GACHA / MYSTERY BOX ---
    Route::get('/gacha', [MysteryBoxController::class, 'showGachaPage'])->name('gacha.index');
    Route::post('/gacha/roll', [MysteryBoxController::class, 'rollGacha'])->name('gacha.roll');
    Route::get('/gacha/history', [MysteryBoxController::class, 'showGachaHistory'])->name('gacha.history');
    Route::get('/gacha/droprate', [MysteryBoxController::class, 'getDropRates'])->name('gacha.droprates');

    // --- CART ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'removeItem'])->name('cart.delete');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // --- ORDER & CHECKOUT FLOW ---
    Route::get('/order/payment', [OrderController::class, 'showPayment'])->name('order.payment');

    // Checkout Address Selection
    Route::get('/order/address/select', [OrderController::class, 'selectAddress'])->name('order.address.select');
    Route::get('/order/address/details/{id?}', [OrderController::class, 'showAddressDetails'])->name('order.address.details');
    Route::post('/order/address/save', [OrderController::class, 'saveAddress'])->name('order.address.save');
    Route::delete('/order/address/delete/{id}', [OrderController::class, 'deleteAddress'])->name('order.address.delete');

    // Delivery Selection
    Route::get('/order/delivery', [OrderController::class, 'showDeliveryOptions'])->name('order.delivery');
    Route::post('/order/delivery/{id}', [OrderController::class, 'selectDelivery'])->name('order.delivery.select');

    // Payment Method Selection
    Route::get('/order/payment-methods', [OrderController::class, 'showPaymentMethods'])->name('order.payment.methods');
    Route::post('/order/payment-method/{id}', [OrderController::class, 'selectPaymentMethod'])->name('order.payment.method.select');

    // Processing & Confirmation
    Route::post('/order/process', [OrderController::class, 'processOrder'])->name('order.process');
    Route::get('/order/confirmation/{id}', [OrderController::class, 'showOrderConfirmation'])->name('order.confirmation');

    // Order History
    Route::get('/order/history', [OrderController::class, 'orderHistory'])->name('order.history');
    Route::get('/order/{id}', [OrderController::class, 'orderDetails'])->name('order.details');

});