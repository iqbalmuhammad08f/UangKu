<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);

        if (Auth::attempt($validation)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login berhasil');
        }

        return back()->withErrors('Email atau password salah');
    }

    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);

        User::create([
            'name' => $validation['name'],
            'email' => $validation['email'],
            'password' => Hash::make($validation['password'])
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil');
    }

    public function showForgotPassword()
    {
        return view('pages.auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = User::where('email', $request->email)->first();

        if (!$email) {
            return back()->withErrors('Email tidak terdaftar');
        }

        $token = PasswordResetToken::generateToken($request->email);
        return redirect()->route('show-reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function showResetPassword(Request $request)
    {
        return view('pages.auth.reset-password', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $resetRecord = PasswordResetToken::findValidToken($request->email, $request->token);

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'Token tidak valid atau sudah kedaluwarsa.'])->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User tidak ditemukan.'])->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $resetRecord->deleteToken();

        return redirect()->route('login')->with('success', 'Password berhasil direset!');
    }
    public function logout(Request $request)
{
    // Hapus session login
    Auth::logout();

    // Regenerate session supaya lebih aman
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Berhasil logout!');
}
}
