<?php

use App\Models\Store;
use App\Models\Product;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Merchant\StoreController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Merchant\ProductController;
use App\Http\Controllers\Merchant\OrderController as MerchantOrderController;
use App\Http\Controllers\Merchant\ProductController as MerchantProductController;
use App\Http\Controllers\CartController;

// Halaman Depan
Route::get('/', [HomeController::class, 'index'])->name('welcome');

// Route khusus pengguna terotentikasi (Auth)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Pengarahan otomatis berdasarkan Role
    Route::get('/dashboard', function () {
        $products = Product::with('store')->where('stock', '>', 0)->latest()->get();

        return view('dashboard', compact('products'));
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    // Group Route khusus Merchant
    Route::middleware(['auth'])->prefix('merchant')->as('merchant.')->group(function () {
        // Route Dashboard Merchant
        Route::get('/dashboard', [StoreController::class, 'dashboard'])->name('dashboard');
        
        // Route Manajemen Toko
        Route::get('/store', [StoreController::class, 'index'])->name('store.index');
        Route::post('/store', [StoreController::class, 'store'])->name('store.store');
        
        // Route CRUD Produk Merchant (Otomatis buat merchant.products.index, merchant.products.create, dll)
        Route::resource('products', ProductController::class);
    });

    Route::middleware(['auth'])->prefix('merchant')->name('merchant.')->group(function () {
        
        // Kelola Produk Merchant
        Route::get('/products', [MerchantProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [MerchantProductController::class, 'create'])->name('products.create');
        Route::post('/products', [MerchantProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [MerchantProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [MerchantProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [MerchantProductController::class, 'destroy'])->name('products.destroy');

        // Kelola Pesanan Masuk Merchant
        Route::get('/orders', [MerchantOrderController::class, 'index'])->name('orders.index');
        Route::post('/orders/{pickup_code}/complete', [MerchantOrderController::class, 'complete'])->name('orders.complete');
    });

    // ==========================================
    // RUTE PELANGGAN (CUSTOMER)
    // ==========================================
    Route::middleware(['auth'])->group(function () {
        
        // Keranjang & Checkout
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

        // Pesanan Saya
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/confirm/{product_id}', [OrderController::class, 'confirm']);
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    });

require __DIR__.'/auth.php';