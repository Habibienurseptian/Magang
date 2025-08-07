@extends('layouts.app')
@section('page_title', 'Dashboard')
@section('content')

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
                        <div class="fw-bold fs-5 mb-0">{{ $info['learning_path_aktif'] ?? '0' }}</div>
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
                        <div class="fw-bold fs-5 mb-0">{{ $info['uji_kompetensi_aktif'] ?? '0' }}</div>
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
    <!-- <div class="col-md-4">
        <div class="card h-100 mb-3 mb-md-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                <ul class="list-group list-group-flush">
                    @forelse($recentActivities as $activity)
                        <li class="list-group-item">{!! $activity !!}</li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada aktivitas terbaru.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div> -->
    <div class="col-md-4">
        <!-- <div class="card mb-3 mb-md-0" style="height: max-content;">
            <div class="card-header bg-white">
                <h5 class="mb-0">Task Sertifikat</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label mb-1">Progress Uji Kompetensi per Bidang & Level</label>
                    <div class="progress" style="height: 22px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $info['progress_kompetensi'] ?? 0 }}%;" aria-valuenow="{{ $info['progress_kompetensi'] ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $info['progress_kompetensi'] ?? 0 }}%
                        </div>
                    </div>
                    <small class="text-muted">{{ $info['kompetensi_selesai'] ?? 0 }} dari {{ $info['kompetensi_total'] ?? 0 }} uji kompetensi bidang & level telah diselesaikan</small>
                </div>
                <hr>
                <p class="mb-0 small text-muted">Pantau progress dan pastikan semua task serta persyaratan telah selesai untuk mendapatkan sertifikat.</p>
            </div>
        </div> -->
        <div class="mb-3"></div>
        <div class="card mb-3 mb-md-0" style="height: max-content;">
            <div class="card-header bg-white">
                <h5 class="mb-0">Informasi Umum</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li><i class="fas fa-calendar-alt me-2 text-primary"></i> Tahun: <b>{{ $info['tahun_akademik'] ?? '2025/2026' }}</b></li>
                    <li><i class="fas fa-users me-2 text-success"></i> Total User: <b>{{ $info['total_user'] ?? '0' }}</b></li>
                    <li><i class="fas fa-user me-2 text-secondary"></i> User: <b>{{ $info['total_peserta'] ?? '0' }}</b></li>
                    <li><i class="fas fa-route me-2 text-warning"></i> Learning Path Aktif: <b>{{ $info['learning_path_aktif'] ?? '0' }}</b></li>
                    <li><i class="fas fa-clipboard-check me-2 text-info"></i> Uji Kompetensi Aktif: <b>{{ $info['uji_kompetensi_aktif'] ?? '0' }}</b></li>
                    <li><i class="fas fa-briefcase me-2 text-danger-emphasis"></i> Bidang Keahlian: <b>{{ $info['bidang_keahlian'] ?? 0 }}</b></li>
                </ul>
                <hr>
                <p class="mb-0 small text-muted">Selamat datang di dashboard PelaonApp. Pantau perkembangan pembelajaran, uji kompetensi, dan raih sertifikat terbaikmu!</p>
            </div>
        </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection