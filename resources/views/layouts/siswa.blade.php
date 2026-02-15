<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title', 'Suara Sekolah')</title>

  <!-- Favicons -->
  <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Poppins&family=Raleway&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="index-page">

  <!-- ======= HEADER ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="/" class="logo d-flex align-items-center">
        <h1 class="sitename">Suara Sekolah</h1><span>.</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/" class="active">Home</a></li>
          <li><a href="#aspirasi">Aspirasi</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      @auth

<form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn-getstarted bg-danger border-0">
        Logout
    </button>
</form>

@else

<a class="btn-getstarted" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
    Login
</a>

@endauth

    </div>
  </header>
  <!-- END HEADER -->

  <main class="main">
    @yield('content')
  </main>
  
  <!-- MODAL LOGIN SEDERHANA DAN INFORMATIF -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-3 shadow">

        <form action="{{ route('login') }}" method="POST">
          @csrf

          <!-- HEADER -->
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">
              <i class="bi bi-box-arrow-in-right"></i> Login
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>

          <!-- BODY -->
          <div class="modal-body">

            {{-- error login --}}
            @if ($errors->any())
              <div class="alert alert-danger small">
                {{ $errors->first() }}
              </div>
            @endif

            <!-- Username -->
            <div class="mb-3">
              <label class="form-label">Username / NISN</label>
              <input type="text" name="username" class="form-control" placeholder="Masukkan username/NISN" required>
              <small class="text-muted d-block mt-1">
                Username bisa berupa NISN siswa, atau username admin / kepsek
              </small>
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

          </div>

          <!-- FOOTER -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
          </div>

        </form>

      </div>
    </div>
  </div>
  @if(session('error'))
  <script>
  document.addEventListener("DOMContentLoaded", function() {
      var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
      loginModal.show();
  });
  </script>
  @endif


  <!-- ======= FOOTER ======= -->
  <footer id="footer" class="footer light-background">
    <div class="container text-center mt-4">
      <p>© {{ date('Y') }} <strong>Suara Sekolah</strong>. All Rights Reserved</p>
      <div class="credits">
        Designed by BootstrapMade
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Vendor JS -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script>
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if(target){
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
  </script>

</body>
</html>
