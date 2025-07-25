@extends('layouts.app')

@section('page_title', 'Pilih Bidang Keahlian')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow border-0 p-4">
                <h3 class="fw-bold mb-3 text-center">Pilih Bidang Keahlian</h3>
                <form method="POST" action="{{ route('users.skills.save') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Bidang Keahlian</label>
                        <select name="skill" class="form-select" required>
                            <option value="">-- Pilih Salah Satu --</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->name }}">{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level Keahlian</label>
                        <select name="level" class="form-select" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="Pemula">Pemula</option>
                            <option value="Menengah">Menengah</option>
                            <option value="Ahli">Ahli</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="fa fa-check me-1"></i> Simpan & Lanjutkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
