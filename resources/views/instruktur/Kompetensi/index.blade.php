@extends('layouts.app')

@section('page_title', 'Kelola Uji Kompetensi')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">Kelola Uji Kompetensi</h2>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahKompetensi">
        Tambah Uji Kompetensi
    </button>

    <!-- Form Tambah -->
    <div class="modal fade" id="modalTambahKompetensi" tabindex="-1" aria-labelledby="modalTambahKompetensiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKompetensiLabel">Tambah Uji Kompetensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('instruktur.kompetensi.store') }}">
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
                            <div class="col-md-4">
                                <label class="form-label">Passing Grade (%)</label>
                                <input type="number" name="passing_grade" class="form-control" min="0" max="100" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
                <th>Passing Grade</th>
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
                    <td>{{ $kompetensi->passing_grade }}%</td>
                    <td>
                        @if($kompetensi->is_available)
                            <span class="badge bg-success">Tersedia</span>
                        @else
                            <span class="badge bg-secondary">Tidak Tersedia</span>
                        @endif
                    </td>
                    <td class="desc-td" style="max-width:220px;word-break:break-word;">{!! \Illuminate\Support\Str::limit(nl2br(e($kompetensi->description)), 30, '...') !!}</td>
                    <td class="d-flex flex-wrap gap-1">
                        <a href="{{ route('instruktur.kompetensi.soal.index', $kompetensi->id) }}" class="btn btn-info btn-sm btn-action" title="Kelola Soal"><i class="fa fa-tasks"></i></a>
                        @php $jumlahSoal = $kompetensi->soals_count ?? ($kompetensi->soals->count() ?? 0); @endphp
                        <form method="POST" action="{{ route('instruktur.kompetensi.toggle', $kompetensi->id) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            @if($kompetensi->is_available)
                                <button class="btn btn-warning btn-sm btn-action" title="Nonaktifkan"><i class="fa fa-eye-slash"></i></button>
                            @else
                                <button class="btn btn-success btn-sm btn-action" title="Aktifkan" @if($jumlahSoal == 0) disabled data-bs-toggle="tooltip" data-bs-title="Tambah soal terlebih dahulu" @endif><i class="fa fa-eye"></i></button>
                            @endif
                        </form>
                        <a href="{{ route('instruktur.kompetensi.edit', $kompetensi->id) }}" class="btn btn-primary btn-sm btn-action" title="Edit"><i class="fa fa-edit"></i></a>
                        <form method="POST" action="{{ route('instruktur.kompetensi.destroy', $kompetensi->id) }}" class="d-inline" onsubmit="return confirm('Hapus uji ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm btn-action" title="Hapus"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted">Belum ada data uji kompetensi.</td>
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
