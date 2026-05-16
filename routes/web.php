<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

// Auth Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Only Routes
    Route::middleware('admin')->group(function () {
        Route::resource('products', ProductController::class)->except(['show']);
        Route::resource('categories', \App\Http\Controllers\CategoryController::class)->except(['show']);
    });

    // Transactions (Available for both)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/add-to-cart', [TransactionController::class, 'addToCart'])->name('transactions.addToCart');
    Route::delete('/transactions/remove-from-cart/{key}', [TransactionController::class, 'removeFromCart'])->name('transactions.removeFromCart');
    Route::post('/transactions/clear-cart', [TransactionController::class, 'clearCart'])->name('transactions.clearCart');
    Route::post('/transactions/checkout', [TransactionController::class, 'checkout'])->name('transactions.checkout');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/history', [TransactionController::class, 'history'])->name('transactions.history');
});
