@extends('layouts.app')

@php
    use App\Helpers\AesHelper;
@endphp

@section('page_title', 'Ujian Kompetensi')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 kompetensi-exam-modern-card">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-3">
                        <div class="d-flex flex-column flex-md-row align-items-center gap-2 w-100 justify-content-between">
                            <h2 class="fw-bold mb-0 text-center text-md-start">Ujian: {{ $kompetensi->title }}</h2>
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
                                <span class="badge kompetensi-badge-level rounded-pill d-flex align-items-center {{ $levelClass }}" style="font-size:1.05rem;">
                                    <i class="fas fa-signal me-1"></i> {{ $kompetensi->level ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <span class="badge kompetensi-badge-durasi"><i class="far fa-clock me-1"></i> Durasi: {{ $kompetensi->duration }} menit</span>
                    </div>
                    <div class="kompetensi-timer-box mb-4 text-center">
                        <span class="fw-semibold text-dark">Sisa Waktu:</span> <span id="timer" class="fw-bold kompetensi-timer-text">{{ $kompetensi->duration }}:00</span>
                    </div>
                    <form method="POST" action="{{ route('users.kompetensi.exam.submit', AesHelper::encryptId($kompetensi->id)) }}" id="exam-form">
                        @csrf
                        @foreach($soals as $i => $soal)
                        <div class="mb-4">
                            <div class="card shadow-sm border-0 kompetensi-soal-modern-card mb-2">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge kompetensi-badge-nomor me-2">{{ $i+1 }}</span>
                                        <span class="fw-semibold" style="font-size:1.08rem;">{{ $soal->question }}</span>
                                    </div>

                                    {{-- tampilkan gambar jika ada --}}
                                    @if($soal->image)
                                        <div class="mb-3 text-center">
                                            <img src="{{ asset('storage/' . $soal->image) }}" 
                                                alt="Gambar Soal {{ $i+1 }}" 
                                                class="img-fluid rounded shadow-sm" 
                                                style="max-height: 250px; object-fit: contain;">
                                        </div>
                                    @endif


                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="kompetensi-radio-wrap w-100">
                                                <input class="kompetensi-radio" type="radio" name="answers[{{ $soal->id }}]" value="a" id="soal{{ $soal->id }}a" required>
                                                <span class="kompetensi-radio-label">A. {{ $soal->option_a }}</span>
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="kompetensi-radio-wrap w-100">
                                                <input class="kompetensi-radio" type="radio" name="answers[{{ $soal->id }}]" value="b" id="soal{{ $soal->id }}b">
                                                <span class="kompetensi-radio-label">B. {{ $soal->option_b }}</span>
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="kompetensi-radio-wrap w-100">
                                                <input class="kompetensi-radio" type="radio" name="answers[{{ $soal->id }}]" value="c" id="soal{{ $soal->id }}c">
                                                <span class="kompetensi-radio-label">C. {{ $soal->option_c }}</span>
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="kompetensi-radio-wrap w-100">
                                                <input class="kompetensi-radio" type="radio" name="answers[{{ $soal->id }}]" value="d" id="soal{{ $soal->id }}d">
                                                <span class="kompetensi-radio-label">D. {{ $soal->option_d }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="d-flex justify-content-end align-items-center mt-4">
                            <button type="submit" class="btn kompetensi-gradient-btn btn-lg rounded-pill px-4 fw-semibold" id="btn-submit-jawaban"><i class="fa fa-paper-plane me-1"></i> Kumpulkan Jawaban</button>
                        </div>
                    </form>
                    <!-- SweetAlert2 CDN -->
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            let timerDisplay = document.getElementById('timer');
                            let form = document.getElementById('exam-form');
                            const examDuration = {{ $kompetensi->duration }} * 60; // detik

                            // Set waktu mulai baru setiap load halaman
                            let startTimestamp = Date.now();

                            function getRemaining() {
                                const now = Date.now();
                                const elapsed = Math.floor((now - startTimestamp) / 1000);
                                return examDuration - elapsed;
                            }

                            function updateTimer() {
                                let remain = getRemaining();
                                if (remain <= 0) {
                                    timerDisplay.textContent = 'Waktu Habis';
                                    window.removeEventListener('beforeunload', beforeUnloadHandler);
                                    form.submit(); // Auto submit
                                    return;
                                }
                                let minutes = Math.floor(remain / 60);
                                let seconds = remain % 60;
                                timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                            }

                            updateTimer();
                            let interval = setInterval(updateTimer, 1000);

                            // SweetAlert konfirmasi submit manual
                            document.getElementById('btn-submit-jawaban').addEventListener('click', function(e) {
                                e.preventDefault();
                                Swal.fire({
                                    title: 'Kumpulkan Jawaban?',
                                    text: 'Pastikan semua jawaban sudah benar. Jawaban tidak bisa diubah setelah dikumpulkan!',
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonText: 'Ya, Kumpulkan!',
                                    cancelButtonText: 'Batal',
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.removeEventListener('beforeunload', beforeUnloadHandler);
                                        form.submit();
                                    }
                                });
                            });

                            // Cegah keluar dari halaman (kecuali submit)
                            function beforeUnloadHandler(e) {
                                e.preventDefault();
                                e.returnValue = '';
                            }
                            window.addEventListener('beforeunload', beforeUnloadHandler);

                            // Cegah klik kanan
                            document.addEventListener('contextmenu', function(e) {
                                e.preventDefault();
                            });

                            // Cegah shortcut devtools & view source
                            document.addEventListener('keydown', function(e) {
                                if (
                                    e.key === 'F12' ||
                                    (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
                                    (e.ctrlKey && e.key === 'U') ||
                                    (e.ctrlKey && e.key === 'S') ||
                                    (e.metaKey && e.key === 'S')
                                ) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                }
                            });

                            // Opsional: Minta fullscreen
                            if (document.documentElement.requestFullscreen) {
                                document.documentElement.requestFullscreen();
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
