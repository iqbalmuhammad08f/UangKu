@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden p-8 mx-4 text-center">
        
        <div class="bg-blue-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-key text-3xl text-blue-600"></i>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">Reset Password</h1>
        <p class="text-gray-500 text-sm mb-8">
            Buat password baru untuk akun Anda.
        </p>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-4 text-left">
                <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input 
                        type="email" 
                        id="email"
                        name="email" 
                        value="{{ $email ?? old('email') }}"
                        class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 bg-gray-50 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('email') border-red-500 @enderror" 
                        required
                        readonly
                    >
                </div>
            </div>

            <div class="mb-4 text-left">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password Baru</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        placeholder="Masukkan password baru (min. 6 karakter)" 
                        class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all @error('password') border-red-500 @enderror" 
                        required
                        autofocus
                    >
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 text-left">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-medium mb-2">Konfirmasi Password Baru</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input 
                        type="password" 
                        id="password_confirmation"
                        name="password_confirmation" 
                        placeholder="Ulangi password baru" 
                        class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" 
                        required
                    >
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md hover:shadow-lg transition duration-200 mb-6">
                Reset Password
            </button>
        </form>

        <a href="{{ route('login') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 font-medium transition text-sm">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Login
        </a>

    </div>

</div>
@endsection