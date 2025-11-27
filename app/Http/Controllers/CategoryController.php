<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $globalCategories = Category::whereNull('user_id')->get();
        $userCategories = Category::where('user_id', Auth::id())->get();

        return view('pages.categories.index', compact('globalCategories', 'userCategories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        // 2. Validasi Custom: Cek apakah nama sudah ada (Global ATAU User ini)
        // Kita ubah input user ke lowercase dulu untuk pengecekan
        $nameToCheck = strtolower($request->name);

        $exists = Category::where('name', $nameToCheck)
            ->where('type', $request->type) // Cek tipe yang sama (pengeluaran/pemasukan)
            ->where(function ($query) {
                $query->whereNull('user_id') // Cek di Global
                    ->orWhere('user_id', Auth::id()); // Cek di User saat ini
            })
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Kategori "' . ucwords($nameToCheck) . '" sudah ada (Global atau milik Anda).');
        }

        // 3. Simpan (Mutator di Model akan otomatis mengubah ke lowercase)
        Category::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'is_default' => false,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $name = strtolower($request->name);

        // Cek duplikasi saat update (kecuali dirinya sendiri)
        $exists = Category::where('name', $name)
            ->where('type', $category->type)
            ->where('id', '!=', $id) // Abaikan id kategori ini sendiri
            ->where(function ($query) {
                $query->whereNull('user_id')
                    ->orWhere('user_id', Auth::id());
            })
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Nama kategori sudah digunakan!');
        }

        $category->update([
            'name' => $name
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);

        // Tidak perlu cek transaksi manual, karena sudah dihandle di Model (booted)
        // Fungsi delete() ini akan memicu Soft Delete pada Kategori & Transaksi
        $category->delete();

        return redirect()->back()->with('success', 'Kategori dan transaksi terkait berhasil dihapus (Arsip).');
    }
}
