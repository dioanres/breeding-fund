<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPosts = Post::count();
        $totalViews = Post::sum('views');
        $latestPosts = Post::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalPosts', 'totalViews', 'latestPosts'));
    }
}