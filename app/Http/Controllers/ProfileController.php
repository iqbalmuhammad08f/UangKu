<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function index()
    {
        return view('pages.profil.index', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update profil user (nama, email, avatar)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'], // Max 2MB
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan pengguna lain',
            'avatar.image' => 'File harus berupa gambar',
            'avatar.mimes' => 'Avatar harus berformat: jpeg, jpg, atau png',
            'avatar.max' => 'Ukuran avatar maksimal 2MB',
        ]);

        // Cek apakah email berubah
        $emailChanged = $user->email !== $validated['email'];

        // Handle upload avatar
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        // Update data user
        $user->update($validated);

        // Jika email berubah, reset verifikasi email
        if ($emailChanged) {
            $user->email_verified_at = null;
            $user->save();

            // Kirim email verifikasi (opsional - jika Anda implementasi verifikasi email)
            // $user->sendEmailVerificationNotification();

            return redirect()->route('profile.index')
                ->with('warning', 'Profil berhasil diperbarui. Email Anda telah berubah, silakan lakukan verifikasi ulang.');
        }

        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', Password::min(8), 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = Auth::user();

        // Cek apakah password saat ini benar
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai'
            ])->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Hapus akun user
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Validasi password untuk konfirmasi
        $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'Password wajib diisi untuk konfirmasi',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password tidak sesuai'
            ])->withInput();
        }

        // Hapus avatar jika ada
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Hapus semua data terkait user akan otomatis terhapus jika menggunakan cascade
        // Atau Anda bisa hapus manual satu per satu:
        // $user->wallets()->delete();
        // $user->categories()->delete();
        // $user->transactions()->delete();

        // Logout
        Auth::logout();

        // Hapus user
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.show')
            ->with('success', 'Akun Anda berhasil dihapus.');
    }
}
