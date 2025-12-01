@extends('layouts.app')

@section('title', 'Edit Profil - DompetKu')

@section('header_title', 'Edit Profil')

@section('content.layout')
<div class="max-w-4xl mx-auto space-y-6 pb-6">

    {{-- Alert Messages --}}
    @if (session('success'))
        <x-toast type="success" message="{{ session('success') }}" />
    @endif

    @if (session('warning'))
        <x-toast type="warning" message="{{ session('warning') }}" />
    @endif

    {{-- Form Update Profil --}}
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
        @csrf
        @method('PUT')

        <div class="flex flex-col md:flex-row gap-8">

            {{-- Avatar Section --}}
            <div class="flex flex-col items-center space-y-4 md:w-1/3 border-b md:border-b-0 md:border-r border-gray-100 pb-6 md:pb-0 md:pr-6">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full border-4 border-gray-100 overflow-hidden shadow-inner">
                        <img id="avatarPreview"
                             src="{{ $user->avatar_url }}"
                             alt="Profile Picture"
                             class="w-full h-full object-cover">
                    </div>

                    <label for="fileInput" class="absolute bottom-1 right-1 bg-blue-600 text-white p-2 rounded-full shadow-lg cursor-pointer hover:bg-blue-700 transition transform hover:scale-110">
                        <i class="fa-solid fa-camera"></i>
                    </label>
                    <input type="file" id="fileInput" name="avatar" class="hidden" accept="image/jpeg,image/jpg,image/png">
                </div>

                <div class="text-center">
                    <p class="text-sm font-medium text-gray-700">Foto Profil</p>
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Max 2MB)</p>
                </div>

                @error('avatar')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Form Fields --}}
            <div class="flex-1 space-y-4">
                <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2 mb-4">Informasi Pribadi</h3>

                {{-- Nama Lengkap --}}
                <div>
                    <div class="relative">
                        <x-input name="name" type="text" label="Nama Lengkap" icon="fa-solid fa-user"
                            value="{{ old('name', $user->name) }}"
                            class="w-full"
                            required />
                    </div>
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <div class="relative">
                        <x-input name="email" type="email" label="Alamat Email" icon="fa-solid fa-envelope"
                            value="{{ old('email', $user->email) }}"
                            class="w-full"
                            required />
                    </div>
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-md flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Profil
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- Form Ganti Password --}}
    <form action="{{ route('profile.password.update') }}" method="POST"
          class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 md:p-8">
        @csrf
        @method('PUT')

        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Ganti Password</h3>
                <p class="text-xs text-gray-500">Amankan akun Anda dengan password yang kuat.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <x-input name="current_password" type="password" label="Password Saat Ini"
                    placeholder="••••••••" />
                @error('current_password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <x-input name="new_password" type="password" label="Password Baru" placeholder="Min. 8 karakter" />
                @error('new_password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <x-input name="new_password_confirmation" type="password" label="Konfirmasi Password" placeholder="Ulangi password baru" />
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-md">
                <i class="fa-solid fa-key mr-3"></i>
                Update Password
            </button>
        </div>
    </form>

    {{-- Delete Account Section --}}
    <div class="bg-red-50 rounded-xl border border-red-200 p-6 md:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex gap-4">
            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-red-700">Hapus Akun</h3>
                <p class="text-sm text-red-600/80 mt-1 max-w-lg">
                    Tindakan ini akan menghapus permanen data dompet, transaksi, dan kategori Anda. Data yang dihapus tidak dapat dikembalikan.
                </p>
            </div>
        </div>
        <button onclick="toggleModal('deleteAccountModal')"
                class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition shadow-md whitespace-nowrap">
            Ya, Hapus Akun Saya
        </button>
    </div>

</div>

{{-- Modal Delete Account --}}
<div id="deleteAccountModal" class="fixed inset-0 bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full mx-4 p-6">
        <div class="flex items-start gap-4 mb-4">
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Hapus Akun</h3>
                <p class="text-sm text-gray-600">
                    Semua data keuangan Anda akan <strong>hilang permanen</strong>. Tindakan ini tidak bisa dibatalkan.
                </p>
            </div>
        </div>

        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Masukkan password Anda untuk konfirmasi:
                </label>
                <x-input name="password" type="password" placeholder="Password Anda" required />
            </div>

            <div class="flex gap-3 justify-end">
                <button type="button"
                        onclick="toggleModal('deleteAccountModal')"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Preview image sebelum upload
    document.getElementById('fileInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection
