@extends('layouts.app')

@section('title', $infografis->name)
@section('meta_description', 'Detail infografis: ' . $infografis->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <a href="{{ route('infografis') }}" class="text-decoration-none text-muted d-inline-flex align-items-center mb-4">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Infografis
        </a>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="fw-bold mb-1">{{ $infografis->name }}</h4>
                <small class="text-muted">
                    <i class="bi bi-calendar3 me-1"></i>Dibuat pada: {{ ($infografis->published_at ?? $infografis->created_at)->format('d M Y') }}
                </small>

                <hr>

                @if($infografis->type === 'image')
                    <img src="{{ asset(ltrim($infografis->file, '/')) }}" alt="{{ $infografis->name }}" class="img-fluid rounded w-100">
                @else
                    <div class="ratio" style="--bs-aspect-ratio: 75%;">
                        <iframe src="{{ asset(ltrim($infografis->file, '/')) }}" class="rounded border-0" allowfullscreen></iframe>
                    </div>
                @endif

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ asset(ltrim($infografis->file, '/')) }}" download class="btn btn-dark">
                        <i class="bi bi-download me-1"></i> Download
                    </a>
                    <a href="{{ asset(ltrim($infografis->file, '/')) }}" target="_blank" class="btn btn-outline-secondary">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka di Tab Baru
                    </a>
                    @auth
                        <a href="{{ route('admin.infografis.edit', $infografis->id) }}" class="btn btn-outline-warning">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.infografis.destroy', $infografis->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus infografis ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
