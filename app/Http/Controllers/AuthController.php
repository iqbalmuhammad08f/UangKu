<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!'
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }

    public function forgotPassword()
    {
        return view('pages.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Cek apakah email terdaftar menggunakan Eloquent
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar!'])->withInput();
        }

        try {
            // Generate token menggunakan model method
            $token = PasswordResetToken::generateToken($request->email);

            // Redirect langsung ke halaman reset password dengan token
            return redirect()->route('password.reset', ['token' => $token, 'email' => $request->email])
                ->with('success', 'Silakan buat password baru Anda.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi.'])->withInput();
        }
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

        try {
            // Validasi token menggunakan Eloquent
            $resetRecord = PasswordResetToken::findValidToken($request->email, $request->token);

            if (!$resetRecord) {
                return back()->withErrors(['email' => 'Token tidak valid atau sudah kedaluwarsa.'])->withInput();
            }

            // Update password user menggunakan Eloquent
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'User tidak ditemukan.'])->withInput();
            }

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            // Hapus token setelah digunakan menggunakan Eloquent
            $resetRecord->deleteToken();

            event(new PasswordReset($user));

            return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi.'])->withInput();
        }
    }
}
