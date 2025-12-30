<?php
/**
 * Created by Arsya Nueva_099
 * Updated by Abdul Ghoni (5026231109)
 * - Menambahkan route review.update dan review.destroy untuk CRUD review
 * Updated by Okky Priscila_168
 * - Menambahkan route untuk fitur drop rate gacha (normal & premium)
 * - Menambahkan route untuk fitur top up (halaman utama, dropdown, dan proses top up)
 * - Menambahkan route topup.coin untuk redirect dari icon plus di home
 * - Menambahkan route untuk Indomaret dan Alfamart payment flow baru
 * - Menambahkan route untuk Bank Transfer dan E-wallet flow baru
 * Updated by Lailatul Fitaliqoh (5026231229)
 * - Login
 * - Auth Action sampai adrees management
 * - Chat
 * Updated by Muhammad Fikri Khalilullah/5026231198
 * 
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
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ChatController; 

Route::get('/', [AuthController::class, 'showLandingPage'])->name('landing');

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
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get'); 
    
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get'); // Fallback jika diakses via URL

    // Switch Account
    Route::post('/switch-account', [AuthController::class, 'switchAccount'])->name('auth.switch');

    // Proses Delete Account
    Route::delete('/settings/account', [SettingsController::class, 'deleteAccount'])->name('settings.deleteAccount');

    // --- SETTINGS ---
    // Profile
    Route::get('/settings/profile', [SettingsController::class, 'editprofile'])->name('settings.profile');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.updateProfile');
    Route::get('/settings/history', [SettingsController::class, 'loginHistory'])->name('settings.history');

    // More Settings & Password
    Route::get('/settings/more', [SettingsController::class, 'moreSettings'])->name('settings.more');
    Route::get('/settings/password', [SettingsController::class, 'changepassword'])->name('settings.password');
    Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');

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
    Route::get('/gacha/reveal', [MysteryBoxController::class, 'showResultPage'])->name('gacha.result');
    Route::get('/gacha/roll', function() {return redirect('/gacha');});

    //Drop Rate - Okky Priscila_168
    Route::get('/gacha/droprate/normal', [MysteryBoxController::class, 'showNormalDropRatePage'])->name('gacha.droprate.normal');
    Route::get('/gacha/droprate/premium', [MysteryBoxController::class, 'showPremiumDropRatePage'])->name('gacha.droprate.premium');

    // CART ROUTES
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

    // ============================================
    // TOP UP ROUTES - Created by Okky Priscila_168
    // ============================================

    // Top Up Coin Page (redirect dari icon plus di home.blade.php)
    Route::get('/topup/coin', [TopUpController::class, 'showTopUpCoinPage'])->name('topup.coin');

    // Top Up Main Page
    Route::get('/topup', [TopUpController::class, 'index'])->name('topup.index');

    // ============================================
    // DEBIT CARD ROUTES - Created by Okky Priscila_168
    // ============================================

    // Add Debit Card Page
    Route::get('/topup/debitcard/add', [TopUpController::class, 'redirectToAddDebitCard'])->name('topup.debitcard.add');

    // Store Debit Card and show VA
    Route::post('/topup/debitcard/store', [TopUpController::class, 'storeDebitCard'])->name('topup.debitcard.store');

    // Confirm Debit Card Payment
    Route::post('/topup/debitcard/confirm', [TopUpController::class, 'confirmDebitCardPayment'])->name('topup.debitcard.confirm');

    // Dropdown AJAX Routes
    Route::get('/topup/debitcard/dropdown', [TopUpController::class, 'showCreditCardDropDown'])->name('topup.debitcard.dropdown');
    Route::get('/topup/banktransfer/dropdown', [TopUpController::class, 'showBankTransferDropDown'])->name('topup.banktransfer.dropdown');

    // Process Top Up Routes
    Route::post('/topup/debitcard', [TopUpController::class, 'processDebitCard'])->name('topup.debitcard.process');
    Route::post('/topup/banktransfer', [TopUpController::class, 'processBankTransfer'])->name('topup.banktransfer.process');
    Route::post('/topup/ewallet', [TopUpController::class, 'processEwallet'])->name('topup.ewallet.process');

    // ============================================
    // BANK TRANSFER NEW FLOW ROUTES - Created by Okky Priscila_168
    // ============================================

    // Bank Transfer - Page untuk input amount (Step 1)
    Route::get('/topup/banktransfer', [TopUpController::class, 'showBankTransferPage'])->name('topup.banktransfer.page');

    // Bank Transfer - Process dan redirect ke VA page (Step 2)
    Route::post('/topup/banktransfer/process-new', [TopUpController::class, 'processBankTransferPayment'])->name('topup.banktransfer.process.payment');

    // ============================================
    // E-WALLET NEW FLOW ROUTES - Created by Okky Priscila_168
    // ============================================

    // E-wallet - Page untuk input amount (Step 1)
    Route::get('/topup/ewallet', [TopUpController::class, 'showEwalletPage'])->name('topup.ewallet.page');

    // E-wallet - Process dan redirect ke VA page (Step 2)
    Route::post('/topup/ewallet/process-new', [TopUpController::class, 'processEwalletPayment'])->name('topup.ewallet.process.payment');

    // ============================================
    // INDOMARET NEW FLOW ROUTES - Created by Okky Priscila_168
    // ============================================

    // Indomaret - Page untuk input amount (Step 1 & 2)
    Route::get('/topup/indomaret', [TopUpController::class, 'showTopUpCoinIndomaret12'])->name('topup.indomaret.page');

    // Indomaret - Process payment dan redirect ke barcode page
    Route::post('/topup/indomaret/process', [TopUpController::class, 'processIndomaretPayment'])->name('topup.indomaret.process.payment');

    // Indomaret - Barcode page (Step 3)
    Route::get('/topup/indomaret/barcode', [TopUpController::class, 'showTopUpCoinIndomaret3'])->name('topup.indomaret.barcode');

    // ============================================
    // ALFAMART NEW FLOW ROUTES - Created by Okky Priscila_168
    // ============================================

    // Alfamart - Page untuk input amount (Step 1 & 2)
    Route::get('/topup/alfamart', [TopUpController::class, 'showTopUpCoinAlfamart12'])->name('topup.alfamart.page');

    // Alfamart - Process payment dan redirect ke barcode page
    Route::post('/topup/alfamart/process', [TopUpController::class, 'processAlfamartPayment'])->name('topup.alfamart.process.payment');

    // Alfamart - Barcode page (Step 3)
    Route::get('/topup/alfamart/barcode', [TopUpController::class, 'showTopUpCoinAlfamart3'])->name('topup.alfamart.barcode');

    // ============================================
    // LEGACY ROUTES (Backward Compatibility)
    // ============================================

    // Legacy Indomaret process (dari modal)
    Route::post('/topup/indomaret/legacy', [TopUpController::class, 'processIndomaret'])->name('topup.indomaret.process');

    // Legacy Alfamart process (dari modal)
    Route::post('/topup/alfamart/legacy', [TopUpController::class, 'processAlfamart'])->name('topup.alfamart.process');

    // Confirm Payment (for bank transfer, indomaret, alfamart)
    Route::post('/topup/confirm', [TopUpController::class, 'confirmPayment'])->name('topup.confirm');

    // Cancel Payment
    Route::get('/topup/cancel', [TopUpController::class, 'cancelPayment'])->name('topup.cancel');

    // Add Debit Card Route
    Route::post('/topup/debitcard/add', [TopUpController::class, 'addDebitCard'])->name('topup.debitcard.add');

    // Success Page
    Route::get('/topup/success', [TopUpController::class, 'showSuccess'])->name('topup.success');

    // Top Up History
    Route::get('/topup/history', [TopUpController::class, 'history'])->name('topup.history');

    // Processing & Confirmation
    Route::post('/order/process', [OrderController::class, 'processOrder'])->name('order.process');
    Route::get('/order/confirmation/{id}', [OrderController::class, 'showOrderConfirmation'])->name('order.confirmation');

    // Order History
    Route::get('/order/history', [OrderController::class, 'orderHistory'])->name('order.history');
    Route::get('/order/{id}', [OrderController::class, 'orderDetails'])->name('order.details');

    // CHAT ROUTES
    Route::get('/chats', [ChatController::class, 'index'])->name('chat.index'); 
    Route::get('/chat/{store_id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{store_id}', [ChatController::class, 'send'])->name('chat.send');

    // ... route chat lainnya ...
    Route::get('/chats', [ChatController::class, 'index'])->name('chat.index'); 
    Route::get('/chat/{store_id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{store_id}', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/product/{id}', [ChatController::class, 'chatWithProduct'])->name('chat.product');

}); 

// ============================================
// DEBUG ROUTE - Hapus setelah selesai testing
// ============================================
Route::get('/debug-products', function () {
    $products = App\Models\Product::select('id_product', 'name_product', 'price', 'stock')->get();
    return response()->json([
        'count' => $products->count(),
        'products' => $products
    ]);
});