@extends('layouts.app')

@section('page_title', 'Kelola Soal Uji Kompetensi')

@section('content')
<div class="container py-4">
    <style>
        
    </style>
    <h2 class="mb-4 fw-bold text-center">Kelola Soal Uji Kompetensi</h2>

    <!-- Form Tambah Soal -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white fw-bold">Tambah Soal</div>
        <div class="card-body">
            <form method="POST" action="#">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea name="question" class="form-control" rows="2" required></textarea>
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
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Tambah Soal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="{{ route('instruktur.kompetensi.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left me-1"></i> Kembali ke Daftar Kompetensi</a>
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
