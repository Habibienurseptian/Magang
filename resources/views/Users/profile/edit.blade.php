
@extends('layouts.app')

@section('page_title', 'Edit Profil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0 profile-modern-card p-4">
                <h3 class="fw-bold mb-3 text-center">Edit Profil</h3>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('users.profile.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $user->phone) }}"
                            placeholder="Contoh: 081234567890"
                            pattern="[0-9]{10,15}"
                            inputmode="numeric">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bidang Keahlian</label>
                        <select name="skill" class="form-select" required>
                            <option value="">-- Pilih Salah Satu --</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->name }}" {{ old('skill', $user->skill)===$skill->name ? 'selected' : '' }}>{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level Keahlian</label>
                        <select name="skill_level" class="form-select" required>
                            <option value="">-- Pilih Level --</option>
                            <option value="Pemula" {{ old('skill_level', $user->skill_level)==='Pemula' ? 'selected' : '' }}>Pemula</option>
                            <option value="Menengah" {{ old('skill_level', $user->skill_level)==='Menengah' ? 'selected' : '' }}>Menengah</option>
                            <option value="Ahli" {{ old('skill_level', $user->skill_level)==='Ahli' ? 'selected' : '' }}>Ahli</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru <span class="text-muted small">(Opsional)</span></label>
                        <input type="password" name="password" class="form-control" autocomplete="new-password" placeholder="Isi jika ingin mengganti password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password" placeholder="Ulangi password baru">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('users.profile.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="fa fa-arrow-left me-1"></i> Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="fa fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@push('styles')
<style>
.profile-modern-card {
    border-radius: 1.5rem;
    background: #fff;
    box-shadow: 0 4px 24px 0 rgba(0,0,0,0.08), 0 1.5px 4px 0 rgba(0,0,0,0.04);
    transition: box-shadow 0.18s cubic-bezier(.4,2,.6,1);
}
.profile-modern-card:hover {
    box-shadow: 0 8px 32px 0 rgba(0,0,0,0.13), 0 2px 8px 0 rgba(0,0,0,0.07);
}
@media (max-width: 767.98px) {
    .profile-modern-card {
        padding: 1.2rem !important;
    }
    .profile-modern-card h3 {
        font-size: 1.25rem;
    }
    .profile-modern-card .form-label {
        font-size: 0.98rem;
    }
    .profile-modern-card .form-control {
        font-size: 0.98rem;
        padding: 0.6rem 0.9rem;
    }
    .profile-modern-card .btn {
        font-size: 0.98rem;
        padding: 0.5rem 1.1rem;
    }
    .profile-modern-card .d-flex.justify-content-between {
        flex-direction: column;
        gap: 0.75rem;
    }
}
</style>
@endpush

@endsection
