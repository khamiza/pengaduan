@extends('admin.layouts.app')

@section('title', 'List Aspirasi')

@section('content')

<h1 class="h3 mb-4 text-gray-800">List Aspirasi Siswa</h1>

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Data Aspirasi Masuk
        </h6>
    </div>

  <div class="card-body">

        {{-- FORM SEARCH --}}
       {{-- FORM SEARCH --}}
<form method="GET" action="{{ route('admin.aspirasi') }}" class="mb-4">

    <div class="d-flex align-items-center gap-2">

        {{-- Input Search --}}
        <div style="width:300px;">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari nama, kategori, lokasi..."
                   value="{{ request('search') }}">
        </div>

        {{-- Tombol Cari --}}
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i> Cari
        </button>

        {{-- Tombol Reset --}}
        <a href="{{ route('admin.aspirasi') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-clockwise"></i> Reset
        </a>

    </div>

</form>


        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($aspirasi as $item)
                        <tr>
                            <td class="text-center">{{ $item->inputAspirasi->nisn ?? '-' }}</td>
                            <td>{{ $item->inputAspirasi->siswa->nama ?? '-' }}</td>
                            <td class="text-center">{{ $item->inputAspirasi->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $item->inputAspirasi->lokasi ?? '-' }}</td>
                            <td>{{ $item->inputAspirasi->keterangan ?? '-' }}</td>
                            <td class="text-center">{{ $item->tgl_aspirasi ?? '-' }}</td>
                            <td class="text-center">{{ ucfirst($item->status) }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#feedbackModal{{ $item->id }}">
                                    <i class="bi bi-chat-dots-fill"></i>
                                </button>
                            </td>
                        </tr>

                         


                        </tr>
                         <!-- MODAL FEEDBACK -->
<div class="modal fade"
     id="feedbackModal{{ $item->id }}"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form action="{{ route('admin.aspirasi.feedback', $item->id) }}"
                  method="POST">

                @csrf

                <!-- HEADER -->
                <div class="modal-header bg-success text-white">

                    <h5 class="modal-title">
                        <i class="bi bi-chat-dots-fill"></i>
                        Feedback Aspirasi
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- BODY -->
                <div class="modal-body">

                    <!-- DATA SISWA -->
                    <div class="card mb-3 border-primary">

                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-person-fill"></i>
                            Data Pengirim
                        </div>

                        <div class="card-body">

                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">NISN</div>
                                <div class="col-md-8">
                                    {{ $item->inputAspirasi->nisn ?? '-' }}
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Nama</div>
                                <div class="col-md-8">
                                    {{ $item->inputAspirasi->siswa->nama ?? '-' }}
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Kategori</div>
                                <div class="col-md-8">
                                    {{ $item->inputAspirasi->kategori->nama_kategori ?? '-' }}
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4 fw-bold">Lokasi</div>
                                <div class="col-md-8">
                                    {{ $item->inputAspirasi->lokasi ?? '-' }}
                                </div>
                            </div>

                        </div>

                    </div>


                    <!-- ISI ASPIRASI -->
                    <div class="card mb-3 border-warning">

                        <div class="card-header bg-warning text-dark">
                            <i class="bi bi-chat-left-text-fill"></i>
                            Isi Aspirasi
                        </div>

                        <div class="card-body">

                            <div class="mb-2">
                                <strong>Keterangan:</strong>
                            </div>

                            <div class="border rounded p-3 bg-light">
                                {{ $item->inputAspirasi->keterangan ?? '-' }}
                            </div>

                        </div>

                    </div>


                    <!-- STATUS -->
                    <div class="mb-3">

                        <label class="fw-bold mb-1">
                            <i class="bi bi-gear-fill"></i>
                            Ubah Status
                        </label>

                        <select name="status"
                                class="form-control"
                                required>

                            <option value="menunggu"
                                {{ $item->status == 'menunggu' ? 'selected' : '' }}>
                                Menunggu
                            </option>

                            <option value="proses"
                                {{ $item->status == 'proses' ? 'selected' : '' }}>
                                Proses
                            </option>

                            <option value="selesai"
                                {{ $item->status == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                        </select>

                    </div>


                    <!-- FEEDBACK -->
                    <div class="mb-3">

                        <label class="fw-bold mb-1">
                            <i class="bi bi-pencil-square"></i>
                            Isi Feedback Admin
                        </label>

                        <textarea name="isi_feedback"
                                  class="form-control"
                                  rows="4"
                                  required
                                  placeholder="Tuliskan feedback untuk siswa...">{{ $item->feedback }}</textarea>

                    </div>


                </div>


                <!-- FOOTER -->
                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        <i class="bi bi-x-circle"></i>
                        Batal

                    </button>

                    <button type="submit"
                            class="btn btn-success">

                        <i class="bi bi-save-fill"></i>
                        Simpan Feedback

                    </button>

                </div>


            </form>

        </div>

    </div>

</div>

                        <!-- MODAL DETAIL -->
                    <div class="modal fade"
                        id="detailModal{{ $item->id }}"
                        tabindex="-1">

                        <div class="modal-dialog modal-lg">

                            <div class="modal-content">

                                <div class="modal-header bg-primary text-white">

                                    <h5 class="modal-title">
                                        <i class="bi bi-eye-fill"></i>
                                        Detail Aspirasi
                                    </h5>

                                    <button type="button"
                                            class="btn-close"
                                            data-bs-dismiss="modal">
                                    </button>

                                </div>

                                <div class="modal-body">

                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">NISN</div>
                                        <div class="col-md-8">
                                            {{ $item->inputAspirasi->nisn ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Nama</div>
                                        <div class="col-md-8">
                                            {{ $item->inputAspirasi->siswa->nama ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Kategori</div>
                                        <div class="col-md-8">
                                            {{ $item->inputAspirasi->kategori->nama_kategori ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Lokasi</div>
                                        <div class="col-md-8">
                                            {{ $item->inputAspirasi->lokasi ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Keterangan</div>
                                        <div class="col-md-8">
                                            {{ $item->inputAspirasi->keterangan ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Tanggal</div>
                                        <div class="col-md-8">
                                            {{ $item->tgl_aspirasi ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Status</div>
                                        <div class="col-md-8">
                                            {{ ucfirst($item->status) }}
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-4 fw-bold">Feedback Admin</div>
                                        <div class="col-md-8">
                                            {{ $item->feedback ?? 'Belum ada feedback' }}
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal">
                                        Tutup
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Belum ada aspirasi
                            </td>
                        </tr>

                        
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


@endsection
