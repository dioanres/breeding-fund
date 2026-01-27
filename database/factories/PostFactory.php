<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;

class PostFactory extends Factory
{
    public function definition(): array
    {
        // Kumpulan kata kunci finansial untuk membuat judul yang realistis
        $financeWords = [
            'IHSG Menguat', 'Bank Indonesia', 'Suku Bunga', 'Wall Street', 
            'Harga Emas', 'Bitcoin Melonjak', 'Rupiah Melemah', 'Saham Bluechip', 
            'Investor Asing', 'Laba Bersih', 'Dividen Saham', 'Pasar Modal', 
            'Inflasi Global', 'Proyek IKN', 'Startup Fintech'
        ];
        
        $actionWords = [
            'Tembus Rekor Tertinggi Tahun Ini', 'Diprediksi Terkoreksi Pekan Depan',
            'Jadi Sorotan Para Investor', 'Berdampak Positif Bagi Perekonomian',
            'Sentuh Titik Terendah', 'Catatkan Kinerja Cemerlang di Q3',
            'Memicu Kepanikan di Bursa Asia'
        ];

        // Menggabungkan kata menjadi Judul Berita
        $title = $this->faker->randomElement($financeWords) . ' ' . $this->faker->randomElement($actionWords);

        // Konten berita
        $content = "<p class='mb-4'><strong>Jakarta, NewsDaily</strong> - " . $this->faker->realText(200) . "</p>";
        $content .= "<p class='mb-4'>" . $this->faker->realText(300) . "</p>";
        $content .= "<h3 class='fw-bold mb-3'>Dampak Bagi Investor</h3>";
        $content .= "<p class='mb-4'>" . $this->faker->realText(250) . "</p>";

        // Kata kunci gambar finansial (chart, money, trading, business)
        $imageKeywords = ['finance', 'money', 'trading', 'stock-market', 'business', 'office'];
        $selectedKeyword = $this->faker->randomElement($imageKeywords);

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'category_id' => Category::inRandomOrder()->first()->id ?? 1,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->numberBetween(100, 999),
            'content' => $content,
            // Menggunakan Unsplash Source dengan kata kunci finansial
            'thumbnail' => 'https://picsum.photos/1000/600?random=' . $this->faker->unique()->numberBetween(1, 1000),
            'views' => $this->faker->numberBetween(1000, 50000),
            'is_published' => true,
        ];
    }
}