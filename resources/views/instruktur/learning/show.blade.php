@extends('layouts.app')
@section('page_title', $learning->title ?? 'Detail Learning Path')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                @if($learning->image)
                    <img src="{{ asset('storage/' . $learning->image) }}" 
                        class="card-img-top" 
                        alt="{{ $learning->title }}">
                @endif

                <div class="card-body">
                    <h3 class="card-title mb-3">{{ $learning->title }}</h3>
                    @php
                        function extractYoutubeId($url) {
                            $pattern = '%(?:youtube\.com/(?:.*v=|v/|embed/)|youtu\.be/)([^"&?/ ]{11})%i';
                            if (preg_match($pattern, $url, $matches)) {
                                return $matches[1];
                            }
                            return null;
                        }

                        $videoId = extractYoutubeId($learning->youtube_url);
                    @endphp

                    @if ($videoId)
                        <div class="mb-3">
                            <!-- <label class="form-label fw-bold">Video</label><br> -->
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    @else
                        <p class="text-danger">Video tidak valid atau tidak dapat diputar.</p>
                    @endif


                    <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge bg-primary rounded-pill px-3 py-2" style="font-size:1.05rem;min-width:80px;"><i class="fas fa-tag me-1"></i> {{ $learning->skill->name ?? '-' }}</span>
                        @php
                            $levelClass = 'learning-badge-level';
                            if (strtolower($learning->level ?? '') == 'pemula') $levelClass .= ' learning-badge-level-pemula';
                            elseif (strtolower($learning->level ?? '') == 'menengah') $levelClass .= ' learning-badge-level-menengah';
                            elseif (strtolower($learning->level ?? '') == 'ahli') $levelClass .= ' learning-badge-level-ahli';
                        @endphp
                        <span class="badge rounded-pill px-3 py-2 {{ $levelClass }}" style="font-size:1.05rem;min-width:80px;"><i class="fas fa-signal me-1"></i>{{ $learning->level ?? '-' }}</span>
                    </div>
                    <div class="card-text">
                        {!! preg_replace(
                            '/<img(.*?)>/i',
                            '<img class="img-fluid rounded shadow-sm my-2"$1>',
                            str_replace(
                                ['<table', '<blockquote'],
                                [
                                    '<table class="table table-bordered table-sm"',
                                    '<blockquote class="blockquote"'
                                ],
                                $learning->description
                            )
                        ) !!}
                    </div>

                    <a href="{{ route('instruktur.learning.index') }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
