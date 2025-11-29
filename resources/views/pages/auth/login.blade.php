@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="flex justify-center items-center h-dvh">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden p-8 mx-4">

            <div class="text-center mb-8">
                <div class="flex justify-center items-center gap-2 mb-6">
                    <div class="bg-blue-600 text-white p-2 rounded-lg">
                        <i class="fa-solid fa-wallet text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800 cursor-default">UangKu</h1>
                </div>
                <p class="text-gray-500 text-sm">Selamat datang kembali, silakan masukkan akun anda.</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <x-input name="email" type="email" placeholder="Masukkan email" label="Email"
                    icon="fa-solid fa-envelope" value="{{ old('email') }}" />

                <x-input name="password" type="password" placeholder="Masukkan password" label="Password"
                    icon="fa-solid fa-lock" />
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="flex justify-end mb-6">
                    <a href="{{ route('forgot-password.show') }}"
                        class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lupa Password?</a>
                </div>
                <x-button type="submit" icon="fa-solid fa-right-to-bracket">
                    Masuk
                </x-button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register.show') }}" class="text-blue-600 font-bold hover:underline">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>
    @if (session('success'))
        <x-toast type="success" message="{{ session('success') }}" />
    @endif
@endsection
