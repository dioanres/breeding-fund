@extends('layouts.admin')

@section('page_title', 'Edit Kategori')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kategori</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <button type="submit" class="btn btn-warning fw-bold">Update Kategori</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-link text-muted text-decoration-none">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection