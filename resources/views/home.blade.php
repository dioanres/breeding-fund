@extends('layouts.app')

@section('title', 'Berita Terkini')

@section('content')

<div class="row g-4 mb-4">
    <div class="col-12">
        <h3 class="fw-bold border-start border-4 border-warning ps-3 mb-4">Berita Terbaru</h3>
    </div>

    @forelse($posts as $post)
    <div class="col-md-4">
        <div class="card h-100 news-card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="mb-3">
                    <a href="{{ route('news.category', $post->category->slug) }}" class="text-decoration-none">
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 small fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">
                            {{ $post->category->name }}
                        </span>
                    </a>
                </div>

                <h5 class="card-title fw-bold mb-3">
                    <a href="{{ route('news.show', $post->slug) }}" class="text-dark text-decoration-none stretched-link">
                        {{ Str::limit($post->title, 60) }} </a>
                </h5>
                <p class="card-text text-muted small mb-0">
                    {{ Str::limit(strip_tags($post->content), 100) }}
                </p>
            </div>
            <div class="card-footer bg-white border-0 px-4 pb-4 pt-0 d-flex justify-content-between align-items-center">
                <small class="text-muted"><i class="bi bi-clock me-1"></i> {{ $post->created_at->diffForHumans() }}</small>
                <small class="text-muted"><i class="bi bi-eye me-1"></i> {{ number_format($post->views) }}</small>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <p class="text-muted">Belum ada berita reguler.</p>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-5">
    {{ $posts->links() }}
</div>
@endsection