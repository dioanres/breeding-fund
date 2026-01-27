@extends('layouts.admin')

@section('page_title', 'Tambah Kategori')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Kategori</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Saham, Kripto..." required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <button type="submit" class="btn btn-dark fw-bold">Simpan Kategori</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-link text-muted text-decoration-none">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection