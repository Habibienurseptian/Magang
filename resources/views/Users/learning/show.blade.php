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
                        <div class="mb-3" id="video-wrapper">
                            <div class="ratio ratio-16x9">
                                <iframe id="ytplayer"
                                        src="https://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1&rel=0&autoplay=0&modestbranding=1"
                                        frameborder="0"
                                        allowfullscreen>
                                </iframe>
                            </div>
                        </div>

                        <!-- Tombol Lanjut ke Uji Kompetensi -->
                        <div class="mb-3 text-center">
                            <a href="{{ route('users.kompetensi.show', $learning->competency->id) }}"
                               id="btn-exam"
                               class="btn btn-primary d-none">
                                <i class="fas fa-check-circle me-1"></i> Lanjut ke Uji Kompetensi
                            </a>
                        </div>
                    @else
                        <p class="text-danger">Video tidak valid atau tidak dapat diputar.</p>
                    @endif

                    <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge learning-badge-skill d-flex align-items-center">
                            <i class="fa fa-lightbulb me-1"></i> {{ $learning->skill->name ?? '-' }}
                        </span>
                        @php
                            $levelClass = 'learning-badge-level';
                            if (strtolower($learning->level) == 'pemula') $levelClass .= ' learning-badge-level-pemula';
                            elseif (strtolower($learning->level) == 'menengah') $levelClass .= ' learning-badge-level-menengah';
                            elseif (strtolower($learning->level) == 'ahli') $levelClass .= ' learning-badge-level-ahli';
                        @endphp
                        <span class="badge {{ $levelClass }} d-flex align-items-center">
                            <i class="fa fa-signal me-1"></i> {{ ucfirst($learning->level) }}
                        </span>
                    </div>

                    <p class="card-text">{!! nl2br(e($learning->description)) !!}</p>

                    <a href="{{ route('users.learning.index') }}" class="btn btn-secondary mt-3">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Animate.css for button effect -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<!-- YouTube Iframe API -->
<script src="https://www.youtube.com/iframe_api"></script>
<script>
    let player;

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('ytplayer', {
            playerVars: {
                rel: 0,
                autoplay: 0,
                modestbranding: 1
            },
            events: {
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerStateChange(event) {
        if (event.data === YT.PlayerState.ENDED) {
            // Sembunyikan video player saat selesai
            const iframeWrapper = document.getElementById('video-wrapper');
            if (iframeWrapper) iframeWrapper.style.display = 'none';

            // Tampilkan tombol ujian dengan animasi
            const btn = document.getElementById('btn-exam');
            btn.classList.remove('d-none');
            btn.classList.add('animate__animated', 'animate__fadeInUp');
        }
    }
</script>
@endpush
