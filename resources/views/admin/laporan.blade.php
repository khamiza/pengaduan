@extends('admin.layouts.app')

@section('title', 'Laporan Aspirasi')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Laporan Data Aspirasi</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Laporan Aspirasi</h6>
    </div>

    <div class="card-body">
        <!-- FILTER -->
        <form method="GET" action="{{ url('/admin/laporan') }}" class="row mb-4">
            <div class="col-md-3">
                <label>Search</label>
                <input type="text" name="search" class="form-control" placeholder="Nama siswa / kategori / lokasi..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label>Dari Tanggal</label>
                <input type="date" name="dari" class="form-control" value="{{ request('dari') }}">
            </div>
            <div class="col-md-3">
                <label>Sampai Tanggal</label>
                <input type="date" name="sampai" class="form-control" value="{{ request('sampai') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Tampilkan</button>
                <a href="{{ url('/admin/laporan') }}" class="btn btn-secondary mr-2">Reset</a>
                <a href="{{ url('/admin/laporan/pdf') }}?search={{ request('search') }}&dari={{ request('dari') }}&sampai={{ request('sampai') }}" class="btn btn-danger" target="_blank">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
        </form>

        <!-- TABEL RINGKAS -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aspirasi as $key => $item)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="text-center">{{ $item->inputaspirasi->nisn ?? '-' }}</td>
                        <td>{{ $item->inputaspirasi->siswa->nama ?? '-' }}</td>
                        <td class="text-center">{{ $item->inputaspirasi->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $item->inputaspirasi->lokasi ?? '-' }}</td>
                        <td class="text-center">{{ $item->tgl_aspirasi }}</td>
                        <td class="text-center">
                            @if($item->status == 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($item->status == 'proses')
                                <span class="badge bg-primary">Proses</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{ $item->id }}">
                                <i class="bi bi-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- MODAL DETAIL -->
                    <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">Detail Aspirasi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>NISN:</strong> {{ $item->inputaspirasi->nisn ?? '-' }}</p>
                                    <p><strong>Nama:</strong> {{ $item->inputaspirasi->siswa->nama ?? '-' }}</p>
                                    <p><strong>Kategori:</strong> {{ $item->inputaspirasi->kategori->nama_kategori ?? '-' }}</p>
                                    <p><strong>Lokasi:</strong> {{ $item->inputaspirasi->lokasi ?? '-' }}</p>
                                    <p><strong>Tanggal:</strong> {{ $item->tgl_aspirasi }}</p>
                                    <hr>
                                    <p><strong>Aspirasi Lengkap:</strong></p>
                                    <p>{{ $item->inputaspirasi->keterangan ?? '-' }}</p>
                                    <hr>
                                    <p><strong>Feedback Lengkap:</strong></p>
                                    @forelse($item->feedback as $fb)
                                        <p><strong>{{ $fb->user->nama ?? '-' }}:</strong> {{ $fb->isi_feedback }}</p>
                                    @empty
                                        <p class="text-muted">Belum ada feedback</p>
                                    @endforelse
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Data tidak ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
