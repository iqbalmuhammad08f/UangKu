<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('show-reset-password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/transactions', function () {
        return view('pages.transactions.index');
    })->name('transactions.index');
    Route::get('/wallets', function () {
        return view('pages.wallets.index');
    })->name('wallets.index');
    Route::get('/categories',function(){
        return view('pages.categories.index');
    })->name('categories.index');
});
