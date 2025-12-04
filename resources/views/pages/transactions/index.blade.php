@extends('layouts.app')

@section('title', 'Riwayat Transaksi - DompetKu')
@section('header_title', 'Semua Transaksi')


@section('content.layout')

    @if (session('success'))
        <x-toast type="success" message="{{ session('success') }}" />
    @endif
    @if (session('error'))
        <x-toast type="error" message="{{ session('error') }}" />
    @endif


    <div class="pb-6">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6 pb-6">
            <form method="GET" action="{{ route('transactions.index') }}"
                class="flex flex-col md:flex-row justify-between gap-4">

                <div class="flex flex-col md:flex-row gap-4 w-full">
                    <input type="month" name="filter_date" value="{{ request('filter_date') }}"
                        class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm text-gray-600">

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

                    <button type="submit"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-filter mr-1"></i> Filter
                    </button>

                    <a href="{{ route('transactions.index') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium transition flex items-center justify-center">
                        Reset
                    </a>
                </div>

                <button type="button" onclick="toggleModal('addTransactionModal')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30 transition transform active:scale-95 whitespace-nowrap">
                    <i class="fa-solid fa-plus"></i>
                    <span class="hidden sm:inline">Transaksi Baru</span>
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-semibold">
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Kategori & Deskripsi</th>
                            <th class="p-4 pl-0">Dompet</th>
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
                                        <div
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-xs
                                            {{ $trx->type == 'income' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                            <i class="fa-solid {{ $trx->category->icon ?? 'fa-circle' }}"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">
                                                {{ ucfirst($trx->category ? $trx->category->name : 'Transfer') }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                {{ ucfirst(Str::limit($trx->description ?? '-', 20)) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-gray-500">{{ ucwords($trx->wallet->name) }}</td>
                                <td
                                    class="p-4 text-right font-bold whitespace-nowrap {{ $trx->type == 'income' ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $trx->type == 'income' ? '+' : '-' }} Rp
                                    {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="text-blue-500 hover:text-blue-700 transition" title="Edit Transaksi"
                                            onclick="openEditModal(this)" data-id="{{ $trx->id }}"
                                            data-amount="{{ $trx->amount }}"
                                            data-date="{{ $trx->date->format('Y-m-d') }}" data-type="{{ $trx->type }}"
                                            data-description="{{ $trx->description }}"
                                            data-wallet-id="{{ $trx->wallet_id }}"
                                            data-category-id="{{ $trx->category_id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button onclick="openDeleteModal('{{ $trx->id }}')"
                                            class="text-red-500 hover:text-red-700 transition" title="Hapus Transaksi">
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

            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                {{ $transactions->links('components.pagenation') }}
            </div>
        </div>
    </div>

@endsection

@push('modals')
    <x-modal-add-transaction :categories="$categories" :wallets="$wallets" />
    <x-modal id="deleteModal" title="Hapus Transaksi" method="DELETE" button="Hapus">
        Apakah anda yakin ingin menghapus transaksi ini?
    </x-modal>
    <x-modal-edit-transaction :categories="$categories" :wallets="$wallets" />
@endpush

@push('scripts')
    <script>
        function openDeleteModal(id) {
            document.getElementById('form-deleteModal').action = `/transactions/${id}`;
            toggleModal('deleteModal');
        }

        function openEditModal(el) {
            const id = el.getAttribute('data-id');
            const amount = el.getAttribute('data-amount');
            const date = el.getAttribute('data-date');
            const type = el.getAttribute('data-type');
            const description = el.getAttribute('data-description');
            const walletId = el.getAttribute('data-wallet-id');
            const categoryId = el.getAttribute('data-category-id');

            document.getElementById('form-editTransactionModal').action = `/transactions/${id}`;

            document.getElementById('edit_amount').value = amount;
            document.getElementById('edit_date').value = date;
            document.getElementById('edit_description').value = description || '';
            document.getElementById('edit_wallet_select').value = walletId;

            const radios = document.querySelectorAll('#editTransactionModal input[name="type"]');
            radios.forEach(r => r.checked = (r.value === type));

            window.filterCategoriesForEdit(type);
            document.getElementById('edit_category_select').value = categoryId;

            toggleModal('editTransactionModal');
        }
    </script>
@endpush
