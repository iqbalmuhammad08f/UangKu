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
    <div class="pb-6">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6 pb-6">
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
                                                {{ ucfirst($trx->category ? $trx->category->name : 'Transfer') }}
                                            </p>
                                            <p class="text-xs text-gray-400">{{ Str::limit($trx->description ?? '-', 20) }}</p>
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
                                    {{ $trx->type == 'income' ? '+' : '-' }} Rp
                                    {{ number_format($trx->amount, 0, ',', '.') }}
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
    </div>

@endsection

@push('modals')
    <x-modal-add-transaction :categories="$categories" :wallets="$wallets" />
    <x-modal id="deleteModal" title="Hapus Dompet" method="DELETE" button="Hapus">
        Apakah anda yakin ingin manghapus transaksi ini?
    </x-modal>
@endpush

@push('scripts')
    <script>
        function openDeleteModal(id) {
            document.getElementById('form-deleteModal').action = `/transactions/${id}`;
            toggleModal('deleteModal');
        }
    </script>
@endpush
