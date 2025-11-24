@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="w-full flex flex-col justify-center items-center h-screen my-6">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-sm">

            <div class="flex items-center gap-2 mb-6">
                <div class="bg-blue-600 text-white p-2 rounded">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">UangKu</span>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Akun</h2>
            <p class="text-gray-500 mb-6">Lengkapi data diri di bawah ini.</p>


            <form class="space-y-4" action="{{ route('register') }}" method="POST">
                @csrf

                <x-input name="name" placeholder="Nama Anda: min 3 karakter" label="Nama Lengkap" icon="fas fa-user"
                    value="{{ old('name') }}" />

                <x-input name="email" placeholder="contoh@email.com" label="Email" icon="fa-solid fa-envelope"
                    value="{{ old('email') }}" />

                <x-input name="password" type="password" placeholder="Masukkan password: min 6 karakter" label="Password"
                    icon="fa-solid fa-lock" />

                <x-input name="password_confirmation" type="password" placeholder="Ulangi password" label="Ulangi Password"
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

                <x-button type="submit" icon="fas fa-user-plus">
                    Buat Akun
                </x-button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-600">
                Sudah memiliki akun? <a href="{{ route('login') }}"
                    class="text-blue-600 font-bold hover:underline">Masuk</a>
            </p>
        </div>
    </div>
@endsection
