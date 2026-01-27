@extends('layouts.admin')

@section('page_title', 'Kelola Kategori')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Daftar Kategori</h5>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-dark btn-sm fw-bold"><i class="bi bi-plus-lg me-1"></i> Tambah</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Slug</th>
                                <th>Jumlah Berita</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td class="fw-bold">{{ $category->name }}</td>
                                <td class="text-muted small">/{{ $category->slug }}</td>
                                <td><span class="badge bg-secondary rounded-pill">{{ $category->posts_count }} Berita</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil-square"></i></a>
                                    
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection