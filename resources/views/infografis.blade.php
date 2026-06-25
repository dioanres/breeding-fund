@extends('layouts.app')

@section('title', 'Infografis')
@section('meta_description', 'Kumpulan infografis seputar keuangan dan investasi.')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Infografis</h2>
        <hr>
    </div>
</div>

@if($infografis->isEmpty())
    <div class="text-center text-muted py-5">
        <i class="bi bi-images fs-1 d-block mb-3"></i>
        <p>Belum ada infografis yang tersedia.</p>
    </div>
@else
    <div class="row g-4">
        @foreach($infografis as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <a href="{{ route('infografis.show', $item->uuid) }}">
                    @if($item->type === 'image')
                        <img src="{{ asset(ltrim($item->file, '/')) }}" alt="{{ $item->name }}" class="card-img-top" style="object-fit: cover; height: 220px; cursor: pointer;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 220px; cursor: pointer;">
                            <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 5rem;"></i>
                        </div>
                    @endif
                </a>
                <div class="card-body d-flex flex-column">
                    <a href="{{ route('infografis.show', $item->uuid) }}" class="text-decoration-none text-dark">
                        <h6 class="card-title fw-bold">{{ $item->name }}</h6>
                    </a>
                    <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>Dibuat pada: {{ ($item->published_at ?? $item->created_at)->format('d M Y') }}</small>
                    <div class="mt-auto d-flex gap-2">
                        @if($item->type === 'image')
                            <a href="{{ asset(ltrim($item->file, '/')) }}" target="_blank" class="btn btn-sm btn-outline-dark flex-grow-1">
                                <i class="bi bi-eye me-1"></i> Lihat
                            </a>
                        @else
                            <a href="{{ asset(ltrim($item->file, '/')) }}" target="_blank" class="btn btn-sm btn-outline-danger flex-grow-1">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Buka PDF
                            </a>
                        @endif
                        <a href="{{ asset(ltrim($item->file, '/')) }}" download class="btn btn-sm btn-dark">
                            <i class="bi bi-download"></i>
                        </a>
                        @auth
                            <a href="{{ route('admin.infografis.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
