@extends('layouts.app')

@section('title', 'Dompet Saya - DompetKu')
@section('header_title', 'Manajemen Dompet')

@section('content.layout')
    <div
        class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl p-8 text-white shadow-xl mb-8 relative overflow-hidden">
        <div class="relative z-10 flex justify-between items-end">
            <div>
                <p class="text-slate-400 text-sm font-medium mb-2">Total Aset</p>
                <h1 class="text-4xl font-bold tracking-tight">Rp 12.500.000</h1>
            </div>
        </div>
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-500 rounded-full opacity-10 blur-3xl"></div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-700">Daftar Dompet</h3>
        <button onclick="toggleModal('transferModal')"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-lg shadow-blue-500/30 transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-right-arrow-left"></i>
            Transfer Saldo
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition relative group">
            <div class="flex justify-between items-start mb-4">
                <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Bank</p>
                <div class="flex gap-2">
                    <button class="text-blue-600 transition"><i class="fa-solid fa-pen"></i></button>
                    <button class="text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
            <div>
                <h4 class="text-lg font-bold text-gray-800 mt-1">BCA Utama</h4>
                <p class="text-2xl font-bold text-blue-600 mt-3">Rp 5.000.000</p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center text-xs text-gray-400">
                <span>Updated: Hari ini</span>
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
    <div id="transferModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0  bg-opacity-50 backdrop-blur-sm transition-opacity"
            onclick="toggleModal('transferModal')"></div>
        <div class="relative flex min-h-full items-center justify-center p-4">
            <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 animate-fade-in-up">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Transfer Antar Dompet</h3>
                    <button onclick="toggleModal('transferModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Dari</label>
                            <select name="from_wallet_id" class="w-full px-3 py-2 border rounded-lg text-sm bg-white">
                                <option value="1">BCA Utama</option>
                                <option value="2">GoPay</option>
                            </select>
                        </div>
                        <div class="pt-4 text-gray-400"><i class="fa-solid fa-arrow-right"></i></div>
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Ke</label>
                            <select name="to_wallet_id" class="w-full px-3 py-2 border rounded-lg text-sm bg-white">
                                <option value="3">Tunai</option>
                                <option value="1">BCA Utama</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jumlah Transfer</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-400">Rp</span>
                            <input type="number" name="amount"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                placeholder="0">
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-gray-800 text-white py-3 rounded-lg font-bold hover:bg-gray-900 transition transform active:scale-95">
                        Proses Transfer
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div id="addWalletModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity"
            onclick="toggleModal('addWalletModal')"></div>
        <div class="relative flex min-h-full items-center justify-center p-4">
            <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 animate-fade-in-up">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Buat Dompet Baru</h3>
                    <button onclick="toggleModal('addWalletModal')" class="text-gray-400 hover:text-gray-600">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Dompet</label>
                        <input type="text" name="name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                            placeholder="Misal: Tabungan Nikah">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jenis</label>
                        <select name="type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="bank">Bank</option>
                            <option value="ewallet">E-Wallet</option>
                            <option value="cash">Tunai</option>
                            <option value="investment">Investasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Saldo Awal</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-400">Rp</span>
                            <input type="number" name="balance"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                                placeholder="0">
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition transform active:scale-95">
                        Simpan Dompet
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

