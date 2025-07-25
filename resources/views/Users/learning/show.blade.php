@extends('layouts.app')
@section('page_title', $learning->title ?? 'Detail Learning Path')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                @if($learning->image)
                    <img src="{{ $learning->image }}" class="card-img-top" alt="{{ $learning->title }}">
                @endif
                <div class="card-body">
                    <h3 class="card-title mb-3">{{ $learning->title }}</h3>
                    <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge learning-badge-skill d-flex align-items-center"><i class="fa fa-lightbulb me-1"></i> {{ $learning->skill->name ?? '-' }}</span>
                        @php
                            $levelClass = 'learning-badge-level';
                            if (strtolower($learning->level) == 'pemula') $levelClass .= ' learning-badge-level-pemula';
                            elseif (strtolower($learning->level) == 'menengah') $levelClass .= ' learning-badge-level-menengah';
                            elseif (strtolower($learning->level) == 'ahli') $levelClass .= ' learning-badge-level-ahli';
                        @endphp
                        <span class="badge {{ $levelClass }} d-flex align-items-center"><i class="fa fa-signal me-1"></i> {{ ucfirst($learning->level) }}</span>
                    </div>
                    <p class="card-text">{!! nl2br(e($learning->description)) !!}</p>
                    <a href="{{ route('users.learning.index') }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
