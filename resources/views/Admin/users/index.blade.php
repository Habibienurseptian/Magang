@extends('layouts.app')
@section('page_title', 'Manajemen Pengguna')
@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4">Manajemen Pengguna</h4>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Tambah User --}}
    <div class="card mb-4">
        <div class="card-header bg-white fw-bold">Tambah Akun User</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" required pattern="[0-9]{16}" inputmode="numeric" maxlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16)">
                        @error('nik')
                            <div class="invalid-feedback">
                                @php
                                    $msg = $message;
                                @endphp
                                @if(str_contains($msg, 'digits'))
                                    NIK harus terdiri dari 16 angka.
                                @elseif(str_contains($msg, 'unique'))
                                    NIK sudah terdaftar, gunakan NIK lain.
                                @else
                                    NIK sudah terdaftar
                                @endif
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-8 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Buat Akun</button>
                    </div>
                </div>
            </form>
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

{{-- Show/Hide Password --}}
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const pwd = document.getElementById('password');
        const icon = this.querySelector('i');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            pwd.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endsection
