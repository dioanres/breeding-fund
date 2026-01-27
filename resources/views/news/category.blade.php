@extends('layouts.app')

@section('title', 'Berita ' . $category->name)

@section('content')
<div class="row mb-5">
    <div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm border-bottom border-4 border-warning">
        <span class="text-uppercase text-muted fw-bold tracking-wider ls-1 small">Arsip Berita</span>
        <h1 class="display-4 fw-bold mt-2 mb-0">{{ $category->name }}</h1>
        <p class="text-muted mt-2">Menampilkan berita terkini seputar {{ strtolower($category->name) }}.</p>
    </div>
</div>

<div class="row g-4">
    @forelse($posts as $post)
    <div class="col-md-4">
        <div class="card h-100 news-card border-0 shadow-sm">
            <div class="position-relative overflow-hidden rounded-top-3">
                <img src="{{ $post->thumbnail }}" class="card-img-top" alt="{{ $post->title }}" style="height: 220px; object-fit: cover;">
                <span class="position-absolute top-0 end-0 bg-warning text-dark fw-bold px-3 py-1 m-3 rounded-pill shadow-sm" style="font-size: 0.75rem;">
                    {{ $post->category->name }}
                </span>
            </div>
            
            <div class="card-body">
                <h5 class="card-title fw-bold">
                    <a href="{{ route('news.show', $post->slug) }}" class="text-dark text-decoration-none stretched-link">
                        {{ Str::limit($post->title, 60) }}
                    </a>
                </h5>
                <p class="card-text text-muted small mb-3">
                    {{ Str::limit(strip_tags($post->content), 90) }}
                </p>
            </div>
            <div class="card-footer bg-white border-0 text-muted d-flex justify-content-between align-items-center pb-3">
                <small><i class="bi bi-clock me-1"></i> {{ $post->created_at->diffForHumans() }}</small>
                <small><i class="bi bi-eye me-1"></i> {{ $post->views }}</small>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="text-muted">
            <i class="bi bi-journal-x fs-1 d-block mb-3"></i>
            <h4>Belum ada berita di kategori ini.</h4>
            <a href="/" class="btn btn-outline-dark mt-3">Kembali ke Beranda</a>
        </div>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-5">
    {{ $posts->links() }}
</div>
@endsection