<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password.show');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('reset-password.show');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard.index');

    // TRANSAKSI ROUTES
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transactions', 'index')->name('transactions.index');
        Route::get('/transactions/{id}/edit', 'edit')->name('transactions.edit');
        Route::put('/transactions/{id}', 'update')->name('transactions.update');
        Route::post('/transactions', 'store')->name('transactions.store');
        Route::delete('/transactions/{id}', 'destroy')->name('transactions.destroy');
    });

    // WALLET ROUTES
    Route::controller(WalletController::class)->group(function () {
        Route::get('/wallets', 'index')->name('wallets.index');
        Route::post('/wallets', 'store')->name('wallets.store');
        Route::put('/wallets/{id}', 'update')->name('wallets.update');
        Route::delete('/wallets/{id}', 'destroy')->name('wallets.destroy');
        Route::post('/wallets/transfer', 'transferProcess')->name('wallets.transfer');
    });

    // CATEGORY ROUTES
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index')->name('categories.index');
        Route::post('/categories', 'store')->name('categories.store');
        Route::put('/categories/{id}', 'update')->name('categories.update');
        Route::delete('/categories/{id}', 'destroy')->name('categories.destroy');
    });

    // PROFILE ROUTES
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::put('/profile', 'update')->name('profile.update');
        Route::put('/profile/password', 'updatePassword')->name('profile.password.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
