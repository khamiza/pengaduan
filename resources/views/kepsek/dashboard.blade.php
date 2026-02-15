@extends('layouts.kepsek')

@section('title', 'Dashboard')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Statistik Card -->
<div class="row">

    <!-- Total Aspirasi -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Aspirasi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalAspirasi }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menunggu -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Menunggu
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $menunggu }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Diproses -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Diproses
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $proses }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-sync fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Selesai -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Selesai
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $selesai }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Grafik Statistik Aspirasi -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Statistik Aspirasi</h6>
            </div>
            <div class="card-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Persentase Status Aspirasi</h6>
            </div>
            <div class="card-body">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statusChart').getContext('2d');
    const pieCtx = document.getElementById('pieChart').getContext('2d');

    // Bar Chart Gradien Soft Cerah
    const gradientMenunggu = ctx.createLinearGradient(0, 0, 0, 400);
    gradientMenunggu.addColorStop(0, '#fff5b1'); // soft cerah kuning
    gradientMenunggu.addColorStop(1, '#ffe89c');

    const gradientProses = ctx.createLinearGradient(0, 0, 0, 400);
    gradientProses.addColorStop(0, '#a8d4ff'); // soft cerah biru
    gradientProses.addColorStop(1, '#7ec3ff');

    const gradientSelesai = ctx.createLinearGradient(0, 0, 0, 400);
    gradientSelesai.addColorStop(0, '#a6f0b0'); // soft cerah hijau
    gradientSelesai.addColorStop(1, '#7fe28a');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Menunggu', 'Proses', 'Selesai'],
            datasets: [{
                label: 'Jumlah Aspirasi',
                data: [{{ $menunggu }}, {{ $proses }}, {{ $selesai }}],
                backgroundColor: [
                    gradientMenunggu,
                    gradientProses,
                    gradientSelesai
                ],
                borderRadius: 12,
                barThickness: 50,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1500, easing: 'easeOutBounce' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#2c3e50',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 6
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 14 } }, grid: { color: "#ecf0f1" } },
                x: { ticks: { font: { size: 14, weight: 'bold' } }, grid: { display: false } }
            }
        }
    });

    // Pie Chart Soft Cerah
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Menunggu', 'Proses', 'Selesai'],
            datasets: [{
                data: [{{ $menunggu }}, {{ $proses }}, {{ $selesai }}],
                backgroundColor: ['#fff5b1', '#a8d4ff', '#a6f0b0'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 14 } } },
                tooltip: {
                    backgroundColor: '#2c3e50',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 6
                }
            }
        }
    });
</script>

@endsection
