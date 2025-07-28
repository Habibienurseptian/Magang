@extends('layouts.app')

@section('page_title', 'Edit Learning Path')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Edit Learning Path</h2>
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('inspektur.learning.update', $learning->id) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $learning->title) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bidang</label>
                        <select name="skill_id" class="form-select" required>
                            <option value="">-- Pilih Bidang --</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->id }}" {{ old('skill_id', $learning->skill_id)==$skill->id?'selected':'' }}>{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tingkat Level</label>
                        <select name="level" class="form-select" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="Pemula" {{ old('level', $learning->level)=='Pemula'?'selected':'' }}>Pemula</option>
                            <option value="Menengah" {{ old('level', $learning->level)=='Menengah'?'selected':'' }}>Menengah</option>
                            <option value="Ahli" {{ old('level', $learning->level)=='Ahli'?'selected':'' }}>Ahli</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">URL Gambar</label>
                        <input type="url" name="image" class="form-control" value="{{ old('image', $learning->image) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2" required>{{ old('description', $learning->description) }}</textarea>
                    </div>
                    <div class="col-12 text-end">
                        <a href="{{ route('inspektur.learning.index') }}" class="btn btn-secondary me-2"><i class="fa fa-arrow-left me-1"></i> Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
