<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        // 1. Urutan Data Terbaru
        $query->latest();

        // 2. Filter Nama
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // 3. Filter Tipe
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 4. Filter Tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $categories = $query->get();

        return view('kategori.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pemasukan,pengeluaran',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->route('kategori.index')->with('status', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pemasukan,pengeluaran',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('kategori.index')->with('status', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        // Cek apakah ada transaksi yang menggunakan kategori ini
        if ($category->transaksiKas()->exists()) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak bisa dihapus karena sudah memiliki data transaksi.');
        }

        $category->delete();

        return redirect()->route('kategori.index')->with('status', 'Kategori berhasil dihapus!');
    }
}
