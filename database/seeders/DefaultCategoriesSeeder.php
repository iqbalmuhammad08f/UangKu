<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultCategories = [
            ['name' => 'Gaji', 'type' => 'income'],
            ['name' => 'Bonus', 'type' => 'income'],
            ['name' => 'Investasi', 'type' => 'income'],
            ['name' => 'Hadiah', 'type' => 'income'],
            ['name' => 'Lainnya (Pemasukan)', 'type' => 'income'],

            ['name' => 'Makan & Minum', 'type' => 'expense'],
            ['name' => 'Transportasi', 'type' => 'expense'],
            ['name' => 'Belanja', 'type' => 'expense'],
            ['name' => 'Hiburan', 'type' => 'expense'],
            ['name' => 'Kesehatan', 'type' => 'expense'],
            ['name' => 'Pendidikan', 'type' => 'expense'],
            ['name' => 'Tagihan', 'type' => 'expense'],
            ['name' => 'Fashion', 'type' => 'expense'],
            ['name' => 'Lainnya (Pengeluaran)', 'type' => 'expense'],
        ];
        
        foreach ($defaultCategories as $category) {
            Category::create([
                'user_id' => null,
                'is_default' => true,
                'name' => $category['name'],
                'type' => $category['type']
            ]);
        }
    }
}
