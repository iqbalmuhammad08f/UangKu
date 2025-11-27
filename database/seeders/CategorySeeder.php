<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Kategori Global Pengeluaran
        $expenses = ['makan & minum', 'transportasi', 'belanja', 'tagihan', 'hiburan'];
        foreach ($expenses as $name) {
            Category::create([
                'user_id' => null,
                'name' => $name,
                'type' => 'expense',
                'is_default' => true
            ]);
        }

        // Kategori Global Pemasukan
        $incomes = ['gaji pokok', 'bonus', 'investasi'];
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
