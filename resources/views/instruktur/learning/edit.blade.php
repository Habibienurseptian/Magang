@extends('layouts.app')

@section('page_title', 'Edit Learning Path')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Edit Learning Path</h2>
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" action="{{ route('instruktur.learning.update', $learning->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $learning->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bidang</label>
                    <select name="skill_id" class="form-select" required>
                        <option value="">-- Pilih Bidang --</option>
                        @foreach($skills as $skill)
                            <option value="{{ $skill->id }}" {{ old('skill_id', $learning->skill_id)==$skill->id?'selected':'' }}>{{ $skill->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kompetensi</label>
                    <select name="competency_id" class="form-select" required>
                        <option value="">-- Pilih Kompetensi --</option>
                        @foreach($competencies as $competency)
                            <option value="{{ $competency->id }}" {{ old('competency_id', $learning->competency_id)==$competency->id?'selected':'' }}>{{ $competency->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tingkat Level</label>
                    <select name="level" class="form-select" required>
                        <option value="">-- Pilih Level --</option>
                        <option value="Pemula" {{ old('level', $learning->level)=='Pemula'?'selected':'' }}>Pemula</option>
                        <option value="Menengah" {{ old('level', $learning->level)=='Menengah'?'selected':'' }}>Menengah</option>
                        <option value="Ahli" {{ old('level', $learning->level)=='Ahli'?'selected':'' }}>Ahli</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Upload Gambar</label>
                    <input class="form-control" type="file" name="image" accept="image/*">
                    @if ($learning->image)
                        <img src="{{ asset('storage/' . $learning->image) }}" alt="Current Image" class="img-thumbnail mt-2" width="150">
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">URL Video YouTube</label>
                    <input type="url" name="youtube_url" class="form-control" value="{{ old('youtube_url', $learning->youtube_url) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Batas Menonton (menit)</label>
                    <input 
                        type="number" 
                        name="watch_limit_minutes" 
                        class="form-control" 
                        min="1" 
                        placeholder="Contoh: 2"
                        value="{{ old('watch_limit_minutes', $learning->watch_limit_minutes) }}"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ old('description', $learning->description) }}</textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('instruktur.learning.index') }}" class="btn btn-secondary me-2"><i class="fa fa-arrow-left me-1"></i> Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
