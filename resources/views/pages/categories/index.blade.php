@extends('layouts.app')

@section('title', 'Kategori - DompetKu')
@section('header_title', 'Atur Kategori')

@push('styles')
<style>
    .tab-active { background-color: #eff6ff; color: #2563eb; border-color: #2563eb; }
    .tab-inactive { background-color: #ffffff; color: #6b7280; border-color: transparent; }
</style>
@endpush

@section('header_actions')
<button onclick="toggleModal('addCategoryModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-500/30 transition transform active:scale-95">
    <i class="fa-solid fa-plus"></i>
    <span class="hidden sm:inline">Tambah Kategori</span>
</button>
@endsection

@section('content.layout')
    <div class="flex justify-center mb-8">
        <div class="bg-white p-1 rounded-xl shadow-sm border border-gray-200 flex">
            <button id="btn-expense" onclick="switchTab('expense')" class="px-6 py-2 rounded-lg text-sm font-medium transition-all tab-active border border-transparent shadow-sm">
                <i class="fa-solid fa-arrow-trend-down mr-2"></i> Pengeluaran
            </button>
            <button id="btn-income" onclick="switchTab('income')" class="px-6 py-2 rounded-lg text-sm font-medium transition-all tab-inactive hover:bg-gray-50">
                <i class="fa-solid fa-arrow-trend-up mr-2"></i> Pemasukan
            </button>
        </div>
    </div>

    <div id="view-expense" class="block animate-fade-in">
        <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-4 ml-1">Daftar Pengeluaran</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between group hover:border-blue-300 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <span class="font-medium text-gray-700">Makan & Minum</span>
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                    <button class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen"></i></button>
                    <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between group hover:border-blue-300 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-bus"></i>
                    </div>
                    <span class="font-medium text-gray-700">Transportasi</span>
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                    <button class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen"></i></button>
                    <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>

             <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between group hover:border-blue-300 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <span class="font-medium text-gray-700">Tagihan & Listrik</span>
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                    <button class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen"></i></button>
                    <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>

        </div>
    </div>

    <div id="view-income" class="hidden animate-fade-in">
        <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-4 ml-1">Daftar Pemasukan</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between group hover:border-green-300 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-money-check-dollar"></i>
                    </div>
                    <span class="font-medium text-gray-700">Gaji Pokok</span>
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                    <button class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen"></i></button>
                    <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center justify-between group hover:border-green-300 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-gift"></i>
                    </div>
                    <span class="font-medium text-gray-700">Bonus / THR</span>
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                    <button class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pen"></i></button>
                    <button class="text-gray-400 hover:text-red-500 transition"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('modals')
    <x-modal-add-category />
@endpush

@push('scripts')
<script>
    function switchTab(type) {
        const viewExpense = document.getElementById('view-expense');
        const viewIncome = document.getElementById('view-income');
        const btnExpense = document.getElementById('btn-expense');
        const btnIncome = document.getElementById('btn-income');

        if (type === 'expense') {
            // Show Expense
            viewExpense.classList.remove('hidden');
            viewIncome.classList.add('hidden');

            // Update Button Style
            btnExpense.className = "px-6 py-2 rounded-lg text-sm font-medium transition-all tab-active border border-transparent shadow-sm";
            btnIncome.className = "px-6 py-2 rounded-lg text-sm font-medium transition-all tab-inactive border border-transparent hover:bg-gray-50";
        } else {
            // Show Income
            viewExpense.classList.add('hidden');
            viewIncome.classList.remove('hidden');

            // Update Button Style
            btnExpense.className = "px-6 py-2 rounded-lg text-sm font-medium transition-all tab-inactive border border-transparent hover:bg-gray-50";
            btnIncome.className = "px-6 py-2 rounded-lg text-sm font-medium transition-all tab-active border border-transparent shadow-sm";
        }
    }

    // Fungsi helper untuk memilih warna di modal (hanya contoh visual)
    function selectColor(color) {
        // Implementasi logika seleksi (misal menambah border tebal pada yang dipilih)
        document.getElementById('selectedColor').value = color;
        // alert('Warna terpilih: ' + color);
    }
</script>
@endpush
