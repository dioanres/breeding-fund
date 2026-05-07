@extends('layouts.admin')

@section('page_title', 'Tambah Infografis')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('admin.infografis.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="form-label fw-bold">Nama</label>
            <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Nama infografis..." value="{{ old('name') }}" required>
            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">File (Gambar atau PDF, maks. 5MB)</label>
            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept="image/*,.pdf" required>
            @error('file') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">Tanggal Publikasi <span class="text-muted fw-normal">(opsional, jika kosong pakai tanggal dibuat)</span></label>
            <input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ old('published_at') }}">
            @error('published_at') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <div class="form-check form-switch fs-5">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" checked>
                <label class="form-check-label fw-bold" for="is_active">Aktif (tampil di portal)</label>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-dark fw-bold"><i class="bi bi-save me-1"></i> Simpan</button>
            <a href="{{ route('admin.infografis.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
