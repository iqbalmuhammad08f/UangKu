@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden p-8 mx-4 text-center">

        <div class="bg-blue-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-lock text-3xl text-blue-600"></i>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">Lupa Password?</h1>
        <p class="text-gray-500 text-sm mb-8">
            Masukkan email yang terdaftar untuk memperbarui password.
        </p>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('forgot-password') }}" method="POST">
            @csrf
            <x-input name="email" type="email" placeholder="Masukkan email" label="Email"
                    icon="fa-solid fa-envelope" value="{{ old('email') }}" />
            <x-button type="submit" icon="fa-solid fa-paper-plane rotate-45" iconPosition="right">
                    Kirim
                </x-button>
        </form>

        <a href="{{ route('login') }}" class="inline-flex mt-8 items-center text-gray-600 hover:text-blue-600 font-medium transition text-sm">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Login
        </a>

    </div>

</div>
@endsection
