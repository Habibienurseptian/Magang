@extends('layouts.app')

@section('page_title', 'Kelola Bidang Keahlian')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">Kelola Bidang Keahlian</h2>

    <!-- Form Tambah Bidang Keahlian -->
    <div class="card mb-4 shadow-sm border-0" style="border-radius:1.2rem;">
        <div class="card-header bg-white fw-bold fs-5">Tambah Bidang Keahlian</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.bidang.store') }}">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label">Nama Bidang Keahlian</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Penjahit, Web Developer, dll" required>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="submit" class="btn btn-success px-4"><i class="fa fa-plus me-1"></i> Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Bidang Keahlian -->
    <div class="card shadow-sm border-0" style="border-radius:1.2rem;">
        <div class="card-header bg-white fw-bold fs-5">Daftar Bidang Keahlian</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;">#</th>
                            <th>Nama Bidang</th>
                            <th style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($skills as $skill)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $skill->name }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.bidang.destroy', $skill->id) }}" class="d-inline" onsubmit="return confirm('Hapus bidang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada bidang keahlian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    border-radius: 1.2rem;
}
.table th, .table td {
    vertical-align: middle;
}
@media (max-width: 767.98px) {
    .card-header.fs-5 {
        font-size: 1.1rem !important;
    }
    .table-responsive {
        font-size: 0.97rem;
    }
}
</style>
@endpush

@endsection
