<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="fw-bold mb-3">Selamat Datang di MagangApp</h1>
                    <p class="lead text-muted">Platform pembelajaran, uji kompetensi, dan sertifikasi modern untuk generasi digital.</p>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card h-100 text-center border-0 shadow-sm">
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width:48px;height:48px;font-size:1.5rem;">
                                        <i class="fas fa-route"></i>
                                    </span>
                                </div>
                                <h5 class="card-title">Learning Path</h5>
                                <p class="card-text small">Jelajahi berbagai jalur pembelajaran sesuai minat dan karirmu.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center border-0 shadow-sm">
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width:48px;height:48px;font-size:1.5rem;">
                                        <i class="fas fa-clipboard-check"></i>
                                    </span>
                                </div>
                                <h5 class="card-title">Uji Test</h5>
                                <p class="card-text small">Uji kemampuanmu dan dapatkan sertifikat resmi dari MagangApp.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center border-0 shadow-sm">
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width:48px;height:48px;font-size:1.5rem;">
                                        <i class="fas fa-certificate"></i>
                                    </span>
                                </div>
                                <h5 class="card-title">Sertifikat</h5>
                                <p class="card-text small">Raih sertifikat digital untuk setiap kompetensi yang kamu kuasai.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('login') }}" class="btn btn-dark btn-lg px-4"><i class="fas fa-route me-2"></i> Mulai Belajar </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>