<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // 1. Ambil Data untuk Dropdown (Filter & Modal)
        $wallets = Wallet::where('user_id', $userId)->get();

        // Ambil kategori custom user + kategori global (jika masih menggunakan konsep global)
        // Sesuai request terakhir Anda (semua kategori dicopy ke user), cukup ambil based on user_id
        $categories = Category::where('user_id', $userId)->get();

        // 2. Query Transaksi dengan Filter & Pagination
        $transactions = Transaction::where('user_id', $userId)
            ->with(['wallet', 'category']) // Eager Load biar query ringan
            ->filter([
                'date' => $request->query('filter_date'),
                'category_id' => $request->query('filter_category_id'),
                'wallet_id' => $request->query('filter_wallet_id'),
            ])
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10)   // Pagination 10 data
            ->withQueryString(); // Agar parameter filter tetap ada saat pindah halaman

        return view('pages.transactions.index', compact('transactions', 'wallets', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'wallet_id' => 'required|exists:wallets,id',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan Transaksi
            Transaction::create([
                'user_id' => Auth::id(),
                'wallet_id' => $request->wallet_id,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'type' => $request->type,
                'description' => $request->description,
                'date' => $request->date,
            ]);

            // 2. Update Saldo Dompet
            $wallet = Wallet::where('user_id', Auth::id())->findOrFail($request->wallet_id);
            if ($request->type == 'income') {
                $wallet->increment('balance', $request->amount);
            } else {
                $wallet->decrement('balance', $request->amount);
            }
        });

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);

        DB::transaction(function () use ($transaction) {
            // 1. Kembalikan Saldo Dompet (Reverse Logic)
            $wallet = Wallet::withTrashed()->findOrFail($transaction->wallet_id);

            if ($transaction->type == 'income') {
                // Kalau tadinya pemasukan dihapus, saldo dompet dikurangi
                $wallet->decrement('balance', $transaction->amount);
            } else {
                // Kalau tadinya pengeluaran dihapus, uang dikembalikan ke dompet
                $wallet->increment('balance', $transaction->amount);
            }

            // 2. Hapus Transaksi
            $transaction->delete();
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
