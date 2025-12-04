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

        $wallets = Wallet::where('user_id', $userId)->get();

        $categories = Category::where('user_id', $userId)->get();

        $transactions = Transaction::where('user_id', $userId)
            ->with(['wallet', 'category'])
            ->filter([
                'date' => $request->query('filter_date'),
                'category_id' => $request->query('filter_category_id'),
                'wallet_id' => $request->query('filter_wallet_id'),
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

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
            Transaction::create([
                'user_id' => Auth::id(),
                'wallet_id' => $request->wallet_id,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'type' => $request->type,
                'description' => $request->description,
                'date' => $request->date,
            ]);

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
            $wallet = Wallet::withTrashed()->findOrFail($transaction->wallet_id);

            if ($transaction->type == 'income') {
                $wallet->decrement('balance', $transaction->amount);
            } else {
                $wallet->increment('balance', $transaction->amount);
            }

            $transaction->delete();
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

    public function edit($id)
    {
        $userId = Auth::id();

        $transaction = Transaction::where('user_id', $userId)->with(['wallet', 'category'])->findOrFail($id);
        $wallets = Wallet::where('user_id', $userId)->get();
        $categories = Category::where('user_id', $userId)->get();

        return view('pages.transactions.edit', compact('transaction', 'wallets', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'wallet_id' => 'required|exists:wallets,id',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $userId = Auth::id();

        DB::transaction(function () use ($request, $id, $userId) {
            $transaction = Transaction::where('user_id', $userId)->findOrFail($id);

            $oldWallet = Wallet::withTrashed()->findOrFail($transaction->wallet_id);
            if ($transaction->type == 'income') {
                $oldWallet->decrement('balance', $transaction->amount);
            } else {
                $oldWallet->increment('balance', $transaction->amount);
            }

            $newWallet = Wallet::where('user_id', $userId)->findOrFail($request->wallet_id);
            if ($request->type == 'income') {
                $newWallet->increment('balance', $request->amount);
            } else {
                $newWallet->decrement('balance', $request->amount);
            }

            $transaction->update([
                'wallet_id' => $request->wallet_id,
                'category_id' => $request->category_id,
                'amount' => $request->amount,
                'type' => $request->type,
                'description' => $request->description,
                'date' => $request->date,
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }
}
