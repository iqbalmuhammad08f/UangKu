<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create a demo user or reuse if exists
        $user = User::firstOrCreate([
            'email' => 'demo@example.com',
        ], [
            'name' => 'Demo User',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
        // If user already existed, ensure name and password up to date
        if (! $user->wasRecentlyCreated) {
            $user->update([
                'name' => 'Demo User',
                'password' => Hash::make('password'),
            ]);
        }

        // Create (or reuse) two wallets for the user
        $walletBRI = $user->wallets()->firstOrCreate([
            'name' => 'Bank BRI',
        ], [
            'name' => 'Bank BRI',
            'balance' => 0,
            'is_active' => true,
        ]);

        $walletDana = $user->wallets()->firstOrCreate([
            'name' => 'Dana',
        ], [
            'name' => 'Dana',
            'balance' => 0,
            'is_active' => true,
        ]);

        // Get default/global categories
        $incomeCategoriesGlobal = Category::where('is_default', true)->where('type', 'income')->get();
        $expenseCategoriesGlobal = Category::where('is_default', true)->where('type', 'expense')->get();

        // If no default categories exist, create a fallback
        if ($incomeCategoriesGlobal->isEmpty()) {
            $incomeCategoriesGlobal = collect([Category::create([
                'user_id' => null,
                'name' => 'gaji',
                'type' => 'income',
                'is_default' => true,
            ])]);
        }

        if ($expenseCategoriesGlobal->isEmpty()) {
            $expenseCategoriesGlobal = collect([
                Category::create([
                    'user_id' => null,
                    'name' => 'makan',
                    'type' => 'expense',
                    'is_default' => true,
                ]),
                Category::create([
                    'user_id' => null,
                    'name' => 'belanja',
                    'type' => 'expense',
                    'is_default' => true,
                ])
            ]);
        }

        // Reset any existing demo transactions for the user and reset wallet balances
        $wallets = [$walletBRI, $walletDana];
        Transaction::where('user_id', $user->id)->forceDelete();
        // Remove any duplicated wallets with the same name for this demo user
        $user->wallets()->where('name', 'Bank BRI')->where('id', '!=', $walletBRI->id)->forceDelete();
        $user->wallets()->where('name', 'Dana')->where('id', '!=', $walletDana->id)->forceDelete();
        foreach ($wallets as $w) {
            $w->balance = 0;
            $w->save();
        }

        // Copy global categories into user-specific categories (idempotent)
        $incomeCategories = collect();
        foreach ($incomeCategoriesGlobal as $globalCat) {
            $userCat = $user->categories()->firstOrCreate([
                'name' => $globalCat->name,
                'type' => $globalCat->type,
            ], [
                'is_default' => false,
            ]);
            $incomeCategories->push($userCat);
        }

        $expenseCategories = collect();
        foreach ($expenseCategoriesGlobal as $globalCat) {
            $userCat = $user->categories()->firstOrCreate([
                'name' => $globalCat->name,
                'type' => $globalCat->type,
            ], [
                'is_default' => false,
            ]);
            $expenseCategories->push($userCat);
        }

        // Create 100 transactions
        for ($i = 1; $i <= 100; $i++) {
            // Randomize type: 70% expense, 30% income
            $type = (rand(1, 100) <= 70) ? 'expense' : 'income';

            $category = $type === 'income'
                ? $incomeCategories->random()
                : $expenseCategories->random();

            // Random wallet
            $wallet = $wallets[array_rand($wallets)];

            // Random amount between 10.00 and 1,000,000.00 (currency units)
            $amount = rand(1000, 1000000);

            // Random date within last 180 days
            $date = now()->subDays(rand(0, 180))->toDateString();

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'category_id' => $category->id,
                'amount' => $amount,
                'type' => $type,
                'description' => "Dummy transaction #{$i}",
                'date' => $date,
            ]);

            // Update wallet balance accordingly
            if ($type === 'income') {
                $wallet->balance = $wallet->balance + $amount;
            } else {
                $wallet->balance = $wallet->balance - $amount;
            }

            $wallet->save();
        }
    }
}
