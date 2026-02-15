@extends('admin.layouts.app')

@section('title', 'Data Kategori')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="bi bi-tags-fill"></i> Data Kategori
    </h1>
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahKategoriModal">
        <i class="bi bi-plus-circle"></i> Tambah Kategori
    </button>
</div>

{{-- ALERT SUCCESS --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

{{-- ALERT ERROR --}}
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li><i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- TABLE --}}
<div class="card shadow mb-4">
    <div class="card-body">

        {{-- SEARCH --}}
        <div class="row mb-3">
            <div class="col-md-4 col-sm-12">
                <form method="GET" action="{{ route('kategori.dashboard') }}">
                    <div class="input-group input-group-sm">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Cari kategori..."
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('kategori.dashboard') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Kategori</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $item->nama_kategori }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm mx-1"
                                        data-toggle="modal"
                                        data-target="#editKategori{{ $item->id }}"
                                        title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form action="{{ route('kategori.destroy', $item->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm mx-1" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Data kategori belum ada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- MODAL TAMBAH KATEGORI --}}
<div class="modal fade" id="tambahKategoriModal">
    <div class="modal-dialog">
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-tag-fill"></i> Tambah Kategori
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button class="btn btn-primary btn-sm">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT KATEGORI --}}
@foreach($kategori as $item)
<div class="modal fade" id="editKategori{{ $item->id }}">
    <div class="modal-dialog">
        <form action="{{ route('kategori.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i> Edit Kategori
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text"
                               name="nama_kategori"
                               value="{{ $item->nama_kategori }}"
                               class="form-control"
                               required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <button class="btn btn-warning btn-sm">
                        <i class="bi bi-arrow-repeat"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
