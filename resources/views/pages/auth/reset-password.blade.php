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

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reset-password') }}" method="POST" class="mb-3">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <x-input type="email" name="email" value="{{ $email ?? old('email') }}" icon="fa-solid fa-envelope" label="Alamat Email" />

            <x-input name="password" type="password" placeholder="Masukkan password baru" label="Password Baru"
                    icon="fa-solid fa-lock" />

            <x-input name="password_confirmation" type="password" placeholder="Ulangi password baru" label="Ulangi Password"
                    icon="fa-solid fa-lock" />

            <x-button type="submit">
                    Reset Password
                </x-button>
        </form>

        <a href="{{ route('login.show') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 font-medium transition text-sm">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Login
        </a>

    </div>

</div>
@endsection
