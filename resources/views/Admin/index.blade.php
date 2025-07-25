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
                        <div class="fw-bold fs-5 mb-0">5</div>
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
                        <div class="fw-bold fs-5 mb-0">12</div>
                        <small class="text-muted">Uji Kompetensi Tersedia</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="bg-white shadow rounded-4 p-3 d-flex align-items-center gap-3 h-100" style="min-width: 0;">
                    <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                        <i class="fas fa-certificate fa-lg"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold fs-5 mb-0">3</div>
                        <small class="text-muted">Sertifikat Aktif</small>
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
                            <h4 class="fw-bold text-shadow">Selamat Datang di MagangApp</h4>
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
                <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fas fa-user-plus text-primary me-2"></i> User <b>John Doe</b> mendaftar pada 21 Juli 2025</li>
                    <li class="list-group-item"><i class="fas fa-book-open text-success me-2"></i> Learning Path <b>Web Development</b> baru ditambahkan</li>
                    <li class="list-group-item"><i class="fas fa-clipboard-check text-warning me-2"></i> Uji Kompetensi <b>PHP Dasar</b> telah selesai oleh <b>Jane</b></li>
                    <li class="list-group-item"><i class="fas fa-certificate text-info me-2"></i> <b>Jane</b> mendapatkan sertifikat <b>Frontend</b></li>
                    <li class="list-group-item"><i class="fas fa-user-edit text-secondary me-2"></i> Profil <b>John Doe</b> diperbarui</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 mb-3 mb-md-0">
            <div class="card-header bg-white">
                <h5 class="mb-0">Riwayat Tugas</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fas fa-tasks text-primary me-2"></i> Tugas <b>Project Landing Page</b> dikumpulkan oleh <b>Jane</b></li>
                    <li class="list-group-item"><i class="fas fa-tasks text-success me-2"></i> Tugas <b>Database Design</b> dinilai: <b>85/100</b></li>
                    <li class="list-group-item"><i class="fas fa-tasks text-warning me-2"></i> Tugas <b>UI/UX Wireframe</b> menunggu penilaian</li>
                    <li class="list-group-item"><i class="fas fa-tasks text-info me-2"></i> Tugas <b>API Integration</b> dikumpulkan oleh <b>John Doe</b></li>
                    <li class="list-group-item"><i class="fas fa-tasks text-secondary me-2"></i> Tugas <b>Final Report</b> belum dikumpulkan</li>
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
                    <li><i class="fas fa-calendar-alt me-2 text-primary"></i> Tahun Akademik: <b>2025/2026</b></li>
                    <li><i class="fas fa-users me-2 text-success"></i> Total Peserta: <b>1.245</b></li>
                    <li><i class="fas fa-route me-2 text-warning"></i> Learning Path Aktif: <b>5</b></li>
                    <li><i class="fas fa-clipboard-check me-2 text-info"></i> Uji Kompetensi Aktif: <b>12</b></li>
                    <li><i class="fas fa-certificate me-2 text-secondary"></i> Sertifikat Diterbitkan: <b>3</b></li>
                </ul>
                <hr>
                <p class="mb-0 small text-muted">Selamat datang di dashboard MagangApp. Pantau perkembangan pembelajaran, uji kompetensi, dan raih sertifikat terbaikmu!</p>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection