@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4"
                     style="background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);">
                    <h4 class="mb-0">
                        <i class="fa fa-file-pdf me-2"></i> Sertifikat Kompetensi
                    </h4>
                    <span class="small">Lihat dan download sertifikat Anda</span>
                </div>
                <div class="card-body bg-light rounded-bottom-4 text-center">

                    @if(!empty($certificate->certificate_url))
                        {{-- Preview PDF menggunakan iframe --}}
                        <iframe src="{{ $certificate->certificate_url }}" 
                                style="width:100%; height:600px;" frameborder="0"></iframe>
                        
                        <div class="mt-3">
                            <a href="{{ $certificate->certificate_url }}" target="_blank" 
                               class="btn btn-success">
                                <i class="fa fa-download"></i> Download Sertifikat
                            </a>
                            <a href="{{ route('users.sertifikat.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Sertifikat belum tersedia untuk diunduh.
                        </div>
                        <a href="{{ route('users.sertifikat.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
