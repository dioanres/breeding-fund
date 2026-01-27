@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', Str::limit(strip_tags($post->content), 150))
@section('meta_keywords', $post->category->name . ', berita keuangan, finansial')
@section('og_type', 'article')
@section('og_image', asset($post->thumbnail))

{{-- 2. Bagian Schema Markup (JSON-LD) --}}
@push('schema')
<script type="application/ld+json">
@php
    // Kita siapkan datanya dulu di dalam variabel PHP biasa
    $schema = [
        "@context" => "https://schema.org",
        "@type" => "NewsArticle",
        "headline" => $post->title,
        "image" => [
            asset($post->thumbnail)
        ],
        "datePublished" => $post->created_at->toIso8601String(),
        "dateModified" => $post->updated_at ? $post->updated_at->toIso8601String() : $post->created_at->toIso8601String(),
        "author" => [
            [
                "@type" => "Person",
                "name" => "Tim Redaksi",
                "url" => url('/')
            ]
        ]
    ];
@endphp

{{-- Sekarang tinggal print variabelnya. Jauh lebih bersih! --}}
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
<article class="row mt-4">
    <div class="col-lg-8 mx-auto">
        
        <div class="mb-4">
            <span class="badge bg-primary px-3 py-2 text-uppercase tracking-wider mb-3">
                Teknologi
            </span>
            <h1 class="display-4 fw-bolder lh-sm mb-3" style="font-family: 'Georgia', serif;">
                {{ $post->title }}
            </h1>
            <div class="d-flex align-items-center text-muted border-bottom pb-4">
                <img src="https://ui-avatars.com/api/?name=Admin" class="rounded-circle me-2" width="40" alt="Author">
                <div>
                    <span class="fw-bold text-dark d-block">Oleh Admin</span>
                    <small>{{ $post->created_at->translatedFormat('d F Y') }} &bull; {{ $post->views }}x dibaca</small>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <img src="{{ $post->thumbnail ?? 'https://picsum.photos/1000/600' }}" class="img-fluid rounded-4 w-100 shadow-sm" alt="{{ $post->title }}">
            <figcaption class="figure-caption text-center mt-2">Ilustrasi berita. Sumber: Unsplash</figcaption>
        </div>

        <div class="fs-5 lh-lg font-serif text-dark" style="font-family: 'Georgia', serif;">
            {!! $post->content !!} </div>

        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
            <a href="/" class="btn btn-outline-dark rounded-pill px-4">&larr; Kembali ke Beranda</a>
            <div>
                <button class="btn btn-light rounded-circle shadow-sm me-2">🔗</button>
                <button class="btn btn-light rounded-circle shadow-sm">🐦</button>
            </div>
        </div>

    </div>
</article>
@endsection