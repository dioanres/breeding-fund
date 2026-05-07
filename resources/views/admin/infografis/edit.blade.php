@extends('layouts.admin')

@section('page_title', 'Edit Infografis')

@section('content')
<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('admin.infografis.update', $infografis->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="form-label fw-bold">Nama</label>
            <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name', $infografis->name) }}" required>
            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">File Saat Ini</label>
            <div class="mb-2">
                @if($infografis->type === 'pdf')
                    <a href="{{ $infografis->file }}" target="_blank" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-file-earmark-pdf me-1"></i> Lihat PDF
                    </a>
                @else
                    <img src="{{ $infografis->file }}" alt="{{ $infografis->name }}" class="img-thumbnail" style="max-height: 150px;">
                @endif
            </div>
            <label class="form-label fw-bold">Ganti File (opsional, maks. 5MB)</label>
            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept="image/*,.pdf">
            @error('file') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">Tanggal Publikasi <span class="text-muted fw-normal">(opsional, jika kosong pakai tanggal dibuat)</span></label>
            <input type="datetime-local" name="published_at" class="form-control @error('published_at') is-invalid @enderror"
                value="{{ old('published_at', $infografis->published_at ? $infografis->published_at->format('Y-m-d\TH:i') : '') }}">
            @error('published_at') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <div class="form-check form-switch fs-5">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ $infografis->is_active ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="is_active">Aktif (tampil di portal)</label>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-dark fw-bold"><i class="bi bi-save me-1"></i> Perbarui</button>
            <a href="{{ route('admin.infografis.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
