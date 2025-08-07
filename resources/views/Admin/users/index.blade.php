@extends('layouts.app')
@section('page_title', 'Manajemen Pengguna')
@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Manajemen Pengguna</h4>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahAkun">
        Tambah Akun
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modalTambahAkun" tabindex="-1" aria-labelledby="modalTambahAkunLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAkunLabel">Form Tambah Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs mb-3" id="formTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="user-tab" data-bs-toggle="tab" data-bs-target="#user-form" type="button" role="tab" aria-controls="user-form" aria-selected="true">User</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin-form" type="button" role="tab" aria-controls="admin-form" aria-selected="false">Admin</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="inspektur-tab" data-bs-toggle="tab" data-bs-target="#inspektur-form" type="button" role="tab" aria-controls="inspektur-form" aria-selected="false">Inspektur</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="formTabContent">
                        @foreach (['user', 'admin', 'inspektur'] as $role)
                            <div class="tab-pane fade {{ $role === 'user' ? 'show active' : '' }}" id="{{ $role }}-form" role="tabpanel" aria-labelledby="{{ $role }}-tab">
                                <form method="POST" action="{{ route('admin.users.store') }}">
                                    @csrf
                                    <input type="hidden" name="role" value="{{ $role }}">
                                    <div class="row g-3">
                                        @if($role === 'user')
                                            <div class="col-md-6">
                                                <label for="nik_{{ $role }}" class="form-label">NIK</label>
                                                <input type="text" class="form-control" id="nik_{{ $role }}" name="nik" required pattern="[0-9]{16}" inputmode="numeric" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16)">
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            <label for="name_{{ $role }}" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="name_{{ $role }}" name="name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email_{{ $role }}" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email_{{ $role }}" name="email" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone_{{ $role }}" class="form-label">No. Telepon / WA</label>
                                            <input type="text" class="form-control" id="phone_{{ $role }}" name="phone" required pattern="[0-9]{10,15}" inputmode="numeric">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_{{ $role }}" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password_{{ $role }}" name="password" required>
                                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_{{ $role }}', this)">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 text-end">
                                        <button type="submit" class="btn btn-success">Buat Akun {{ ucfirst($role) }}</button>
                                    </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Form Filter Pencarian --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
        <div class="d-flex flex-row flex-nowrap align-items-center gap-2 filter-search-mobile">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary d-flex align-items-center justify-content-center px-3" style="min-width:42px;">
                <i class="fa fa-search"></i>
                <span class="d-none d-md-inline ms-1">Cari</span>
            </button>
        </div>
    </form>

    {{-- Daftar User --}}
    <div class="card">
        <div class="card-header bg-white fw-bold">Daftar User</div>
        <div class="card-body p-0">
            @if ($users->isEmpty())
                <div class="p-3">Belum ada user yang terdaftar.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped m-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $i => $user)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2 align-items-center aksi-btn-group">
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="aksi-btn aksi-btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="aksi-btn aksi-btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="aksi-btn aksi-btn-danger" title="Hapus" type="submit"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center align-items-center p-3 border-top" style="background: #f8f9fa;">
                        {{ $users->withQueryString()->onEachSide(1)->links('vendor.pagination.custom') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Show/Hide Password (multi form) --}}
<script>
    function togglePassword(inputId, btn) {
        const pwd = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            pwd.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
