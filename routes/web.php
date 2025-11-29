<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\dashboardController;
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
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::controller(WalletController::class)->group(function () {
        Route::get('/wallets', 'index')->name('wallets.index');
        Route::post('/wallets', 'store')->name('wallets.store');
        Route::put('/wallets/{id}', 'update')->name('wallets.update');
        Route::delete('/wallets/{id}', 'destroy')->name('wallets.destroy');
        Route::post('/wallets/transfer', 'transferProcess')->name('wallets.transfer'); // Route Khusus Transfer
    });
    Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
