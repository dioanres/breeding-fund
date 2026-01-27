<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Akun Admin CMS
        User::create([
            'name' => 'Admin NewsDaily',
            'email' => 'admin@news.test',
            'password' => Hash::make('password123'), // Password untuk login nanti
        ]);

        // 2. Kategori Khusus Finansial
        $categories = ['Saham & Investasi', 'Perbankan', 'Kripto & Forex', 'Makro Ekonomi', 'Bisnis & UMKM'];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }

        // 3. Buat 20 Berita Dummy
        Post::factory(20)->create();
    }
}