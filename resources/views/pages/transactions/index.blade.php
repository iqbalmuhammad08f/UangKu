@extends('layouts.app')

@section('title', 'Riwayat Transaksi - DompetKu')
@section('header_title', 'Semua Transaksi')

@push('styles')
    <style>
        /* Custom Scrollbar untuk Tabel */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endpush

@section('content.layout')

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}</div>
    @endif

    <!-- SECTION FILTER -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
        <form method="GET" action="{{ route('transactions.index') }}"
            class="flex flex-col md:flex-row justify-between gap-4">

            <div class="flex flex-col md:flex-row gap-4 w-full">
                <!-- Filter Bulan -->
                <input type="month" name="filter_date" value="{{ request('filter_date') }}"
                    class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm text-gray-600">

                <!-- Filter Kategori -->
                <select name="filter_category_id"
                    class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm text-gray-600 bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            {{ request('filter_category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }} ({{ $cat->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }})
                        </option>
                    @endforeach
                </select>

                <!-- Filter Dompet -->
                <select name="filter_wallet_id"
                    class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm text-gray-600 bg-white">
                    <option value="">Semua Dompet</option>
                    @foreach ($wallets as $wall)
                        <option value="{{ $wall->id }}"
                            {{ request('filter_wallet_id') == $wall->id ? 'selected' : '' }}>
                            {{ $wall->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Tombol Cari -->
                <button type="submit"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    <i class="fa-solid fa-filter mr-1"></i> Filter
                </button>

                <!-- Tombol Reset (Optional) -->
                <a href="{{ route('transactions.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center justify-center">
                    Reset
                </a>
            </div>

            <!-- Tombol Tambah -->
            <button type="button" onclick="toggleModal('addTransactionModal')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30 transition transform active:scale-95 whitespace-nowrap">
                <i class="fa-solid fa-plus"></i>
                <span class="hidden sm:inline">Transaksi Baru</span>
            </button>
        </form>
    </div>

    <!-- SECTION TABEL -->
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
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50 transition group">
                            <td class="p-4 text-gray-500 whitespace-nowrap">
                                {{ $trx->date->format('d M Y') }}
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <p class="font-semibold text-gray-600">
                                            {{ ucwords($trx->category ? $trx->category->name : 'Transfer') }}
                                        </p>
                                        <p class="text-xs text-gray-500 line-clamp-1">{{ $trx->description ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200 whitespace-nowrap">
                                    {{ ucwords($trx->wallet->name) ?? 'Terhapus' }}
                                </span>
                            </td>
                            <td
                                class="p-4 text-right font-bold whitespace-nowrap {{ $trx->type == 'income' ? 'text-green-600' : 'text-red-500' }}">
                                {{ $trx->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openDeleteModal('{{ $trx->id }}')"
                                        class="text-red-500 hover:text-red-700 transition" title="Hapus Dompet">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-receipt text-4xl mb-3"></i>
                                    <p>Belum ada data transaksi.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Laravel -->
        <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
            {{ $transactions->links('components.pagenation') }}
            <!-- Pastikan di AppServiceProvider menggunakan Paginator::useTailwind() -->
        </div>
    </div>
@endsection

@push('modals')
    <!-- MODAL TAMBAH TRANSAKSI -->
    <div id="addTransactionModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-opacity-50 backdrop-blur-sm transition-opacity flex items-center justify-center"
            onclick="toggleModal('addTransactionModal')"></div>

        <div class="relative flex min-h-full items-center justify-center p-4">
            <div
                class="bg-white w-full max-w-md rounded-2xl shadow-2xl transform transition-all scale-100 overflow-hidden animate-fade-in-down">

                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Tambah Transaksi Baru</h3>
                    <button type="button" onclick="toggleModal('addTransactionModal')"
                        class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form action="{{ route('transactions.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf

                    <!-- Tipe -->
                    <div class="grid grid-cols-2 gap-2 p-1 bg-gray-100 rounded-lg mb-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="expense" class="peer sr-only" checked
                                onchange="filterCategories('expense')">
                            <div
                                class="text-center py-2 text-sm font-medium rounded-md text-gray-500 peer-checked:bg-white peer-checked:text-red-500 peer-checked:shadow-sm transition-all">
                                Pengeluaran
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="income" class="peer sr-only"
                                onchange="filterCategories('income')">
                            <div
                                class="text-center py-2 text-sm font-medium rounded-md text-gray-500 peer-checked:bg-white peer-checked:text-green-600 peer-checked:shadow-sm transition-all">
                                Pemasukan
                            </div>
                        </label>
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jumlah (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400 font-bold">Rp</span>
                            <input type="number" name="amount"
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none font-bold text-gray-800 placeholder-gray-300"
                                placeholder="0" required>
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm"
                            required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Kategori -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori</label>
                            <select name="category_id" id="modal_category_select"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm bg-white"
                                required>
                                <option value="">Pilih Kategori</option>
                                <!-- Opsi diisi via JS agar dinamis sesuai tipe -->
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" data-type="{{ $cat->type }}">
                                        {{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Dompet -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Dompet</label>
                            <select name="wallet_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm bg-white"
                                required>
                                @foreach ($wallets as $wall)
                                    <option value="{{ $wall->id }}">{{ $wall->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Catatan (Opsional)</label>
                        <textarea name="description" rows="2"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm resize-none"
                            placeholder="Contoh: Nasi Padang"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-lg shadow-blue-500/30 transition transform active:scale-95">
                            <i class="fa-solid fa-floppy-disk mr-2"></i>
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('modals')
    <x-modal id="deleteModal" title="Hapus Dompet" method="DELETE" button="Hapus">
        Apakah anda yakin ingin manghapus transaksi ini?
    </x-modal>
@endpush

@push('scripts')
    <script>
        // Script Sederhana untuk Filter Kategori di Modal (Income vs Expense)
        function filterCategories(type) {
            const select = document.getElementById('modal_category_select');
            const options = select.querySelectorAll('option');

            // Reset selection
            select.value = "";

            options.forEach(option => {
                if (option.value === "") return; // Skip placeholder

                const catType = option.getAttribute('data-type');
                if (catType === type) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        }

        // Jalankan sekali saat load agar sesuai default (expense)
        document.addEventListener('DOMContentLoaded', function() {
            filterCategories('expense');
        });

        function openDeleteModal(id) {
            document.getElementById('form-deleteModal').action = `/transactions/${id}`;
            toggleModal('deleteModal');
        }
    </script>
@endpush
