@extends('admin.layouts.app')

@section('title', 'History Feedback')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    History Feedback Aspirasi
</h1>

<div class="card shadow mb-4">

    <!-- HEADER CARD -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Data History Feedback
        </h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <!-- HEADER TABLE (SAMA SEPERTI LIST ASPIRASI) -->
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse ($aspirasi as $item)

                <tr>

                    <!-- NISN -->
                    <td class="text-center">
                        {{ $item->inputAspirasi->nisn ?? '-' }}
                    </td>

                    <!-- Nama -->
                    <td>
                        {{ $item->inputAspirasi->siswa->nama ?? '-' }}
                    </td>

                    <!-- Kategori -->
                    <td class="text-center">

                        @php
                        $kategori = $item->inputAspirasi->kategori->nama_kategori ?? '';
                        @endphp

                        @if($kategori == 'Kerusakan')
                            <span class="badge bg-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $kategori }}
                            </span>

                        @elseif($kategori == 'Kebersihan')
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-broom"></i>
                                {{ $kategori }}
                            </span>

                        @elseif($kategori == 'Keamanan')
                            <span class="badge bg-primary">
                                <i class="fas fa-shield-alt"></i>
                                {{ $kategori }}
                            </span>

                        @elseif($kategori == 'Saran')
                            <span class="badge bg-success">
                                <i class="fas fa-lightbulb"></i>
                                {{ $kategori }}
                            </span>

                        @else
                            <span class="badge bg-info">
                                {{ $kategori ?: '-' }}
                            </span>
                        @endif

                    </td>

                    <!-- Lokasi -->
                    <td>
                        {{ $item->inputAspirasi->lokasi ?? '-' }}
                    </td>

                    <!-- Keterangan -->
                    <td>
                        {{ $item->inputAspirasi->keterangan ?? '-' }}
                    </td>

                    <!-- Tanggal -->
                    <td class="text-center">
                        {{ $item->tgl_aspirasi ?? '-' }}
                    </td>

                    <!-- Status -->
                    <td class="text-center">

                        @if ($item->status == 'menunggu')

                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-hourglass-split"></i>
                                Menunggu
                            </span>

                        @elseif ($item->status == 'proses')

                            <span class="badge bg-primary">
                                <i class="bi bi-gear"></i>
                                Proses
                            </span>

                        @else

                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i>
                                Selesai
                            </span>

                        @endif

                    </td>

                    <!-- AKSI (DETAIL SAJA) -->
                    <td class="text-center">

                        <button class="btn btn-sm btn-info"
                                data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $item->id }}"
                                title="Detail">

                            <i class="bi bi-eye-fill"></i>

                        </button>

                    </td>

                </tr>


                <!-- MODAL DETAIL HISTORY -->
                <div class="modal fade"
                     id="detailModal{{ $item->id }}"
                     tabindex="-1">

                    <div class="modal-dialog modal-lg">

                        <div class="modal-content">

                            <div class="modal-header bg-primary text-white">

                                <h5 class="modal-title">
                                    <i class="bi bi-eye-fill"></i>
                                    Detail History Aspirasi & Feedback
                                </h5>

                                <button type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                </button>

                            </div>

                            <div class="modal-body">


                                <!-- DATA SISWA -->
                                <div class="card mb-3 border-primary">

                                    <div class="card-header bg-primary text-white">
                                        Data Pengirim
                                    </div>

                                    <div class="card-body">

                                        <p>
                                            <strong>NISN :</strong>
                                            {{ $item->inputAspirasi->nisn ?? '-' }}
                                        </p>

                                        <p>
                                            <strong>Nama :</strong>
                                            {{ $item->inputAspirasi->siswa->nama ?? '-' }}
                                        </p>

                                        <p>
                                            <strong>Kategori :</strong>
                                            {{ $item->inputAspirasi->kategori->nama_kategori ?? '-' }}
                                        </p>

                                        <p>
                                            <strong>Lokasi :</strong>
                                            {{ $item->inputAspirasi->lokasi ?? '-' }}
                                        </p>

                                    </div>

                                </div>


                                <!-- ISI ASPIRASI -->
                                <div class="card mb-3 border-warning">

                                    <div class="card-header bg-warning text-dark">
                                        Isi Aspirasi
                                    </div>

                                    <div class="card-body bg-light">

                                        {{ $item->inputAspirasi->keterangan ?? '-' }}

                                    </div>

                                </div>


                                <!-- FEEDBACK ADMIN -->
                                <div class="card mb-3 border-success">

                                    <div class="card-header bg-success text-white">
                                        Feedback Admin
                                    </div>

                                    <div class="card-body">

                                        @if($item->feedback->count() > 0)

                                            @foreach($item->feedback as $fb)

                                                <div class="border rounded p-2 mb-2 bg-light">

                                                    <strong>
                                                        {{ $fb->user->name ?? 'Admin' }}
                                                    </strong>

                                                    <br>

                                                    {{ $fb->isi_feedback }}

                                                    <br>

                                                    <small class="text-muted">
                                                        {{ $fb->created_at }}
                                                    </small>

                                                </div>

                                            @endforeach

                                        @else

                                            <span class="text-muted">
                                                Belum ada feedback
                                            </span>

                                        @endif

                                    </div>

                                </div>


                                <!-- STATUS -->
                                <p>
                                    <strong>Status :</strong>

                                    @if ($item->status == 'menunggu')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif ($item->status == 'proses')
                                        <span class="badge bg-primary">Proses</span>
                                    @else
                                        <span class="badge bg-success">Selesai</span>
                                    @endif

                                </p>


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
                        Belum ada history feedback
                    </td>
                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
