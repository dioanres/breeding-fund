@extends('layouts.app')

@section('title', 'Berita Terkini')

@section('content')

    <div class="row g-4">
    <h3 class="fw-bold border-bottom pb-2 mb-4">Berita Terbaru</h3>

    @foreach($posts as $post)
    <div class="col-md-4">
        <div class="card h-100 news-card">
            <div class="card-body">
                <span class="badge bg-secondary mb-2 category-badge">{{ $post->category->name }}</span>
                <h5 class="card-title fw-bold" style="line-height: 1.4;">{{ $post['title'] }}</h5>
                <p class="card-text text-muted">{{ Str::limit(strip_tags($post['content']), 100) }}</p>
            </div>
            <div class="card-footer bg-white border-0 text-muted d-flex justify-content-between">
                <small>{{ $post['created_at']->diffForHumans() }}</small>
                <a href="{{ route('news.show', $post->slug) }}" class="text-decoration-none fw-bold text-dark">Baca &rarr;</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection