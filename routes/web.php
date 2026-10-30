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

    // Route Khusus Merchant
    Route::middleware(['auth', 'role:merchant'])->prefix('merchant')->name('merchant.')->group(function () {
        
        // Dashboard Merchant (Mengambil Data Toko & Produk)
        Route::get('/dashboard', function () {
            $store = Store::where('user_id', Auth::id())->first();
            $products = $store ? Product::where('store_id', $store->id)->latest()->get() : collect();

            return view('merchant.dashboard', compact('store', 'products'));
        })->name('dashboard');

    // Pengaturan Toko
    Route::get('/store', [StoreController::class, 'index'])->name('store.index');
    Route::post('/store', [StoreController::class, 'store'])->name('store.save');
    Route::middleware(['auth'])->group(function () {
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    });

    // Manajemen Produk Surplus
    Route::resource('products', ProductController::class);
    });

require __DIR__.'/auth.php';