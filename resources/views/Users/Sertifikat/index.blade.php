@extends('layouts.app')

@section('page_title', 'Sertifikat')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4"
                     style="background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);">
                    <h4 class="mb-0">
                        <i class="fa fa-certificate me-2"></i>Sertifikat Saya
                    </h4>
                    <span class="small">Daftar sertifikat yang sudah Anda dapatkan</span>
                </div>
                <div class="card-body bg-light rounded-bottom-4">

                    @forelse($certificates as $certificate)
                        <div class="card mb-3 shadow-sm border-0 rounded-3">
                            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                {{-- Judul kompetensi --}}
                                <div>
                                    <h5 class="mb-1">
                                        {{ optional($certificate->competency)->title ?? '-' }}
                                    </h5>
                                    {{-- Status --}}
                                    @if(!empty($certificate->certificate_url))
                                        <span class="badge bg-success">Sudah Terbit</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu Terbit</span>
                                    @endif
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="d-flex gap-2">
                                    @if(!empty($certificate->certificate_url))
                                        <a href="{{ $certificate->certificate_url }}" target="_blank"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-eye"></i> Lihat
                                        </a>
                                        <a href="{{ route('users.sertifikat.download', $certificate->id) }}"
                                           class="btn btn-sm btn-outline-success">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    @else
                                        <span class="text-muted">Belum tersedia</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            Belum ada sertifikat yang tersedia.
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
