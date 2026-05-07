@extends('layouts.admin')

@section('page_title', 'Kelola Infografis')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Daftar Infografis</h5>
        <a href="{{ route('admin.infografis.create') }}" class="btn btn-dark fw-bold"><i class="bi bi-plus-lg me-1"></i> Tambah Infografis</a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="40%">Nama</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($infografis as $item)
                    <tr>
                        <td class="fw-semibold">{{ $item->name }}</td>
                        <td>
                            @if($item->type === 'pdf')
                                <span class="badge bg-danger"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</span>
                            @else
                                <span class="badge bg-info"><i class="bi bi-image me-1"></i>Gambar</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>{{ ($item->published_at ?? $item->created_at)->format('d M Y') }}</td>
                        <td>
                            <a href="{{ $item->file }}" target="_blank" class="btn btn-sm btn-outline-info me-1" title="Lihat File">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.infografis.edit', $item->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.infografis.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus infografis ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data infografis.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $infografis->links() }}
        </div>
    </div>
</div>
@endsection
