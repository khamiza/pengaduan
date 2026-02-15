<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'Suara Sekolah')</title>

    <!-- Fonts -->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>

<body id="page-top">

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-school"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Suara Sekolah</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Data Master
        </div>

        <li class="nav-item">
            <a class="nav-link" href="/admin/siswa">
                <i class="fas fa-fw fa-users"></i>
                <span>Siswa</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/admin/kategori">
                <i class="fas fa-fw fa-list"></i>
                <span>Kategori</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/admin/pengguna">
                <i class="fas fa-fw fa-users"></i>
                <span>Pengguna</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Pengaduan
        </div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Aspirasi</span>
            </a>
            <div id="collapsePages" class="collapse">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="/admin/aspirasi">List Aspirasi</a>
                    <a class="collapse-item" href="/admin/feedback">Feedback</a>
                    <a class="collapse-item" href="/admin/history">History</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/admin/laporan">
                <i class="fas fa-fw fa-table"></i>
                <span>Laporan</span>
            </a>
        </li>

    </ul>
    <!-- End Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">

                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                           <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                {{ Auth::user()->nama }}
                            </span>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>

            </nav>
            <!-- End Topbar -->

            <!-- Main Content -->
            <div class="container-fluid">
                @yield('content')
            </div>

        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto text-center">
                <span>© Suara Sekolah 2026</span>
            </div>
        </footer>

    </div>
</div>

<!-- JS -->
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
