<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Shortcut rute login khusus per role
Route::middleware('guest')->group(function () {
    Route::get('/login/admin', function () {
        return redirect()->route('login', ['role' => 'admin']);
    })->name('login.admin');

    Route::get('/login/staff', function () {
        return redirect()->route('login', ['role' => 'staff']);
    })->name('login.staff');

    Route::get('/login/customer', function () {
        return redirect()->route('login', ['role' => 'customer']);
    })->name('login.customer');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Fitur E-Commerce Customer: Checkout langsung & Cetak Struk Belanja
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{sale}/receipt', [\App\Http\Controllers\OrderController::class, 'receipt'])->name('orders.receipt');

    // CRUD Inventaris & Transaksi: Hanya dapat diakses oleh Admin dan Staff
    Route::middleware('role:admin,staff')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('products', ProductController::class);
        Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show']);
        Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);
        Route::patch('sales/{sale}/status', [SaleController::class, 'updateStatus'])->name('sales.status');
    });
});

require __DIR__.'/auth.php';
