
@extends('layouts.app')

@section('page_title', 'Detail Uji Kompetensi')

@section('content')
<div class="container py-4">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 kompetensi-detail-modern-card">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-3">
                        <div class="d-flex flex-column flex-md-row align-items-center gap-2 w-100 justify-content-between">
                            <h2 class="fw-bold mb-0 text-center text-md-start">{{ $kompetensi->title }}</h2>
                            <div class="d-flex flex-row flex-wrap gap-2 align-items-center justify-content-center justify-content-md-end">
                                <span class="badge kompetensi-badge-kategori-gradient d-flex align-items-center" style="font-size:1.05rem;">
                                    <i class="fas fa-tag me-1"></i> {{ $kompetensi->skill ? $kompetensi->skill->name : '-' }}
                                </span>
                                @php
                                    $levelClass = 'learning-badge-level';
                                    if (strtolower($kompetensi->level ?? '') == 'pemula') $levelClass .= ' learning-badge-level-pemula';
                                    elseif (strtolower($kompetensi->level ?? '') == 'menengah') $levelClass .= ' learning-badge-level-menengah';
                                    elseif (strtolower($kompetensi->level ?? '') == 'ahli') $levelClass .= ' learning-badge-level-ahli';
                                @endphp
                                <span class="badge rounded-pill px-3 py-2 me-1 d-flex align-items-center {{ $levelClass }}" style="font-size:1.05rem;min-width:80px;">
                                    <i class="fas fa-signal me-1"></i> {{ $kompetensi->level ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <span class="badge kompetensi-badge-durasi"><i class="far fa-clock me-1"></i> Durasi: {{ $kompetensi->duration }} menit</span>
                    </div>
                    <p class="mb-4 text-secondary" style="font-size:1.1rem;">{!! nl2br(e($kompetensi->description)) !!}</p>
                    <div class="mb-4 text-center">
                        @if($kompetensi->is_available)
                            <span class="badge bg-success px-3 py-2 fs-6 rounded-pill">Tersedia</span>
                        @else
                            <span class="badge bg-secondary px-3 py-2 fs-6 rounded-pill">Belum Tersedia</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('users.kompetensi.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="fa fa-arrow-left me-1"></i> Kembali</a>
                        @if($kompetensi->is_available)
                            @if(!empty($isPassed) && $isPassed)
                                <button class="btn btn-outline-success btn-lg rounded-pill px-4" disabled>Sudah Lulus</button>
                            @else
                                <a href="{{ route('users.kompetensi.exam', $kompetensi->id) }}" class="btn kompetensi-gradient-btn btn-lg rounded-pill px-4 fw-semibold"><i class="fas fa-play-circle me-1"></i> Mulai</a>
                            @endif
                        @else
                            <button class="btn btn-outline-secondary btn-lg rounded-pill px-4" disabled>Belum Bisa Diakses</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
