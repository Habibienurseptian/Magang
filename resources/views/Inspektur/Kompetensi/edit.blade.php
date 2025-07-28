@extends('layouts.app')

@section('page_title', 'Edit Uji Kompetensi')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">Edit Uji Kompetensi</h2>
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white fw-bold">Form Edit Uji Kompetensi</div>
        <div class="card-body">
            <form method="POST" action="{{ route('inspektur.kompetensi.update', $kompetensi->id) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $kompetensi->title) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bidang</label>
                        <select name="skill_id" class="form-select" required>
                            <option value="">-- Pilih Bidang --</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" {{ old('skill_id', $kompetensi->skill_id)==$skill->id?'selected':'' }}>{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tingkat Level</label>
                        <select name="level" class="form-select" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="Pemula" {{ old('level', $kompetensi->level)=='Pemula'?'selected':'' }}>Pemula</option>
                            <option value="Menengah" {{ old('level', $kompetensi->level)=='Menengah'?'selected':'' }}>Menengah</option>
                            <option value="Ahli" {{ old('level', $kompetensi->level)=='Ahli'?'selected':'' }}>Ahli</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Durasi (menit)</label>
                        <input type="number" name="duration" class="form-control" min="1" value="{{ old('duration', $kompetensi->duration) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2" required>{{ old('description', $kompetensi->description) }}</textarea>
                    </div>
                    <div class="col-12 text-end">
                        <a href="{{ route('inspektur.kompetensi.index') }}" class="btn btn-secondary me-2"><i class="fa fa-arrow-left me-1"></i> Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
