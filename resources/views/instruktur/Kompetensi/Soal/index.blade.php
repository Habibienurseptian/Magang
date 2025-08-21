@extends('layouts.app')

@section('page_title', 'Kelola Soal Uji Kompetensi')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">Kelola Soal Uji Kompetensi</h2>

    <!-- Tombol Aksi -->
    <div class="mb-3 d-flex justify-content-between">
        <!-- Kembali di kiri -->
        <a href="{{ route('instruktur.kompetensi.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Kembali ke Daftar Kompetensi
        </a>

        <!-- Tambah soal di kanan -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSoal">
            <i class="fa fa-plus me-1"></i> Tambah Soal
        </button>
    </div>

    <!-- Modal Tambah Soal -->
    <div class="modal fade" id="modalTambahSoal" tabindex="-1" aria-labelledby="modalTambahSoalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalTambahSoalLabel">Tambah Soal Uji Kompetensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <!-- 🔥 Perhatikan enctype -->
                <form method="POST" action="{{ route('instruktur.kompetensi.soal.store', $competency->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pertanyaan</label>
                            <textarea name="question" class="form-control" rows="2" required></textarea>
                        </div>

                        <!-- Input Upload Gambar -->
                        <div class="mb-3">
                            <label class="form-label">Gambar (opsional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Format: jpg, jpeg, png. Maks 2MB</small>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Pilihan A</label>
                                <input type="text" name="option_a" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pilihan B</label>
                                <input type="text" name="option_b" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pilihan C</label>
                                <input type="text" name="option_c" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pilihan D</label>
                                <input type="text" name="option_d" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kunci Jawaban</label>
                            <select name="answer_key" class="form-select" required>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                                <option value="d">D</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Soal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Daftar Soal -->
    <div class="card shadow-sm mt-3">
        <div class="card-header bg-white fw-bold">Daftar Soal</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Pertanyaan</th>
                            <th>Pilihan A</th>
                            <th>Pilihan B</th>
                            <th>Pilihan C</th>
                            <th>Pilihan D</th>
                            <th>Kunci Jawaban</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($soals->sortBy('nomor_soal') as $index => $soal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $soal->question }}</td>
                            <td>{{ $soal->option_a }}</td>
                            <td>{{ $soal->option_b }}</td>
                            <td>{{ $soal->option_c }}</td>
                            <td>{{ $soal->option_d }}</td>
                            <td class="text-uppercase">{{ $soal->answer_key }}</td>
                            <td>
                                <a href="{{ route('instruktur.kompetensi.soal.edit', [$competency->id, $soal->id]) }}" class="aksi-btn aksi-btn-info btn-sm" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('instruktur.kompetensi.soal.destroy', [$competency->id, $soal->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus soal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="aksi-btn aksi-btn-danger btn-sm" title="Hapus"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada soal.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Responsive untuk table soal */
    @media (max-width: 992px) {
        table.table th,
        table.table td {
            font-size: 0.85rem; /* perkecil teks agar muat */
            white-space: nowrap; /* cegah pecah aneh */
        }

        table.table td {
            max-width: 150px; 
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .aksi-btn {
            padding: 4px 6px;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 768px) {
        .table-responsive {
            border: 0;
        }
        table.table {
            font-size: 0.8rem;
        }

        /* Biar tombol aksi tetap enak diklik */
        .aksi-btn {
            display: inline-block;
            margin: 2px 0;
        }

        /* Header judul */
        h2.fw-bold {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 576px) {
        /* Modal biar pas di layar kecil */
        .modal-dialog {
            margin: 0.5rem;
        }

        .modal-content {
            border-radius: 0.75rem;
        }

        table.table th,
        table.table td {
            font-size: 0.75rem;
        }

        .btn {
            font-size: 0.75rem;
            padding: 4px 8px;
        }
    }
</style>
@endpush
