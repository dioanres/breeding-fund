<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // Menampilkan Halaman Beranda
    public function index()
    {
        $headline = Post::with('category')
                    ->where('is_published', true)
                    ->where('is_featured', true)
                    ->latest()
                    ->first();

        $posts = Post::where('is_published', true)
            ->with('category')
            ->latest()
            ->take(6)->get();

        return view('home', compact('posts', 'headline')); 
    }

    // Menampilkan Halaman Baca Berita (Detail)
    public function show($slug)
    {
        // Mengambil data berita berdasarkan slug (URL)
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $sessionKey = 'post_' . $post->id . '_viewed';

        if (!session()->has($sessionKey)) {
            $post->increment('views'); // Tambah 1 ke database
            session()->put($sessionKey, true); // Tandai user ini sudah baca
        }
        // ----------------------------------------------------
        
        return view('news.show', compact('post'));
    }

    public function getBycategorySlug($categorySlug)
    {
        $posts = Post::whereHas('category', function ($query) use ($categorySlug) {
            $query->where('slug', $categorySlug);
        })->where('is_published', true)
          ->with('category')
          ->latest()
          ->paginate(10);

        return view('news.category', compact('posts', 'categorySlug'));
    }

    public function category($slug)
    {
        // 1. Cari Kategori berdasarkan slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // 2. Ambil berita yang berelasi dengan kategori tersebut
        // Hanya ambil yang published, urutkan terbaru, dan paginasi
        $posts = $category->posts()
                        ->where('is_published', true)
                        ->latest()
                        ->paginate(9); // 9 berita per halaman

        // 3. Tampilkan view
        return view('news.category', compact('category', 'posts'));
    }
}