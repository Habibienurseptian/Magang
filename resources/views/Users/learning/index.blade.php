@extends('layouts.app')

@php
    use App\Helpers\AesHelper;
@endphp

@section('page_title', 'Learning Path')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Learning Skill</h2>
    <!-- Filter Kategori -->
    <div class="mb-4" style="overflow-x: auto; white-space: nowrap;">
        <div class="d-inline-flex gap-2" style="min-width: 100%;">
            @php $activeSkill = request('skill', 'all'); @endphp
            <a href="?skill=all" class="btn btn-outline-primary category-btn {{ $activeSkill == 'all' ? 'active' : '' }}">Semua</a>
            @foreach($skills as $skill)
                <a href="?skill={{ $skill->id }}" class="btn btn-outline-primary category-btn {{ $activeSkill == $skill->id ? 'active' : '' }}">{{ $skill->name }}</a>
            @endforeach
        </div>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="" class="mb-4">
        <div class="row g-2 justify-content-center">
            <div class="col-md-6 col-12">
                <div class="d-flex flex-row flex-md-row gap-2 align-items-center user-learning-search-mobile">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul/bidang..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary d-flex align-items-center"><i class="fa fa-search me-1"></i> <span class="d-none d-md-inline">Cari</span></button>
                    @if(request('search'))
                        <a href="?skill={{ request('skill', 'all') }}" class="btn btn-secondary d-flex align-items-center"><i class="fa fa-times me-1"></i> <span class="d-none d-md-inline">Reset</span></a>
                    @endif
                </div>
            </div>
        </div>
    </form>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-start" id="learning-path-list">
        @php
            $userLevel = strtolower(Auth::user()->skill_level ?? '');
            $userSkill = strtolower(Auth::user()->skill ?? '');
        @endphp
        @forelse($learnings as $learning)
            @php
                $learningLevel = strtolower($learning->level ?? '');
                $learningSkill = strtolower($learning->skill->name ?? '');
                $canAccess = $userLevel === $learningLevel && $userSkill === $learningSkill;
            @endphp
            <div class="col mb-4">
                <div class="card modern-card h-100 border-0 shadow-lg position-relative" style="border-radius:1.5rem;overflow:hidden;transition:box-shadow .22s, transform .22s;">
                    <div class="position-relative">
                        <img src="{{ $learning->image ? asset('storage/' . $learning->image) : 'https://via.placeholder.com/400' }}"
                            alt="{{ $learning->title }}"
                            class="img-fluid rounded shadow-sm">
                        @php
                            $levelClass = 'learning-badge-level';
                            if ($learningLevel == 'pemula') $levelClass .= ' learning-badge-level-pemula';
                            elseif ($learningLevel == 'menengah') $levelClass .= ' learning-badge-level-menengah';
                            elseif ($learningLevel == 'ahli') $levelClass .= ' learning-badge-level-ahli';
                        @endphp
                        <span class="badge {{ $levelClass }} position-absolute top-0 end-0 m-2 d-flex align-items-center gap-1 shadow">
                            <i class="fa fa-signal me-1"></i> {{ ucfirst($learning->level) }}
                        </span>
                    </div>
                    <div class="card-body d-flex flex-column px-4 py-3" style="background:rgba(255,255,255,0.98);">
                        <div class="d-flex flex-column align-items-start mb-2 gap-1">
                            <h5 class="card-title mb-0 me-2" style="font-size:1.18rem;font-weight:700;letter-spacing:.01em;">{{ $learning->title }}</h5>
                            <span class="badge bg-gradient-primary text-white text-capitalize d-inline-flex align-items-center gap-1 shadow" style="font-size:0.98rem;border-radius:0.7rem;box-shadow:0 2px 8px 0 rgba(60,60,60,0.10);padding:.38em 1em .38em .8em;">
                                <i class="fa fa-lightbulb me-1"></i> {{ $learning->skill->name ?? '-' }}
                            </span>
                        </div>
                        <p class="card-text text-secondary mb-3">
                            {!! Str::limit(
                                str_replace(
                                    ['<table', '<blockquote'],
                                    ['<table class="table table-bordered table-sm"', '<blockquote class="blockquote"'],
                                    $learning->description
                                ),
                                15,
                                '...'
                            ) !!}
                        </p>
                        @if($canAccess)
                            <a href="{{ route('users.learning.show', AesHelper::encryptId($learning->id, 'learning')) }}" class="btn btn-gradient-primary mt-auto rounded-pill px-4 py-2 shadow-sm" style="font-weight:600;letter-spacing:.01em;font-size:1.04rem;transition:background .18s, color .18s;">Mulai Belajar <i class="fa fa-arrow-right ms-1"></i></a>
                        @else
                            <button class="btn btn-outline-secondary mt-auto rounded-pill px-4 py-2 shadow-sm" style="font-weight:600;letter-spacing:.01em;font-size:1.04rem;" disabled>Tidak Bisa Diakses</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                Belum ada Learning Path yang tersedia.
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center align-items-center p-3">
        {{ $learnings->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.custom') }}
    </div>
</div>


<!-- Script filter kategori dihapus, karena filter sekarang dilakukan di backend -->
@endsection
