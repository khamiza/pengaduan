@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')

<!-- HERO -->
<section id="hero" class="hero section">
  <div class="container" data-aos="fade-up">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <h1>Suara Sekolah</h1>
        <p class="hero-description mb-4">
          Media untuk siswa menyampaikan pendapat, aspirasi, ide, dan kritik membangun demi kemajuan sekolah. Suara sekolah mencerminkan partisipasi aktif warga dalam menciptakan lingkungan pendidikan yang demokratis dan terbuka.
        </p>
      </div>
      <div class="col-lg-6 text-center">
        <img src="{{ asset('assets/img/illustration/illustration-16.webp') }}" class="img-fluid" alt="Hero Image">
      </div>
    </div>
  </div>
</section>

<!-- ASPIRASI SECTION -->
<section id="aspirasi" class="section py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <!-- FORM ASPIRASI -->
        <div class="card shadow mb-4">
          <div class="card-body">
            <h5 class="text-center mb-4">Form Aspirasi Siswa</h5>

            @auth
              <form action="{{ route('aspirasi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                  <label class="form-label">NISN</label>
                  <input type="text" name="nisn" value="{{ Auth::user()->username }}" class="form-control" readonly>
                </div>

                <div class="mb-3">
                  <label class="form-label">Kategori</label>
                  <select name="kategori_id" class="form-select" required>
                    <option value="">Pilih kategori</option>
                    @foreach($kategori as $k)
                      <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Lokasi</label>
                  <input type="text" name="lokasi" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label class="form-label">Keterangan</label>
                  <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                </div>

                <button class="btn btn-primary w-100">Kirim Aspirasi</button>
              </form>
            @else
              <div class="alert alert-warning text-center mb-3">
                Silakan login terlebih dahulu untuk mengirim aspirasi
              </div>
              <form>
                <input class="form-control mb-3" placeholder="NISN" disabled>
                <select class="form-select mb-3" disabled>
                  <option>Pilih kategori</option>
                </select>
                <input class="form-control mb-3" placeholder="Lokasi" disabled>
                <textarea class="form-control mb-3" rows="3" disabled></textarea>
                <button class="btn btn-secondary w-100" disabled>Login untuk kirim aspirasi</button>
              </form>
            @endauth
          </div>
        </div>

        <!-- LIST ASPIRASI -->
        <div class="card shadow">
          <div class="card-body">
            <h5 class="text-center mb-4">
              @auth
                Aspirasi Saya
              @else
                Semua Aspirasi Siswa
              @endauth
            </h5>

            <div class="row">
              @forelse($aspirasi as $a)
                <div class="col-md-6">
                  <div class="card mb-3 shadow-sm">
                    <div class="card-body">

                      <h6 class="fw-bold">Kategori: {{ $a->inputAspirasi->kategori->nama_kategori }}</h6>
                      <p>{{ $a->inputAspirasi->keterangan }}</p>
                      <p class="mb-1"><strong>Lokasi:</strong> {{ $a->inputAspirasi->lokasi }}</p>

                      <!-- Status -->
                      <span class="badge 
                        @if($a->status == 'menunggu') bg-warning text-dark
                        @elseif($a->status == 'proses') bg-info
                        @elseif($a->status == 'selesai') bg-success
                        @endif">
                        {{ ucfirst($a->status) }}
                      </span>
                      <br>
                      <small class="text-muted">{{ $a->created_at->format('d-m-Y') }}</small>

                      <!-- Feedback collapsible -->
                      @auth
                        @if($a->inputAspirasi->nisn == Auth::user()->nisn)
                          <div class="mt-3">
                            <details>
                              <summary>Feedback Admin 
                                @if($a->feedback && $a->feedback->count() > 0)
                                  ({{ $a->feedback->count() }})
                                @endif
                              </summary>

                              @if($a->feedback && $a->feedback->count() > 0)
                                <ul class="list-group list-group-flush mt-2">
                                  @foreach($a->feedback as $f)
                                    <li class="list-group-item p-2">
                                      {{ $f->isi_feedback }}
                                      <br>
                                      <small class="text-muted">{{ \Carbon\Carbon::parse($f->created_at)->format('d-m-Y H:i') }}</small>
                                    </li>
                                  @endforeach
                                </ul>
                              @else
                                <p class="text-muted mt-2">Belum ada feedback</p>
                              @endif
                            </details>
                          </div>
                        @endif
                      @endauth

                    </div>
                  </div>
                </div>
              @empty
                <div class="col-12">
                  <div class="alert alert-secondary text-center">Belum ada aspirasi</div>
                </div>
              @endforelse
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>

@endsection
