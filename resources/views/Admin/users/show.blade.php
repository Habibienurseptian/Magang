@extends('layouts.app')
@section('page_title', 'Detail User')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0 p-4">
                <h4 class="fw-bold mb-4">Detail User</h4>
                <table class="table table-borderless mb-0">
                    <tr>
                        <th style="width:160px;">NIK</th>
                        <td>{{ $user->nik }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ ucfirst($user->role) }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Buat</th>
                        <td>{{ $user->created_at->translatedFormat('d F Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td>{{ $user->updated_at->translatedFormat('d F Y, H:i') }}</td>
                    </tr>
                </table>
                <div class="mt-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary ms-2">Edit User</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
