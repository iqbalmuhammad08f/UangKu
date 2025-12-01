@extends('layouts.app')

@section('title', 'Dashboard - DompetKu')
@section('header_title', 'Overview Keuangan')

@section('header_actions')
    <button onclick="toggleModal('addTransactionModal')"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 shadow-lg shadow-blue-500/30 transition transform active:scale-95">
        <i class="fa-solid fa-plus"></i>
        <span class="hidden sm:inline">Transaksi Baru</span>
    </button>
@endsection

@section('content.layout')
    @if (session('success'))
        <x-toast type="success" message="{{ session('success') }}" />
    @endif
    @if (session('error'))
        <x-toast type="error" message="{{ session('error') }}" />
    @endif
    <!-- Card Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-6 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-blue-100 text-sm font-medium mb-4">Total Saldo</p>
                <h3 class="text-3xl font-bold">Rp {{ number_format($totalBalance, 0, ',', '.') }}</h3>
            </div>
            <i class="fa-solid fa-wallet absolute -bottom-4 -right-1 text-8xl text-white opacity-10"></i>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between">
                <p class="text-gray-500 font-medium">
                    {{ $incomeRange === 'all' ? 'Pemasukan' : 'Pemasukan' }}
                </p>
                <form method="GET" action="{{ route('dashboard.index') }}">
                    <input type="hidden" name="expense_range" value="{{ $expenseRange }}">
                    <select name="income_range" onchange="this.form.submit()" class="text-gray-500 text-sm font-medium">
                        <option value="month" {{ $incomeRange === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="all" {{ $incomeRange === 'all' ? 'selected' : '' }}>Semua</option>
                    </select>
                </form>
            </div>
            <div class="flex justify-between border border-green-300 bg-green-100 text-green-600 p-3 rounded-lg">
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}
                </h3>
                <div class="flex justify-center items-center">
                    <i class="fa-solid fa-arrow-trend-up text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 space-y-4">
            <div class="flex justify-between">
                <p class="text-gray-500 font-medium">
                    {{ $expenseRange === 'all' ? 'Pengeluaran' : 'Pengeluaran' }}
                </p>
                <form method="GET" action="{{ route('dashboard.index') }}">
                    <input type="hidden" name="income_range" value="{{ $incomeRange }}">
                    <select name="expense_range" onchange="this.form.submit()" class="text-gray-500 text-sm font-medium">
                        <option value="month" {{ $expenseRange === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="all" {{ $expenseRange === 'all' ? 'selected' : '' }}>Semua</option>
                    </select>
                </form>
            </div>
            <div class="flex justify-between border border-red-300 bg-red-100 text-red-600 p-3 rounded-lg">
                <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($expenseThisMonth, 0, ',', '.') }}
                </h3>
                <div class="flex justify-center items-center">
                    <i class="fa-solid fa-arrow-trend-down text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Dompet Saya (Scrollable) -->
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800">Dompet Saya</h3>
                <span class="text-xs text-gray-400">{{ $wallets->count() }} Dompet</span>
            </div>

            <!-- Container dengan scroll -->
            <div class="space-y-3 max-h-[310px] overflow-y-auto pr-2 custom-scrollbar pb-2">
                @forelse($wallets as $wallet)
                    <div
                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-coins text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-800">{{ ucwords($wallet->name) }}</p>
                            </div>
                        </div>
                        <span class="font-medium text-gray-600 text-sm">
                            Rp {{ number_format($wallet->balance, 0, ',', '.') }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400">
                        <i class="fa-solid fa-wallet text-3xl mb-2"></i>
                        <p class="text-sm">Belum ada dompet</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Transaksi Terakhir (5 Terbaru) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-gray-800">Transaksi Terakhir</h3>
                <a href="{{ route('transactions.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 text-xs uppercase border-b border-gray-100">
                            <th class="py-3 font-medium">Tanggal</th>
                            <th class="py-3 font-medium">Kategori</th>
                            <th class="py-3 font-medium">Wallet</th>
                            <th class="py-3 font-medium text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($recentTransactions as $transaction)
                            <tr class="group hover:bg-gray-50 transition-colors border-b border-gray-50">
                                <td class="py-3 text-gray-500">
                                    {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-xs
                                            {{ $transaction->type == 'income' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                            <i class="fa-solid {{ $transaction->category->icon ?? 'fa-circle' }}"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">
                                                {{ ucfirst($transaction->category ? $transaction->category->name : 'Transfer') }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                {{ ucfirst(Str::limit($transaction->description ?? '-', 20)) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-gray-500">{{ ucwords($transaction->wallet->name) }}</td>
                                <td
                                    class="py-3 text-right font-medium
                                    {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $transaction->type == 'income' ? '+' : '-' }}
                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400">
                                    <i class="fa-solid fa-receipt text-3xl mb-2"></i>
                                    <p class="text-sm">Belum ada transaksi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('modals')
    <x-modal-add-transaction :categories="$categories" :wallets="$wallets" />
@endpush
