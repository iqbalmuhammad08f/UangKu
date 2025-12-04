<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // kategori pengeluaran
        $expenses = ['makan', 'belanja', 'tagihan'];
        foreach ($expenses as $name) {
            Category::create([
                'user_id' => null,
                'name' => $name,
                'type' => 'expense',
                'is_default' => true
            ]);
        }

        // kategori pemasukan
        $incomes = ['gaji'];
        foreach ($incomes as $name) {
            Category::create([
                'user_id' => null,
                'name' => $name,
                'type' => 'income',
                'is_default' => true
            ]);
        }
    }
}
