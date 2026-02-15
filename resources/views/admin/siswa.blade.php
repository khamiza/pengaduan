@extends('admin.layouts.app')

@section('title', 'Data Siswa')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

    <h1 class="h3 mb-2 mb-md-0 text-gray-800">
        <i class="bi bi-people-fill me-2"></i> Data Siswa
    </h1>

    <div class="d-flex flex-wrap">

        <button class="btn btn-success btn-sm shadow-sm mr-2 mb-2"
                data-toggle="modal"
                data-target="#importExcelModal">
            <i class="bi bi-file-earmark-excel me-1"></i>
            Import Excel
        </button>

        <button class="btn btn-primary btn-sm shadow-sm mb-2"
                data-toggle="modal"
                data-target="#tambahSiswaModal">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Siswa
        </button>

    </div>

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

        <form method="GET" action="{{ route('siswa.dashboard') }}" class="mb-3">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                    <div class="input-group input-group-sm">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Cari siswa..."
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nisn }}</td>
                        <td class="text-left">{{ $item->nama }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>{{ $item->jurusan }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm mx-1"
                                    data-toggle="modal"
                                    data-target="#editSiswa{{ $item->id }}"
                                    title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <form action="{{ route('siswa.destroy', $item->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus siswa ini?')">
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
                        <td colspan="6">Data siswa belum ada</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- MODAL TAMBAH SISWA --}}
<div class="modal fade" id="tambahSiswaModal">
    <div class="modal-dialog">
        <form action="{{ route('siswa.store') }}" method="POST">
            @csrf
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus-fill"></i> Tambah Siswa
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>NISN</label>
                        <input type="text" name="nisn" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Kelas</label>
                        <select name="kelas" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option>X</option>
                            <option>XI</option>
                            <option>XII</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Jurusan</label>
                        <select name="jurusan" class="form-control" required>
                            <option>IPA</option>
                            <option>IPS</option>
                            <option>Bahasa</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
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

{{-- MODAL EDIT SISWA --}}
@foreach($siswa as $item)
<div class="modal fade" id="editSiswa{{ $item->id }}">
    <div class="modal-dialog">
        <form action="{{ route('siswa.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i> Edit Siswa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>NISN</label>
                        <input type="text" name="nisn" value="{{ $item->nisn }}" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label>Nama</label>
                        <input type="text" name="nama" value="{{ $item->nama }}" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label>Kelas</label>
                        <select name="kelas" class="form-control">
                            <option {{ $item->kelas=='X'?'selected':'' }}>X</option>
                            <option {{ $item->kelas=='XI'?'selected':'' }}>XI</option>
                            <option {{ $item->kelas=='XII'?'selected':'' }}>XII</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Jurusan</label>
                        <select name="jurusan" class="form-control">
                            <option {{ $item->jurusan=='IPA'?'selected':'' }}>IPA</option>
                            <option {{ $item->jurusan=='IPS'?'selected':'' }}>IPS</option>
                            <option {{ $item->jurusan=='Bahasa'?'selected':'' }}>Bahasa</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label>Password (kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" class="form-control">
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

{{-- MODAL IMPORT EXCEL --}}
<div class="modal fade" id="importExcelModal">
    <div class="modal-dialog">
        <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-file-earmark-excel"></i> Import Excel
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>Pilih File Excel</label>
                        <input type="file" name="file" class="form-control" required>
                        <small class="text-muted">
                            Format: nisn | nama | kelas | jurusan | password
                        </small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Batal
                    </button>
                    <button class="btn btn-success btn-sm">
                        Import
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection
