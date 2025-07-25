@extends('layouts.app')

@section('page_title', 'Kelola Uji Kompetensi')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">Kelola Uji Kompetensi</h2>

    <!-- Form Tambah -->
    <div class="card mb-4">
        <div class="card-header bg-white fw-bold">Tambah Uji Kompetensi</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.kompetensi.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bidang</label>
                        <select name="skill_id" class="form-select" required>
                            <option value="">-- Pilih Bidang --</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tingkat Level</label>
                        <select name="level" class="form-select" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="Pemula">Pemula</option>
                            <option value="Menengah">Menengah</option>
                            <option value="Ahli">Ahli</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Durasi (menit)</label>
                        <input type="number" name="duration" class="form-control" min="1" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">Tambah Uji Kompetensi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Fitur Pencarian -->
    <form method="GET" action="" class="mb-3">
        <div class="row g-2 justify-content-end">
            <div class="col-md-6 col-12">
                <div class="d-flex flex-row flex-md-row gap-2 align-items-center komp-search-mobile">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari judul, kategori, deskripsi...">
                    <button type="submit" class="btn btn-outline-primary d-flex align-items-center"><i class="fa fa-search me-1"></i> <span class="d-none d-md-inline">Cari</span></button>
                </div>
            </div>
        </div>
    </form>
    <!-- Daftar Uji Kompetensi -->
    <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th>Judul</th>
                <th>Bidang</th>
                <th>Level</th>
                <th>Durasi</th>
                <th>Status</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($competencies as $kompetensi)
                <tr>
                    <td>{{ $kompetensi->title }}</td>
                    <td>{{ $kompetensi->skill ? $kompetensi->skill->name : '-' }}</td>
                    <td>
                        @php
                            $levelClass = 'learning-badge-level badge-sm';
                            if (strtolower($kompetensi->level ?? '') == 'pemula') $levelClass .= ' learning-badge-level-pemula';
                            elseif (strtolower($kompetensi->level ?? '') == 'menengah') $levelClass .= ' learning-badge-level-menengah';
                            elseif (strtolower($kompetensi->level ?? '') == 'ahli') $levelClass .= ' learning-badge-level-ahli';
                        @endphp
                        <span class="badge px-2 py-1 {{ $levelClass }}" style="font-size:0.85rem;min-width:60px;">{{ $kompetensi->level ?? '-' }}</span>
                    </td>
                    <td>{{ $kompetensi->duration }} menit</td>
                    <td>
                        @if($kompetensi->is_available)
                            <span class="badge bg-success">Tersedia</span>
                        @else
                            <span class="badge bg-secondary">Tidak Tersedia</span>
                        @endif
                    </td>
                    <td>{{ $kompetensi->description }}</td>
                    <td class="d-flex flex-wrap gap-1">
                        <a href="{{ route('admin.kompetensi.soal.index', $kompetensi->id) }}" class="btn btn-info btn-sm btn-action" title="Kelola Soal"><i class="fa fa-tasks"></i></a>
                        @php $jumlahSoal = $kompetensi->soals_count ?? ($kompetensi->soals->count() ?? 0); @endphp
                        <form method="POST" action="{{ route('admin.kompetensi.toggle', $kompetensi->id) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            @if($kompetensi->is_available)
                                <button class="btn btn-warning btn-sm btn-action" title="Nonaktifkan"><i class="fa fa-eye-slash"></i></button>
                            @else
                                <button class="btn btn-success btn-sm btn-action" title="Aktifkan" @if($jumlahSoal == 0) disabled data-bs-toggle="tooltip" data-bs-title="Tambah soal terlebih dahulu" @endif><i class="fa fa-eye"></i></button>
                            @endif
                        </form>
                        <a href="{{ route('admin.kompetensi.edit', $kompetensi->id) }}" class="btn btn-primary btn-sm btn-action" title="Edit"><i class="fa fa-edit"></i></a>
                        <form method="POST" action="{{ route('admin.kompetensi.destroy', $kompetensi->id) }}" class="d-inline" onsubmit="return confirm('Hapus uji ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm btn-action" title="Hapus"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data uji kompetensi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        {{ $competencies->withQueryString()->links('vendor.pagination.custom') }}
    </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media (max-width: 767.98px) {
  .komp-search-mobile {
    flex-direction: row !important;
  }
  .komp-search-mobile input[type="text"] {
    flex: 1 1 0%;
    min-width: 0;
  }
  .komp-search-mobile button {
    flex-shrink: 0;
    white-space: nowrap;
    padding-left: 0.75rem;
    padding-right: 0.75rem;
  }
}
</style>
@endpush
