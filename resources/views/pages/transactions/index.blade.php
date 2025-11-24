@extends('layouts.app')

@section('title', 'Riwayat Transaksi - DompetKu')
@section('header_title', 'Semua Transaksi')

@push('styles')
<style>
    /* Custom Scrollbar untuk Tabel jika diperlukan */
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('header_actions')
<button onclick="toggleModal('addTransactionModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-500/30 transition transform active:scale-95">
    <i class="fa-solid fa-plus"></i>
    <span class="hidden sm:inline">Transaksi Baru</span>
</button>
@endsection

@section('content.layout')
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
        <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative">
                <i class="fa-solid fa-search absolute left-3 top-3 text-gray-400"></i>
                <input type="text" placeholder="Cari deskripsi..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm">
            </div>

            <input type="month" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm text-gray-600">

            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm text-gray-600 bg-white">
                <option value="">Semua Kategori</option>
                <option value="1">Makan & Minum</option>
                <option value="2">Transportasi</option>
                <option value="3">Gaji</option>
            </select>

            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm text-gray-600 bg-white">
                <option value="">Semua Dompet</option>
                <option value="1">BCA</option>
                <option value="2">Cash</option>
            </select>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-semibold">
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Kategori & Deskripsi</th>
                        <th class="p-4">Dompet</th>
                        <th class="p-4 text-right">Jumlah</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">

                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-gray-500 whitespace-nowrap">22 Nov 2023</td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-utensils"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Makan Siang</p>
                                    <p class="text-xs text-gray-500">Nasi Padang + Es Teh</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                Tunai
                            </span>
                        </td>
                        <td class="p-4 text-right font-bold text-red-500 whitespace-nowrap">
                            - Rp 25.000
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="text-gray-400 hover:text-red-600 transition"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-gray-500 whitespace-nowrap">20 Nov 2023</td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-sack-dollar"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">Gaji Bulanan</p>
                                    <p class="text-xs text-gray-500">Transfer dari Kantor</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100">
                                BCA
                            </span>
                        </td>
                        <td class="p-4 text-right font-bold text-green-600 whitespace-nowrap">
                            + Rp 5.000.000
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="text-gray-400 hover:text-red-600 transition"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between bg-gray-50">
            <span class="text-xs text-gray-500">Menampilkan <b>1-10</b> dari <b>45</b> data</span>
            <div class="flex gap-1">
                <button class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-600 text-xs hover:bg-gray-50">Prev</button>
                <button class="px-3 py-1 rounded border border-blue-500 bg-blue-50 text-blue-600 text-xs font-bold">1</button>
                <button class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-600 text-xs hover:bg-gray-50">2</button>
                <button class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-600 text-xs hover:bg-gray-50">Next</button>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div id="addTransactionModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity" onclick="toggleModal('addTransactionModal')"></div>

        <div class="relative flex min-h-full items-center justify-center p-4">
            <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl transform transition-all scale-100 overflow-hidden animate-fade-in-down">

                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Tambah Transaksi Baru</h3>
                    <button onclick="toggleModal('addTransactionModal')" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form action="#" method="POST" class="p-6 space-y-4">
                    @csrf <div class="grid grid-cols-2 gap-2 p-1 bg-gray-100 rounded-lg mb-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="expense" class="peer sr-only" checked>
                            <div class="text-center py-2 text-sm font-medium rounded-md text-gray-500 peer-checked:bg-white peer-checked:text-red-500 peer-checked:shadow-sm transition-all">
                                Pengeluaran
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="income" class="peer sr-only">
                            <div class="text-center py-2 text-sm font-medium rounded-md text-gray-500 peer-checked:bg-white peer-checked:text-green-600 peer-checked:shadow-sm transition-all">
                                Pemasukan
                            </div>
                        </label>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Jumlah (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400 font-bold">Rp</span>
                            <input type="number" name="amount" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none font-bold text-gray-800 placeholder-gray-300" placeholder="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tanggal</label>
                        <input type="date" name="date" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Kategori</label>
                            <select name="category_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm bg-white">
                                <option>Makan</option>
                                <option>Transport</option>
                                <option>Belanja</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Dompet</label>
                            <select name="wallet_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm bg-white">
                                <option>BCA</option>
                                <option>Tunai</option>
                                <option>GoPay</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Catatan (Opsional)</label>
                        <textarea name="description" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm resize-none" placeholder="Contoh: Nasi Padang"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-lg shadow-blue-500/30 transition transform active:scale-95">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('modals')
    <x-modal-add-transaction />
@endpush
