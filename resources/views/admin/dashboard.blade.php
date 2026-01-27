@extends('layouts.admin')

@section('page_title', 'Dashboard Statistik')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3 border-start border-4 border-primary h-100">
            <h6 class="text-muted text-uppercase fw-bold">Total Berita</h6>
            <h2 class="fw-bold mb-0">{{ $totalPosts }}</h2>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-3 border-start border-4 border-success h-100">
            <h6 class="text-muted text-uppercase fw-bold">Total Pembaca</h6>
            <h2 class="fw-bold mb-0">{{ number_format($totalViews) }}</h2>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 pb-2">
        <h5 class="fw-bold">5 Berita Terakhir</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penayangan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestPosts as $post)
                    <tr>
                        <td class="fw-semibold">{{ $post->title }}</td>
                        <td><span class="badge bg-secondary">{{ $post->category->name }}</span></td>
                        <td><i class="bi bi-eye text-muted me-1"></i>{{ number_format($post->views) }}</td>
                        <td>{{ $post->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection