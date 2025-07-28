@extends('layouts.app')
@section('page_title', 'Dashboard')
@section('content')
<!-- Main Content -->

<div class="row g-4 mb-4 dashboard-mobile-card-spacing">
    <div class="col-12">
        <h4 class="fw-bold mb-3">Dashboard</h4>
        <div class="row w-100 mx-0 dashboard-mobile-card-spacing">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="bg-white shadow rounded-4 p-3 d-flex align-items-center gap-3 h-100" style="min-width: 0;">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                        <i class="fas fa-route fa-lg"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold fs-5 mb-0">{{ $learningCount ?? 0 }}</div>
                        <small class="text-muted">Learning Path Tersedia</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="bg-white shadow rounded-4 p-3 d-flex align-items-center gap-3 h-100" style="min-width: 0;">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                        <i class="fas fa-clipboard-check fa-lg"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold fs-5 mb-0">{{ $kompetensiCount ?? 0 }}</div>
                        <small class="text-muted">Uji Kompetensi Tersedia</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel Banner di bawah card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card p-0 overflow-hidden position-relative" style="border-radius: 1.5rem;">
            <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=900&q=80" class="d-block w-100" style="height:220px;object-fit:cover;" alt="Banner 1">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <h4 class="fw-bold text-shadow">Selamat Datang di PelaonApp</h4>
                            <p class="mb-0 text-shadow">Platform pembelajaran dan sertifikasi modern untuk generasi digital.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=900&q=80" class="d-block w-100" style="height:220px;object-fit:cover;" alt="Banner 2">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <h4 class="fw-bold text-shadow">Learning Path Interaktif</h4>
                            <p class="mb-0 text-shadow">Jelajahi berbagai jalur pembelajaran sesuai minat dan karirmu.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://images.unsplash.com/photo-1503676382389-4809596d5290?auto=format&fit=crop&w=900&q=80" class="d-block w-100" style="height:220px;object-fit:cover;" alt="Banner 3">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <h4 class="fw-bold text-shadow">Uji Kompetensi & Sertifikat</h4>
                            <p class="mb-0 text-shadow">Buktikan kemampuanmu dan dapatkan sertifikat resmi.</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4 dashboard-mobile-card-spacing">
    <div class="col-md-4">
        <div class="card h-100 mb-3 mb-md-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">Daftar User</h5>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-light fw-bold">Admin</li>
                    @php $found = false; @endphp
                    @foreach($usersList ?? [] as $user)
                        @if($user->role === 'admin')
                            @php $found = true; @endphp
                            <li class="list-group-item">
                                <i class="fas fa-user-shield text-danger me-2"></i>
                                <b>{{ $user->name }}</b> <span class="badge bg-danger">Admin</span>
                            </li>
                        @endif
                    @endforeach
                    @if(!$found)
                        <li class="list-group-item text-muted">Tidak ada admin baru.</li>
                    @endif

                    <li class="list-group-item bg-light fw-bold">Inspektur</li>
                    @php $found = false; @endphp
                    @foreach($usersList ?? [] as $user)
                        @if($user->role === 'inspektur')
                            @php $found = true; @endphp
                            <li class="list-group-item">
                                <i class="fas fa-user-tie text-primary me-2"></i>
                                <b>{{ $user->name }}</b> <span class="badge bg-primary">Inspektur</span>
                            </li>
                        @endif
                    @endforeach
                    @if(!$found)
                        <li class="list-group-item text-muted">Tidak ada inspektur baru.</li>
                    @endif

                    <li class="list-group-item bg-light fw-bold">User</li>
                    @php $found = false; @endphp
                    @foreach($usersList ?? [] as $user)
                        @if($user->role === 'user')
                            @php $found = true; @endphp
                            <li class="list-group-item">
                                <i class="fas fa-user text-secondary me-2"></i>
                                <b>{{ $user->name }}</b> <span class="badge bg-secondary">User</span>
                            </li>
                        @endif
                    @endforeach
                    @if(!$found)
                        <li class="list-group-item text-muted">Tidak ada user baru.</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3 mb-md-0" style="height: max-content;">
            <div class="card-header bg-white">
                <h5 class="mb-0">Informasi Umum</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li><i class="fas fa-calendar-alt me-2 text-primary"></i> Tahun: <b>{{ $tahunAkademik ?? '-' }}</b></li>
                    <li><i class="fas fa-users me-2 text-success"></i> Total User: <b>{{ $totalUser ?? 0 }}</b></li>
                    <li><i class="fas fa-user-shield me-2 text-danger"></i> Total Admin: <b>{{ $totalAdmin ?? 0 }}</b></li>
                    <li><i class="fas fa-route me-2 text-warning"></i> Learning Path Aktif: <b>{{ $learningCount ?? 0 }}</b></li>
                    <li><i class="fas fa-clipboard-check me-2 text-info"></i> Uji Kompetensi Aktif: <b>{{ $kompetensiCount ?? 0 }}</b></li>
                    <li><i class="fas fa-certificate me-2 text-secondary"></i> Sertifikat Diterbitkan: <b>{{ $sertifikatCount ?? 0 }}</b></li>
                </ul>
                <hr>
                <p class="mb-0 small text-muted">Selamat datang di dashboard PelaonApp. Pantau perkembangan pembelajaran, uji kompetensi, dan raih sertifikat terbaikmu!</p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection