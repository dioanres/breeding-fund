<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // 1. Menampilkan Daftar Berita
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    // 2. Menampilkan Form Buat Berita
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    // 3. Menyimpan Berita Baru ke Database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'thumbnail' => 'nullable|image|file|max:2048', // Maksimal 2MB
            'is_featured' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
        $validated['is_published'] = true;

        // Proses Upload Gambar (jika ada)
        if ($request->file('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dipublikasikan!');
    }

    // 4. Menghapus Berita
    public function destroy(Post $post)
    {
        // Hapus file gambar jika ada
        if ($post->thumbnail && str_contains($post->thumbnail, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $post->thumbnail));
        }

        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dihapus!');
    }

    // 5. Menampilkan Form Edit Berita
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    // 6. Menyimpan Perubahan (Update) ke Database
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'thumbnail' => 'nullable|image|file|max:2048',
            'is_published' => 'boolean', // <-- TAMBAHKAN BARIS INI
            'is_featured' => 'boolean',
        ]);

        // Update slug jika judul berubah
        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);

        // Proses Ganti Gambar (Jika ada gambar baru yang diupload)
        if ($request->file('thumbnail')) {
            // Hapus gambar lama dari storage
            if ($post->thumbnail && str_contains($post->thumbnail, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $post->thumbnail));
            }

            // Upload gambar baru
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $validated['thumbnail'] = '/storage/' . $path;
        }

        // Update data di database
        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil diperbarui!');
    }

    // Function untuk menerima request AJAX dari tabel
    public function togglePublish(Request $request, Post $post)
    {
        $post->update([
            'is_published' => $request->is_published
        ]);

        return response()->json(['success' => true, 'message' => 'Status berita berhasil diubah!']);
    }
}