@extends('layouts.admin')

@section('page_title', 'Edit Berita: ' . Str::limit($post->title, 40))

@section('content')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
<style> trix-toolbar [data-trix-button-group="file-tools"] { display: none; } </style>

<div class="card border-0 shadow-sm p-4">
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        
        <div class="row">
            <div class="col-md-8">
                <div class="mb-4">
                    <label class="form-label fw-bold">Judul Berita</label>
                    <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                    @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Isi Berita</label>
                    <input id="content" type="hidden" name="content" value="{{ old('content', $post->content) }}">
                    <trix-editor input="content" class="bg-white" style="min-height: 300px; font-family: 'Georgia', serif;"></trix-editor>
                    @error('content') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label fw-bold">Kategori</label>
                    <select name="category_id" class="form-select">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4 p-3 bg-light rounded-3 border">
                    <div class="form-check form-switch fs-5 d-flex align-items-center">
                        <input type="hidden" name="is_published" value="0">
                        
                        <input class="form-check-input me-3" type="checkbox" role="switch" id="is_published" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }} style="cursor: pointer;">
                        <label class="form-check-label fw-bold text-dark" for="is_published" style="cursor: pointer;">Publikasikan Berita</label>
                    </div>
                    <small class="text-muted d-block mt-1">Jika dimatikan, berita tidak akan muncul di halaman depan.</small>
                </div>

                <div class="mb-4 p-3 bg-warning bg-opacity-10 rounded-3 border border-warning">
                    <div class="form-check form-switch fs-5 d-flex align-items-center">
                        <input type="hidden" name="is_featured" value="0">
                        <input class="form-check-input me-3 border-warning" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $post->is_featured ?? false) ? 'checked' : '' }} style="cursor: pointer;">
                        <label class="form-check-label fw-bold text-dark" for="is_featured" style="cursor: pointer;">Jadikan Headline (Banner Utama)</label>
                    </div>
                    <small class="text-muted d-block mt-1">Berita ini akan muncul paling besar di bagian atas Beranda.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Thumbnail Saat Ini</label>
                    @if($post->thumbnail)
                        <img src="{{ $post->thumbnail }}" class="img-fluid rounded-3 mb-2 shadow-sm d-block">
                    @else
                        <div class="alert alert-secondary text-center small">Tidak ada gambar</div>
                    @endif
                    
                    <label class="form-label fw-bold mt-2">Ganti Gambar (Opsional)</label>
                    <input type="file" name="thumbnail" class="form-control">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-warning btn-lg fw-bold text-dark"><i class="bi bi-pencil-square me-1"></i> Simpan Perubahan</button>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection