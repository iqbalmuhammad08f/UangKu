@extends('layouts.app')

@section('title', 'Dashboard - DompetKu')
@section('header_title', 'Overview Keuangan')

@section('header_actions')
<button onclick="toggleModal('addTransactionModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-500/30 transition transform active:scale-95">
    <i class="fa-solid fa-plus"></i>
    <span class="hidden sm:inline">Transaksi Baru</span>
</button>
@endsection

@section('content.layout')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-blue-100 text-sm font-medium mb-1">Total Saldo</p>
                <h3 class="text-3xl font-bold">Rp 12.500.000</h3>
            </div>
            <i class="fa-solid fa-wallet absolute -bottom-4 -right-4 text-8xl text-white opacity-10"></i>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pemasukan Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">Rp 8.200.000</h3>
                </div>
                <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pengeluaran Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-2">Rp 3.450.000</h3>
                </div>
                <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                    <i class="fa-solid fa-arrow-trend-down"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800">Dompet Saya</h3>
                <a href="#" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-gray-800">BCA</p>
                            <p class="text-xs text-gray-500">Bank</p>
                        </div>
                    </div>
                    <span class="font-bold text-gray-700 text-sm">Rp 5.000.000</span>
                </div>
                </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800">Transaksi Terakhir</h3>
                <button class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-filter"></i></button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase border-b border-gray-100">
                            <th class="py-3 font-medium">Kategori</th>
                            <th class="py-3 font-medium">Tanggal</th>
                            <th class="py-3 font-medium">Wallet</th>
                            <th class="py-3 font-medium text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <tr class="group hover:bg-gray-50 transition-colors border-b border-gray-50">
                            <td class="py-3 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center">
                                    <i class="fa-solid fa-utensils text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Makan Siang</p>
                                    <p class="text-xs text-gray-400">Nasi Padang</p>
                                </div>
                            </td>
                            <td class="py-3 text-gray-500">22 Nov 2023</td>
                            <td class="py-3 text-gray-500">Uang Tunai</td>
                            <td class="py-3 text-right font-medium text-red-500">- Rp 25.000</td>
                        </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <x-modal-add-transaction />
@endpush
