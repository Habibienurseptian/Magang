@extends('layouts.app')

@section('page_title', 'Edit Soal Uji Kompetensi')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">Edit Soal Uji Kompetensi</h2>

    <div class="card">
        <div class="card-header bg-white fw-bold">Edit Soal</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.kompetensi.soal.update', [$competency->id, $soal->id]) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea name="question" class="form-control" rows="2" required>{{ old('question', $soal->question) }}</textarea>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Pilihan A</label>
                        <input type="text" name="option_a" class="form-control" value="{{ old('option_a', $soal->option_a) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pilihan B</label>
                        <input type="text" name="option_b" class="form-control" value="{{ old('option_b', $soal->option_b) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pilihan C</label>
                        <input type="text" name="option_c" class="form-control" value="{{ old('option_c', $soal->option_c) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pilihan D</label>
                        <input type="text" name="option_d" class="form-control" value="{{ old('option_d', $soal->option_d) }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kunci Jawaban</label>
                    <select name="answer_key" class="form-select" required>
                        <option value="a" {{ old('answer_key', $soal->answer_key) == 'a' ? 'selected' : '' }}>A</option>
                        <option value="b" {{ old('answer_key', $soal->answer_key) == 'b' ? 'selected' : '' }}>B</option>
                        <option value="c" {{ old('answer_key', $soal->answer_key) == 'c' ? 'selected' : '' }}>C</option>
                        <option value="d" {{ old('answer_key', $soal->answer_key) == 'd' ? 'selected' : '' }}>D</option>
                    </select>
                </div>
                <div class="text-end">
                    <a href="{{ route('admin.kompetensi.soal.index', $competency->id) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
