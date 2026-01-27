@extends('layouts.admin')

@section('page_title', 'Kelola Berita')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Daftar Berita Finansial</h5>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-dark fw-bold"><i class="bi bi-plus-lg me-1"></i> Tulis Berita</a>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="40%">Judul Berita</th>
                        <th>Kategori</th>
                        <th>Views</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td class="fw-semibold">
                            {{ $post->title }}
                            <a href="{{ route('news.show', $post->slug) }}" target="_blank" class="text-primary ms-1" title="Lihat"><i class="bi bi-box-arrow-up-right"></i></a>
                        </td>
                        <td><span class="badge bg-primary">{{ $post->category->name }}</span></td>
                        <td>{{ number_format($post->views) }}</td>
                        <td>{{ $post->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input toggle-publish" type="checkbox" role="switch" 
                                    data-id="{{ $post->id }}" 
                                    {{ $post->is_published ? 'checked' : '' }}
                                    style="cursor: pointer; transform: scale(1.2);">
                                <label class="form-check-label ms-1 {{ $post->is_published ? 'text-success' : 'text-danger' }}" id="label-{{ $post->id }}">
                                    <small class="fw-bold">{{ $post->is_published ? 'LIVE' : 'DRAFT' }}</small>
                                </label>
                            </div>
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit Berita">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
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
        <div class="d-flex justify-content-end mt-3">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Ambil semua elemen toggle
    const toggles = document.querySelectorAll('.toggle-publish');

    toggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            let postId = this.dataset.id;
            let isPublished = this.checked ? 1 : 0;
            let label = document.querySelector(`#label-${postId}`);

            // Ubah teks label sementara (Visual feedback)
            label.innerHTML = isPublished ? '<small class="fw-bold">LIVE</small>' : '<small class="fw-bold">DRAFT</small>';
            label.className = isPublished ? 'form-check-label ms-1 text-success' : 'form-check-label ms-1 text-danger';

            // Kirim data ke server tanpa reload
            fetch(`/admin/posts/${postId}/toggle-publish`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ is_published: isPublished })
            })
            .then(response => response.json())
            .then(data => {
                // Opsional: Munculkan notifikasi toast sukses di sini jika mau
                console.log(data.message); 
            })
            .catch(error => {
                alert('Terjadi kesalahan. Silakan coba lagi.');
                this.checked = !this.checked; // Kembalikan posisi toggle jika error
            });
        });
    });
</script>
@endpush