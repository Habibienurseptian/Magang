@extends('layouts.app')

@section('page_title', 'Kelola Sertifikat')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4" style="background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);">
                    <h4 class="mb-0"><i class="fa fa-certificate me-2"></i>Kelola Sertifikat User</h4>
                    <span class="small">Daftar user yang telah menyelesaikan uji kompetensi</span>
                </div>
                <div class="card-body bg-light rounded-bottom-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Nama User</th>
                                    <th>Email</th>
                                    <th>Kompetensi</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status Sertifikat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($completedUsers as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->kompetensi_name }}</td>
                                    <td>{{ $user->completed_at ? date('d M Y', strtotime($user->completed_at)) : '-' }}</td>
                                    <td>
                                        @if($user->certificate_url)
                                            <span class="badge bg-success">Sudah Terbit</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Belum Terbit</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->certificate_url)
                                            <a href="{{ $user->certificate_url }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i> Lihat</a>
                                            <a href="{{ route('instruktur.sertifikat.download', $user->id) }}" class="btn btn-sm btn-outline-success"><i class="fa fa-download"></i> Download</a>
                                        @else
                                            <a href="{{ route('instruktur.sertifikat.generate', $user->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Terbitkan</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada user yang menyelesaikan uji kompetensi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
