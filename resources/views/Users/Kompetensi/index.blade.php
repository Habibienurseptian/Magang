@extends('layouts.app')

@section('page_title', 'Uji Kompetensi')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-center">Daftar Uji Kompetensi</h2>
    <!-- Kategori Filter -->
    <div class="mb-4" style="overflow-x: auto; white-space: nowrap;">
        <div class="d-inline-flex gap-2" style="min-width: 100%;">
            @php
            $currentSkill = isset($skill_id) ? (int)$skill_id : 0;
            @endphp
            <a href="?skill_id=all" class="btn btn-outline-primary kompetensi-cat-btn{{ $currentSkill == 0 ? ' active' : '' }}">Semua</a>
            @foreach($skills as $skill)
                <a href="?skill_id={{ $skill->id }}" class="btn btn-outline-primary kompetensi-cat-btn{{ $currentSkill == $skill->id ? ' active' : '' }}">{{ $skill->name }}</a>
            @endforeach
        </div>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="" class="mb-4">
        <div class="row g-2 justify-content-center">
            <div class="col-md-6 col-12">
                <div class="d-flex flex-row flex-md-row gap-2 align-items-center user-kompetensi-search-mobile">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul/bidang..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary d-flex align-items-center"><i class="fa fa-search me-1"></i> <span class="d-none d-md-inline">Cari</span></button>
                    @if(request('search'))
                        <a href="?skill_id={{ $currentSkill }}" class="btn btn-secondary d-flex align-items-center"><i class="fa fa-times me-1"></i> <span class="d-none d-md-inline">Reset</span></a>
                    @endif
                </div>
            </div>
        </div>
    </form>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="kompetensi-list">
        @php
            $userLevel = strtolower(Auth::user()->skill_level ?? '');
            $userSkill = strtolower(Auth::user()->skill ?? '');
        @endphp
        @forelse($kompetensis as $kompetensi)
            @php
                $kompetensiLevel = strtolower($kompetensi->level ?? '');
                $kompetensiSkill = strtolower($kompetensi->skill->name ?? '');
                $canAccess = $userLevel === $kompetensiLevel && $userSkill === $kompetensiSkill;
            @endphp
            <div class="col" data-skill="{{ $kompetensi->skill ? strtolower($kompetensi->skill->name) : '-' }}">
                <div class="card h-100 shadow border-0 kompetensi-modern-card position-relative overflow-hidden">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="card-title fw-bold mb-0">{{ $kompetensi->title }}</h5>
                            <span class="badge kompetensi-badge-kategori ms-2 d-flex align-items-center" style="background:linear-gradient(90deg,#4f8cff 0%,#6fd6ff 100%);color:#fff;font-size:0.95rem;">
                                <i class="fas fa-tag me-1"></i> {{ $kompetensi->skill ? $kompetensi->skill->name : '-' }}
                            </span>
                        </div>
                        <div class="mb-2">
                            @php
                                $levelClass = 'learning-badge-level badge-sm';
                                if ($kompetensiLevel == 'pemula') $levelClass .= ' learning-badge-level-pemula';
                                elseif ($kompetensiLevel == 'menengah') $levelClass .= ' learning-badge-level-menengah';
                                elseif ($kompetensiLevel == 'ahli') $levelClass .= ' learning-badge-level-ahli';
                            @endphp
                            <span class="badge px-2 py-1 me-1 {{ $levelClass }}" style="font-size:0.85rem;min-width:60px;border-radius:0.375rem;">Level: {{ $kompetensi->level ?? '-' }}</span>
                        </div>
                        <p class="card-text text-secondary mb-3" style="min-height:60px;">{{ $kompetensi->description }}<br><span class="badge bg-light text-dark mt-2"><i class="far fa-clock me-1"></i>Durasi: {{ $kompetensi->duration }} menit</span></p>
                        @if($kompetensi->is_available)
                            <span class="badge bg-success mb-2 w-50">Tersedia</span>
                            @if(!empty($isPassedArr[$kompetensi->id]) && $isPassedArr[$kompetensi->id])
                                <div class="mb-2">
                                    <span class="badge bg-info text-dark w-100">Skor Terakhir: <b>{{ $scoreArr[$kompetensi->id] }}</b></span>
                                </div>
                                <button class="btn btn-outline-success mt-auto w-100" disabled><i class="fas fa-check-circle me-1"></i> Sudah Lulus</button>
                            @else
                                @if($canAccess)
                                    <a href="{{ route('users.kompetensi.show', $kompetensi->id) }}" class="btn kompetensi-gradient-btn mt-auto fw-semibold w-100"><i class="fas fa-play-circle me-1"></i> Mulai Uji</a>
                                @else
                                    <button class="btn btn-outline-secondary mt-auto w-100" disabled>Tidak Bisa Diakses</button>
                                @endif
                            @endif
                        @else
                            <span class="badge bg-secondary mb-2 w-50">Belum Tersedia</span>
                            <a href="#" class="btn btn-outline-secondary mt-auto disabled">Belum Bisa Diakses</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
        <div class="col">
            <div class="alert alert-warning w-100 text-center">Belum ada uji kompetensi tersedia.</div>
        </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $kompetensis->links('vendor.pagination.custom') }}
    </div>
</div>
<!-- Kategori filter kini menggunakan link agar pagination tetap sesuai filter kategori -->
@endsection
