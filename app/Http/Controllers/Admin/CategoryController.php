<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil kategori beserta jumlah beritanya
        $categories = Category::withCount('posts')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:50',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) // Generate slug otomatis
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:50|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori diperbarui!');
    }

    public function destroy(Category $category)
    {
        // Cek apakah kategori masih dipakai berita
        if ($category->posts()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Masih ada berita yang menggunakan kategori ini.');
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori dihapus!');
    }
}