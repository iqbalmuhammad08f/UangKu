<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return redirect(route('login'));
});

Route::middleware('guest')->group(function () {
  Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
  Route::post('/register', [AuthController::class, 'register']);

  Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
  Route::post('/login', [AuthController::class, 'login']);

  // PERBAIKAN: Ubah method yang dipanggil
  Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
  Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

  Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
  Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

  Route::get('/dashboard', function () {
    return view('pages.dashboard.index');
  })->name('dashboard');
});
