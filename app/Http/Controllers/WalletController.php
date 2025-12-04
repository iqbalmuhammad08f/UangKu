<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::id())->get();

        $totalBalance = $wallets->sum('balance');

        return view('pages.wallets.index', compact('wallets', 'totalBalance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'nullable|numeric|min:0'
        ]);

        $exists = Wallet::where('user_id', Auth::id())
            ->where('name', strtolower($request->name))
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Dompet dengan nama tersebut sudah Anda miliki.');
        }

        Wallet::create([
            'user_id' => Auth::id(),
            'name' => strtolower($request->name),
            'balance' => $request->balance ?? 0,
        ]);

        return redirect()->back()->with('success', 'Dompet berhasil dibuat.');
    }

    public function destroy($id)
    {
        $wallet = Wallet::where('user_id', Auth::id())->findOrFail($id);

        $wallet->delete();

        return redirect()->back()->with('success', 'Dompet berhasil dihapus.');
    }

    public function transferProcess(Request $request)
    {
        $request->validate([
            'from_wallet_id' => 'required|exists:wallets,id',
            'to_wallet_id' => 'required|exists:wallets,id|different:from_wallet_id',
            'amount' => 'required|numeric|min:1',
        ]);

        $fromWallet = Wallet::where('user_id', Auth::id())->findOrFail($request->from_wallet_id);
        $toWallet = Wallet::where('user_id', Auth::id())->findOrFail($request->to_wallet_id);

        if ($fromWallet->balance < $request->amount) {
            return redirect()->back()->with('error', 'Saldo dompet asal tidak mencukupi.');
        }

        DB::transaction(function () use ($fromWallet, $toWallet, $request) {

            $fromWallet->decrement('balance', $request->amount);

            $toWallet->increment('balance', $request->amount);

            Transaction::create([
                'user_id' => Auth::id(),
                'wallet_id' => $fromWallet->id,
                'category_id' => null,
                'amount' => $request->amount,
                'type' => 'expense',
                'description' => 'Transfer ke ' . $toWallet->name,
                'date' => now(),
            ]);

            Transaction::create([
                'user_id' => Auth::id(),
                'wallet_id' => $toWallet->id,
                'category_id' => null,
                'amount' => $request->amount,
                'type' => 'income',
                'description' => 'Transfer dari ' . $fromWallet->name,
                'date' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Transfer saldo berhasil!');
    }
}
