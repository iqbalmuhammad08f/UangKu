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

        $incomeRange = request()->query('income_range', 'month');
        $expenseRange = request()->query('expense_range', 'month');

        $recentTransactions = Transaction::where('user_id', $userId)
            ->with(['wallet', 'category'])
            ->latest('date')
            ->take(5)
            ->get();

        $wallets = Wallet::where('user_id', $userId)->get();

        $totalBalance = $wallets->sum('balance');

        $incomeThisMonth = Transaction::where('user_id', $userId)
            ->where('type', 'income');
        if ($incomeRange === 'month') {
            $incomeThisMonth->whereMonth('date', now()->month)
                ->whereYear('date', now()->year);
        }
        $incomeThisMonth = $incomeThisMonth->sum('amount');

        $expenseThisMonth = Transaction::where('user_id', $userId)
            ->where('type', 'expense');
        if ($expenseRange === 'month') {
            $expenseThisMonth->whereMonth('date', now()->month)
                ->whereYear('date', now()->year);
        }
        $expenseThisMonth = $expenseThisMonth->sum('amount');

        $categories = Category::where('user_id', $userId)->get();

        return view('pages.dashboard.index', compact(
            'recentTransactions',
            'wallets',
            'categories',
            'totalBalance',
            'incomeThisMonth',
            'expenseThisMonth',
            'incomeRange',
            'expenseRange'
        ));
    }
}
