<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->get();

        return view('pages.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ]);

        // Cek duplikasi hanya di lingkup user ini
        $exists = Category::where('user_id', Auth::id())
            ->where('name', strtolower($request->name))
            ->where('type', $request->type)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Kategori tersebut sudah ada.');
        }

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

        $request->validate(['name' => 'required|string|max:255']);

        // Cek nama kembar saat update
        $exists = Category::where('user_id', Auth::id())
            ->where('name', strtolower($request->name))
            ->where('type', $category->type)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Nama kategori sudah digunakan.');
        }

        $category->update(['name' => $request->name]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        // User bisa menghapus kategori apapun ASALKAN itu miliknya (termasuk hasil copy dari global)
        $category = Category::where('user_id', Auth::id())->findOrFail($id);

        // Soft delete kategori & transaksi (sesuai logic di Model sebelumnya)
        $category->delete();

        return redirect()->back()->with('success', 'Kategori dihapus. Transaksi terkait ikut terhapus (Arsip).');
    }
}
