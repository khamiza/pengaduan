@extends('admin.layouts.app')

@section('title', 'Data Pengguna')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="bi bi-people-fill"></i> Data Pengguna
    </h1>
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahPenggunaModal">
        <i class="bi bi-plus-circle"></i> Tambah Pengguna
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
                <form method="GET" action="{{ route('pengguna.dashboard') }}">
                    <div class="input-group input-group-sm">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Cari nama / username / nisn..."
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('pengguna.dashboard') }}" class="btn btn-secondary">
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
                        <th>No</th>
                        <th>NISN</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->role=='siswa' ? $item->nisn : '-' }}</td>
                            <td>{{ in_array($item->role, ['admin','kepsek']) ? $item->username : '-' }}</td>
                            <td class="text-left">{{ $item->nama }}</td>
                            <td>{{ ucfirst($item->role) }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm mx-1" data-toggle="modal" data-target="#editPengguna{{ $item->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('pengguna.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm mx-1">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL EDIT PENGGUNA --}}
                        <div class="modal fade" id="editPengguna{{ $item->id }}">
                            <div class="modal-dialog">
                                <form action="{{ route('pengguna.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title">
                                                <i class="bi bi-pencil-square"></i> Edit Pengguna
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group mb-2">
                                                <label>Role</label>
                                                <select name="role" class="form-control role-select"
                                                        data-target-nisn="#nisnField{{ $item->id }}"
                                                        data-target-username="#usernameField{{ $item->id }}"
                                                        required>
                                                    <option value="siswa" {{ $item->role=='siswa'?'selected':'' }}>Siswa</option>
                                                    <option value="admin" {{ $item->role=='admin'?'selected':'' }}>Admin</option>
                                                    <option value="kepsek" {{ $item->role=='kepsek'?'selected':'' }}>Kepsek</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-2" id="nisnField{{ $item->id }}">
                                                <label>NISN</label>
                                                <input type="text" name="nisn" class="form-control" value="{{ $item->nisn }}">
                                            </div>
                                            <div class="form-group mb-2" id="usernameField{{ $item->id }}">
                                                <label>Username</label>
                                                <input type="text" name="username" class="form-control" value="{{ $item->username }}">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label>Nama</label>
                                                <input type="text" name="nama" class="form-control" value="{{ $item->nama }}" required>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label>Password <small>(kosongkan jika tidak ingin diubah)</small></label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning btn-sm">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6">Data pengguna belum ada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- MODAL TAMBAH PENGGUNA --}}
<div class="modal fade" id="tambahPenggunaModal">
    <div class="modal-dialog">
        <form action="{{ route('pengguna.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2" id="nisnAdd">
                        <label>NISN</label>
                        <input type="text" name="nisn" class="form-control">
                    </div>
                    <div class="form-group mb-2" id="usernameAdd">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label>Role</label>
                        <select name="role" class="form-control role-select"
                                data-target-nisn="#nisnAdd"
                                data-target-username="#usernameAdd"
                                required>
                            <option value="siswa">Siswa</option>
                            <option value="admin">Admin</option>
                            <option value="kepsek">Kepsek</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- JS untuk toggle NISN / Username --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    function toggleFields(select) {
        const nisn = document.querySelector(select.dataset.targetNisn);
        const username = document.querySelector(select.dataset.targetUsername);
        if(select.value === 'siswa') {
            nisn.style.display = 'block';
            username.style.display = 'none';
        } else {
            nisn.style.display = 'none';
            username.style.display = 'block';
        }
    }

    document.querySelectorAll('.role-select').forEach(function(el) {
        toggleFields(el);
        el.addEventListener('change', function() {
            toggleFields(el);
        });
    });
});
</script>

@endsection
