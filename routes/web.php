<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Rute untuk Beranda
Route::get('/', [NewsController::class, 'index'])->name('home');

// Rute untuk Baca Berita (Detail)
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');
// Taruh di bagian rute publik (sebelum grup admin)
Route::get('/kategori/{slug}', [NewsController::class, 'category'])->name('news.category');


// Rute Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'processLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute CMS Admin (Hanya untuk yang sudah login)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Nanti rute CRUD Berita akan kita taruh di sini
    Route::resource('/posts', PostController::class);
    Route::patch('/posts/{post}/toggle-publish', [PostController::class, 'togglePublish'])->name('posts.toggle-publish');
});

Route::get('/link-storage', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');
    symlink($target, $link);
    return 'Symlink berhasil dibuat!';
});