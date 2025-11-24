@extends('layouts.app')

@section('title', 'Dompet Saya - DompetKu')
@section('header_title', 'Manajemen Dompet')

@section('content.layout')
    <div
        class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl p-8 text-white shadow-xl mb-8 relative overflow-hidden">
        <div class="relative z-10 flex justify-between items-end">
            <div>
                <p class="text-slate-400 text-sm font-medium mb-2">Total Aset Bersih</p>
                <h1 class="text-4xl font-bold tracking-tight">Rp 12.500.000</h1>
            </div>
            <div class="hidden md:block text-right">
                <p class="text-slate-400 text-xs">Perubahan Bulan Ini</p>
                <p class="text-green-400 font-semibold">+ Rp 2.400.000 <i class="fa-solid fa-arrow-trend-up ml-1"></i></p>
            </div>
        </div>
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-500 rounded-full opacity-10 blur-3xl"></div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-700">Daftar Dompet</h3>
        <button onclick="toggleModal('transferModal')"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-lg shadow-blue-500/30 transition flex items-center gap-2">
            <i class="fa-solid fa-money-bill-transfer"></i> Transfer Saldo
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition relative group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                    <button class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen"></i></button>
                    <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
            <div>
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Bank Account</p>
                <h4 class="text-lg font-bold text-gray-800 mt-1">BCA Utama</h4>
                <p class="text-2xl font-bold text-blue-600 mt-3">Rp 5.000.000</p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400">
                <span>No. Rek: **** 8899</span>
                <span>Updated: Hari ini</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition relative group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                    <button class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen"></i></button>
                    <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
            <div>
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Cash / Tunai</p>
                <h4 class="text-lg font-bold text-gray-800 mt-1">Dompet Fisik</h4>
                <p class="text-2xl font-bold text-green-600 mt-3">Rp 500.000</p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400">
                <span>Di tangan</span>
                <span>Updated: Kemarin</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition relative group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-mobile-screen"></i>
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                    <button class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen"></i></button>
                    <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
            <div>
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">E-Wallet</p>
                <h4 class="text-lg font-bold text-gray-800 mt-1">GoPay</h4>
                <p class="text-2xl font-bold text-purple-600 mt-3">Rp 250.000</p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400">
                <span>0812-3456-7890</span>
                <span>Updated: 2 Jam lalu</span>
            </div>
        </div>

        <button onclick="toggleModal('addWalletModal')"
            class="border-2 border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center text-gray-400 hover:border-blue-500 hover:text-blue-500 transition h-full min-h-[200px] group bg-gray-50 hover:bg-blue-50/50">
            <div
                class="w-12 h-12 rounded-full bg-white border border-gray-200 flex items-center justify-center mb-3 group-hover:border-blue-300 group-hover:text-blue-500 transition">
                <i class="fa-solid fa-plus text-xl"></i>
            </div>
            <span class="font-medium">Tambah Dompet Baru</span>
        </button>

    </div>
@endsection

@push('modals')
    <x-modal-add-wallet />
    <x-modal-transfer />
@endpush
