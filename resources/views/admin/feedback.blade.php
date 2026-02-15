@extends('admin.layouts.app')

@section('title', 'List Feedback')

@section('content')

<h1 class="h3 mb-4 text-gray-800">List Feedback Aspirasi</h1>

<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Data feedback Masuk
        </h6>
    </div>

    <div class="card-body">

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
                        <th>Feedback</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($feedbacks as $item)
                        <tr>

                            {{-- NISN --}}
                            <td class="text-center">{{ $item->aspirasi->inputAspirasi->nisn ?? '-' }}</td>

                            {{-- Nama --}}
                            <td>{{ $item->aspirasi->inputAspirasi->siswa->nama ?? '-' }}</td>

                            {{-- Kategori --}}
                            <td class="text-center">
                                @php
                                    $kategori = $item->aspirasi->inputAspirasi->kategori->nama_kategori ?? '';
                                @endphp

                                @if($kategori == 'Kerusakan')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $kategori }}
                                    </span>
                                @elseif($kategori == 'Kebersihan')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-broom"></i> {{ $kategori }}
                                    </span>
                                @elseif($kategori == 'Keamanan')
                                    <span class="badge bg-primary">
                                        <i class="fas fa-shield-alt"></i> {{ $kategori }}
                                    </span>
                                @elseif($kategori == 'Saran')
                                    <span class="badge bg-success">
                                        <i class="fas fa-lightbulb"></i> {{ $kategori }}
                                    </span>
                                @else
                                    <span class="badge bg-info">
                                        <i class="fas fa-folder"></i> {{ $kategori ?: '-' }}
                                    </span>
                                @endif
                            </td>

                            {{-- Lokasi --}}
                            <td>{{ $item->aspirasi->inputAspirasi->lokasi ?? '-' }}</td>

                            {{-- Keterangan --}}
                            <td>{{ $item->aspirasi->inputAspirasi->keterangan ?? '-' }}</td>

                            {{-- Tanggal --}}
                            <td class="text-center">{{ $item->aspirasi->tgl_aspirasi ?? '-' }}</td>

                            {{-- Status --}}
                            <td class="text-center">
                                @php
                                    $aspStatus = $item->aspirasi->status ?? '-';
                                @endphp

                                @if ($aspStatus == 'menunggu')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-hourglass-split"></i> Menunggu
                                    </span>
                                @elseif ($aspStatus == 'proses')
                                    <span class="badge bg-primary">
                                        <i class="bi bi-gear"></i> Proses
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Selesai
                                    </span>
                                @endif
                            </td>

                            {{-- Feedback --}}
                            <td class="text-start">{{ $item->isi_feedback ?? '-' }}</td>

                            {{-- Aksi --}}
                            <td class="text-center">
                                <button class="btn btn-sm btn-info mb-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $item->id }}"
                                        title="Detail Aspirasi">
                                    <i class="bi bi-eye-fill"></i>
                                </button>

                                <button class="btn btn-sm btn-success mb-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#feedbackModal{{ $item->id }}"
                                        title="Edit Feedback">
                                    <i class="bi bi-chat-dots-fill"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- MODAL DETAIL -->
                        <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title"><i class="bi bi-eye-fill"></i> Detail Aspirasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-2">
                                            <div class="col-md-4 fw-bold">NISN</div>
                                            <div class="col-md-8">{{ $item->aspirasi->inputAspirasi->nisn ?? '-' }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 fw-bold">Nama</div>
                                            <div class="col-md-8">{{ $item->aspirasi->inputAspirasi->siswa->nama ?? '-' }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 fw-bold">Kategori</div>
                                            <div class="col-md-8">{{ $item->aspirasi->inputAspirasi->kategori->nama_kategori ?? '-' }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 fw-bold">Lokasi</div>
                                            <div class="col-md-8">{{ $item->aspirasi->inputAspirasi->lokasi ?? '-' }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 fw-bold">Keterangan</div>
                                            <div class="col-md-8">{{ $item->aspirasi->inputAspirasi->keterangan ?? '-' }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 fw-bold">Tanggal</div>
                                            <div class="col-md-8">{{ $item->aspirasi->tgl_aspirasi ?? '-' }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 fw-bold">Status</div>
                                            <div class="col-md-8">{{ ucfirst($item->aspirasi->status) }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4 fw-bold">Feedback Admin</div>
                                            <div class="col-md-8">{{ $item->isi_feedback ?? 'Belum ada feedback' }}</div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL FEEDBACK -->
<!-- MODAL FEEDBACK -->
<div class="modal fade"
    id="feedbackModal{{ $item->id }}"
    tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-scrollable">

        <div class="modal-content">

            <form action="{{ route('admin.aspirasi.feedback', $item->aspirasi->id) }}"
                method="POST">

                @csrf

                <!-- HEADER -->
                <div class="modal-header bg-success text-white">

                    <h5 class="modal-title">
                        <i class="bi bi-chat-dots-fill"></i>
                        Feedback Aspirasi
                    </h5>

                    <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- BODY -->
                <div class="modal-body">


                    <!-- ISI ASPIRASI -->
                    <div class="card mb-3 shadow-sm border-primary">

                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-chat-left-text-fill"></i>
                            Isi Aspirasi Siswa
                        </div>

                        <div class="card-body">

                            <div class="row mb-2">
                                <div class="col-md-3 fw-bold">Nama</div>
                                <div class="col-md-9">
                                    {{ $item->aspirasi->inputAspirasi->siswa->nama ?? '-' }}
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-3 fw-bold">Kategori</div>
                                <div class="col-md-9">
                                    {{ $item->aspirasi->inputAspirasi->kategori->nama_kategori ?? '-' }}
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-3 fw-bold">Lokasi</div>
                                <div class="col-md-9">
                                    {{ $item->aspirasi->inputAspirasi->lokasi ?? '-' }}
                                </div>
                            </div>

                            <div class="mt-3">

                                <div class="fw-bold mb-1">
                                    Keterangan Aspirasi:
                                </div>

                                <div class="border rounded p-3 bg-light">
                                    {{ $item->aspirasi->inputAspirasi->keterangan ?? '-' }}
                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- FEEDBACK PERTAMA ADMIN -->
                    <div class="card mb-3 shadow-sm border-success">

                        <div class="card-header bg-success text-white">
                            <i class="bi bi-person-check-fill"></i>
                            Feedback Admin
                        </div>

                        <div class="card-body">

                            @if($item->aspirasi->feedback->count() > 0)

                                @php
                                    $first = $item->aspirasi->feedback->first();
                                @endphp

                                <div class="border rounded p-3 bg-light">

                                    <div class="fw-bold text-success">
                                        {{ $first->user->name ?? 'Admin' }}
                                    </div>

                                    <div class="mt-2">
                                        {{ $first->isi_feedback }}
                                    </div>

                                    <div class="mt-2">
                                        <small class="text-muted">
                                            {{ $first->created_at->format('d M Y H:i') }}
                                        </small>
                                    </div>

                                </div>

                            @else

                                <div class="text-muted text-center">
                                    Belum ada feedback dari admin
                                </div>

                            @endif

                        </div>

                    </div>



                    <!-- STATUS -->
                    <div class="mb-3">

                        <label class="fw-bold mb-1">
                            Status Aspirasi
                        </label>

                        <select name="status"
                            class="form-control"
                            required>

                            <option value="menunggu"
                                {{ $item->aspirasi->status == 'menunggu' ? 'selected' : '' }}>
                                Menunggu
                            </option>

                            <option value="proses"
                                {{ $item->aspirasi->status == 'proses' ? 'selected' : '' }}>
                                Proses
                            </option>

                            <option value="selesai"
                                {{ $item->aspirasi->status == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                        </select>

                    </div>



                    <!-- TAMBAH FEEDBACK BARU -->
                    <div class="mb-3">

                        <label class="fw-bold mb-1">
                            Tambah Feedback Baru
                        </label>

                        <textarea name="isi_feedback"
                            class="form-control"
                            rows="4"
                            placeholder="Tulis feedback baru untuk siswa..."
                            required></textarea>

                    </div>


                </div>


                <!-- FOOTER -->
                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        <i class="bi bi-x-circle"></i>
                        Tutup

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

                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada feedback</td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
