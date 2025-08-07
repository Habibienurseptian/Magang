@extends('layouts.app')

@section('page_title', 'Hasil Ujian Kompetensi')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 kompetensi-result-modern-card">
                <div class="card-body p-4 text-center">
                    <h2 class="fw-bold mb-3">Hasil Ujian: {{ $kompetensi->title }}</h2>
                    <div class="mb-4 d-flex flex-wrap justify-content-center gap-2">
                        <span class="badge kompetensi-badge-kategori-gradient d-flex align-items-center"><i class="fas fa-tag me-1"></i> {{ $kompetensi->skill ? $kompetensi->skill->name : '-' }}</span>
                        @php
                            $levelClass = 'learning-badge-level';
                            if (strtolower($kompetensi->level ?? '') == 'pemula') $levelClass .= ' learning-badge-level-pemula';
                            elseif (strtolower($kompetensi->level ?? '') == 'menengah') $levelClass .= ' learning-badge-level-menengah';
                            elseif (strtolower($kompetensi->level ?? '') == 'ahli') $levelClass .= ' learning-badge-level-ahli';
                        @endphp
                        <span class="badge kompetensi-badge-level rounded-pill d-flex align-items-center {{ $levelClass }}"><i class="fas fa-signal me-1"></i>{{ $kompetensi->level ?? '-' }}</span>
                        <span class="badge kompetensi-badge-durasi"><i class="far fa-clock me-1"></i> Durasi: {{ $kompetensi->duration }} menit</span>
                    </div>
                    <div class="kompetensi-score-box mb-3 mx-auto">
                        <span class="kompetensi-score-main">{{ $score }}</span>
                        <span class="kompetensi-score-total">/ {{ $total }}</span>
                    </div>
                    <div class="mb-4">
                        <span class="fs-5">Skor Anda: <b>{{ round($score/$total*100) }}%</b></span>
                    </div>
                    <a href="{{ route('users.kompetensi.index') }}" class="btn kompetensi-gradient-btn rounded-pill px-4 fw-semibold"><i class="fa fa-arrow-left me-1"></i> Kembali ke Daftar Uji Kompetensi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
