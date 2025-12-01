<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        // Read filter from the request query params
        $incomeRange = request()->query('income_range', 'month'); // 'month' or 'all'
        $expenseRange = request()->query('expense_range', 'month'); // 'month' or 'all'

        // Ambil 5 transaksi terbaru
        $recentTransactions = Transaction::where('user_id', $userId)
            ->with(['wallet', 'category'])
            ->latest('created_at')
            ->take(5)
            ->get();

        // Ambil semua wallet user
        $wallets = Wallet::where('user_id', $userId)->get();

        // Hitung total saldo dari semua wallet
        $totalBalance = $wallets->sum('balance');

        // Hitung pemasukan bulan ini
        // Income: either for this month or all time, depending on $incomeRange
        $incomeThisMonth = Transaction::where('user_id', $userId)
            ->where('type', 'income');
        if ($incomeRange === 'month') {
            $incomeThisMonth->whereMonth('date', now()->month)
                ->whereYear('date', now()->year);
        }
        $incomeThisMonth = $incomeThisMonth->sum('amount');

        // Hitung pengeluaran bulan ini
        // Expense: either for this month or all time, depending on $expenseRange
        $expenseThisMonth = Transaction::where('user_id', $userId)
            ->where('type', 'expense');
        if ($expenseRange === 'month') {
            $expenseThisMonth->whereMonth('date', now()->month)
                ->whereYear('date', now()->year);
        }
        $expenseThisMonth = $expenseThisMonth->sum('amount');

        // Tambahkan di dashboard controller
        $categories = Category::where('user_id', $userId)->get();

        return view('pages.dashboard.index', compact(
            'recentTransactions',
            'wallets',
            'categories',  // Tambahkan ini
            'totalBalance',
            'incomeThisMonth',
            'expenseThisMonth',
            'incomeRange',
            'expenseRange'
        ));
    }
}
