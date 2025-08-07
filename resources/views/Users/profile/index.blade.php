
@extends('layouts.app')

@section('page_title', 'Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0 profile-modern-card p-4">
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="profile-avatar mb-3">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=4f8cff&color=fff&size=128' }}" alt="Avatar" class="rounded-circle shadow" style="width:110px;height:110px;object-fit:cover;">
                    </div>
                    <h3 class="fw-bold mb-1">{{ Auth::user()->name }}</h3>
                    <span class="text-muted mb-2"><i class="fa fa-envelope me-1"></i> {{ Auth::user()->email }}</span>
                    <span class="text-muted mb-2"><i class="fa fa-phone me-1"></i> Telepon: {{ Auth::user()->phone ?? '-' }}</span>
                    <span class="text-muted mb-2"><i class="fa fa-id-card me-1"></i> NIK: {{ Auth::user()->nik }}</span>
                    <span class="badge bg-primary mb-3" style="font-size:1rem;">User</span>
                    <a href="{{ route('users.profile.edit') }}" class="btn btn-outline-primary rounded-pill px-4 mb-2"><i class="fa fa-edit me-1"></i> Edit Profil</a>
                </div>
                <!-- Bidang Keahlian / Role Keahlian -->
                <div class="mt-3 mb-2 w-100">
                    <div class="fw-bold text-start mb-2" style="font-size:1.08rem;">Bidang Keahlian</div>
                    <div class="d-flex flex-wrap gap-2">
                        @if(Auth::user()->skill)
                            <span class="badge bg-success px-3 py-2 fs-6"><i class="fa fa-user-tie me-1"></i> {{ Auth::user()->skill }}</span>
                        @endif
                        @if(Auth::user()->skill_level)
                            <span class="badge bg-primary px-3 py-2 fs-6"><i class="fa fa-star me-1"></i> {{ Auth::user()->skill_level }}</span>
                        @endif
                        @if(!Auth::user()->skill && !Auth::user()->skill_level)
                            <span class="text-muted">Belum memilih bidang keahlian</span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-muted small mb-1">Tanggal Daftar</div>
                        <div class="fw-semibold">{{ Auth::user()->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small mb-1">Terakhir Update</div>
                        <div class="fw-semibold">{{ Auth::user()->updated_at->format('d M Y') }}</div>
                    </div>
                </div>

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
.profile-avatar img {
    border: 4px solid #f4f8ff;
    box-shadow: 0 2px 8px 0 rgba(79,140,255,0.13);
}
@media (max-width: 767.98px) {
    .profile-modern-card {
        padding: 1.2rem !important;
    }
    .profile-avatar img {
        width: 80px !important;
        height: 80px !important;
    }
}
</style>
@endpush

@endsection
