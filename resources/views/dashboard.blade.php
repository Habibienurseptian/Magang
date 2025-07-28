<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body style="background: linear-gradient(120deg, #f8fafc 0%, #e0e7ff 100%); min-height:100vh;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="fw-bold mb-3" style="font-size:2.5rem;letter-spacing:1px;">Selamat Datang di <span class="text-gradient">MagangApp</span></h1>
                    <p class="lead text-muted">Platform pembelajaran, uji kompetensi, dan sertifikasi modern untuk generasi digital.</p>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-12 col-sm-6 col-md-4 d-flex">
                        <div class="card h-100 w-100 text-center border-0 shadow-lg card-modern">
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="icon-gradient bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <i class="fas fa-route"></i>
                                    </span>
                                </div>
                                <h5 class="card-title fw-bold">Learning Path</h5>
                                <p class="card-text small">Jelajahi berbagai jalur pembelajaran sesuai minat dan karirmu.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 d-flex">
                        <div class="card h-100 w-100 text-center border-0 shadow-lg card-modern">
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="icon-gradient bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <i class="fas fa-clipboard-check"></i>
                                    </span>
                                </div>
                                <h5 class="card-title fw-bold">Uji Test</h5>
                                <p class="card-text small">Uji kemampuanmu dan dapatkan sertifikat resmi dari MagangApp.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 d-flex">
                        <div class="card h-100 w-100 text-center border-0 shadow-lg card-modern">
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="icon-gradient bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <i class="fas fa-certificate"></i>
                                    </span>
                                </div>
                                <h5 class="card-title fw-bold">Sertifikat</h5>
                                <p class="card-text small">Raih sertifikat digital untuk setiap kompetensi yang kamu kuasai.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <a href="{{ route('login') }}" class="btn btn-gradient btn-lg px-4"><i class="fas fa-route me-2"></i> Mulai Belajar </a>
                </div>
            </div>
        </div>
    </div>
    <footer class="mt-5 pt-4 pb-3 bg-white border-top shadow-sm text-center" style="border-radius:1.5rem 1.5rem 0 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <span class="fw-bold text-gradient">MagangApp</span> &copy; {{ date('Y') }} &mdash; All rights reserved.<br>
                    <small class="text-muted">Contact: <a href="mailto:support@magangapp.com" class="text-decoration-none text-gradient">support@magangapp.com</a></small>
                </div>
            </div>
        </div>
    </footer>
    <style>
        @media (max-width: 575.98px) {
            .card-modern { margin-bottom: 1rem; }
        }
        .text-gradient {
            background: linear-gradient(90deg,#6366f1,#06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
        .icon-gradient {
            width:48px;height:48px;font-size:1.5rem;
            box-shadow:0 2px 8px rgba(0,0,0,0.08);
            transition:transform .2s,box-shadow .2s;
        }
        .card-modern {
            border-radius:1.5rem;
            transition:box-shadow .2s,transform .2s;
        }
        .card-modern:hover {
            box-shadow:0 8px 32px rgba(99,102,241,0.15);
            transform:translateY(-4px) scale(1.03);
        }
        .btn-gradient {
            background: linear-gradient(90deg,#6366f1,#06b6d4);
            color:#fff;
            border:none;
            box-shadow:0 2px 8px rgba(99,102,241,0.12);
        }
        .btn-gradient:hover {
            background: linear-gradient(90deg,#06b6d4,#6366f1);
            color:#fff;
        }
    </style>
</body>
</html>