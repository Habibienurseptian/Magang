@extends('layouts.app')

@section('page_title', 'Kelola Learning Path')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Kelola Learning Path</h2>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahLearning">
        Tambah Learning Path
    </button>

    <!-- Form Tambah -->
    <div class="modal fade" id="modalTambahLearning" tabindex="-1" aria-labelledby="modalTambahLearningLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLearningLabel">Tambah Learning Path</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('inspektur.learning.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Judul</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bidang</label>
                                <select name="skill_id" class="form-select" required>
                                    <option value="">-- Pilih Bidang --</option>
                                    @foreach($skills as $skill)
                                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tingkat Level</label>
                                <select name="level" class="form-select" required>
                                    <option value="">-- Pilih Level --</option>
                                    <option value="Pemula">Pemula</option>
                                    <option value="Menengah">Menengah</option>
                                    <option value="Ahli">Ahli</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">URL Gambar</label>
                                <input type="url" name="image" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Link Video YouTube</label>
                                <input type="url" name="youtube_url" class="form-control" placeholder="https://www.youtube.com/watch?v=xxxx">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="2" required></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Form Pencarian -->
    <form method="GET" action="" class="mb-3">
        <div class="row g-2 justify-content-end">
            <div class="col-md-6 col-12">
                <div class="d-flex flex-row flex-md-row gap-2 align-items-center learning-search-mobile">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul/kategori..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary d-flex align-items-center"><i class="fa fa-search me-1"></i> <span class="d-none d-md-inline">Cari</span></button>
                    @if(request('search'))
                        <a href="?" class="btn btn-secondary d-flex align-items-center"><i class="fa fa-times me-1"></i> <span class="d-none d-md-inline">Reset</span></a>
                    @endif
                </div>
            </div>
        </div>
    </form>

    <!-- List Data -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Judul</th>
                    <th>Bidang</th>
                    <th>Level</th>
                    <th class="d-none d-md-table-cell">Gambar</th>
                    <th class="d-none d-md-table-cell">Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($learnings as $learning)
                <tr>
                    <td>{{ $learning->title }}</td>
                    <td>{{ $learning->skill->name ?? '-' }}</td>
                    <td>
                        @php
                            $levelClass = 'learning-badge-level badge-sm';
                            if (strtolower($learning->level ?? '') == 'pemula') $levelClass .= ' learning-badge-level-pemula';
                            elseif (strtolower($learning->level ?? '') == 'menengah') $levelClass .= ' learning-badge-level-menengah';
                            elseif (strtolower($learning->level ?? '') == 'ahli') $levelClass .= ' learning-badge-level-ahli';
                        @endphp
                        <span class="badge px-2 py-1 {{ $levelClass }}" style="font-size:0.85rem;min-width:60px;">{{ $learning->level ?? '-' }}</span>
                    </td>
                    <td class="d-none d-md-table-cell">
                        <img src="{{ $learning->image }}" alt="" style="width:100px;max-width:100%">
                    </td>
                    <td class="desc-td d-none d-md-table-cell" style="max-width:220px;word-break:break-word;">
                        {!! \Illuminate\Support\Str::limit(nl2br(e($learning->description)), 60, '...') !!}
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <a href="{{ route('inspektur.learning.show', $learning->id) }}"
                            class="btn btn-success btn-sm btn-action"
                            title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('inspektur.learning.edit', $learning->id) }}"
                            class="btn btn-primary btn-sm btn-action"
                            title="Edit Learning Path">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('inspektur.learning.destroy', $learning->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin hapus?')"
                                style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-danger btn-sm btn-action"
                                        title="Hapus Learning Path">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center align-items-center p-3">
        {{ $learnings->appends(request()->except('page'))->onEachSide(1)->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection
