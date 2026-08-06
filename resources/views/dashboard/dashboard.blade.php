@extends('layout.master')

@section('content')
    <style>
        .dashboard-card {
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
            transition: .3s;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
        }

        .dashboard-card .card-body {
            padding: 22px;
        }

        .dashboard-icon {
            width: 70px;
            height: 70px;
            min-width: 70px;
            border-radius: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 28px;
        }

        .dashboard-card h2 {
            color: #1e3a8a;
            font-weight: 700;
            margin: 4px 0;
        }

        .dashboard-card small {
            font-size: 13px;
        }

        .icon-box {
            width: 70px;
            height: 70px;
            margin: auto;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 30px;
        }

        .card-header {
            border-radius: 20px 20px 0 0;
        }

        .apexcharts-menu {
            border-radius: 12px !important;
        }

        .table th {

            font-size: 13px;

            color: #6b7280;

        }

        .table td {

            vertical-align: middle;

        }

        .badge {

            border-radius: 20px;

            padding: 8px 14px;

            font-weight: 500;

        }
    </style>


    <div class="container">
        <div class="page-inner">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Dashboard</h2>
                    <p class="text-muted mb-0">
                        Sistem Informasi Pencatatan Surat Masuk dan Surat Keluar
                    </p>
                </div>

                <div class="text-end">
                    <small class="text-muted">
                        {{ date('l, d F Y') }}
                    </small>
                    <br>
                    <span class="badge bg-primary">
                        Administrator
                    </span>
                </div>

            </div>
            <!-- Card -->

            <div class="row g-4">
                <!-- Surat Masuk -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card dashboard-card border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="dashboard-icon bg-primary">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <div class="text-muted small">
                                        Surat Masuk
                                    </div>
                                    <h2 class="mb-1 fw-bold">
                                        350
                                    </h2>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up me-1"></i>
                                        12% dari bulan lalu
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Surat Keluar -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card dashboard-card border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="dashboard-icon bg-success">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <div class="text-muted small">
                                        Surat Keluar
                                    </div>
                                    <h2 class="mb-1 fw-bold">
                                        285
                                    </h2>
                                    <small class="text-success">
                                        <i class="fas fa-arrow-up me-1"></i>
                                        8% dari bulan lalu
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hari Ini -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card dashboard-card border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="dashboard-icon bg-info">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <div class="text-muted small">
                                        Surat Masuk Hari Ini
                                    </div>
                                    <h2 class="mb-1 fw-bold">
                                        12
                                    </h2>
                                    <small class="text-primary">
                                        Lihat Detail
                                        <i class="fas fa-angle-right ms-1"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keluar Hari Ini -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card dashboard-card border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="dashboard-icon bg-warning">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <div class="text-muted small">
                                        Surat Keluar Hari Ini
                                    </div>
                                    <h2 class="mb-1 fw-bold">
                                        9
                                    </h2>
                                    <small class="text-primary">
                                        Lihat Detail
                                        <i class="fas fa-angle-right ms-1"></i>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Grafik Surat -->
                <div class="col-lg-4">
                    <div class="card dashboard-card border-0">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">
                                    Grafik Surat Masuk & Surat Keluar
                                </h5>
                                <span class="badge bg-primary">
                                    Tahun 2026
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chartSurat"></div>
                        </div>
                    </div>
                </div>

                <!-- Donut -->
                <div class="col-lg-3">
                    <div class="card dashboard-card border-0">
                        <div class="card-header bg-white border-0">
                            <h5 class="fw-bold">
                                Komposisi Surat
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="chartDonut"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card dashboard-card border-0">
                        <div class="card-header bg-white border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold mb-0" id="judulInstansi">
                                    Statistik Surat Masuk per Instansi
                                </h5>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary" id="btnMasuk">
                                        <i class="fas fa-download me-1"></i>
                                        Masuk
                                    </button>
                                    <button type="button" class="btn btn-outline-success" id="btnKeluar">
                                        <i class="fas fa-upload me-1"></i>
                                        Keluar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chartInstansi"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mt-4">
                <!-- Surat Masuk -->
                <div class="col-lg-6">

                    <div class="card dashboard-card border-0">

                        <div class="card-header bg-white">

                            <div class="d-flex justify-content-between">

                                <h5 class="fw-bold">
                                    Surat Masuk Terbaru
                                </h5>

                                <button class="btn btn-sm btn-primary">
                                    Lihat Semua
                                </button>

                            </div>

                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive">

                                <table class="table table-hover align-middle mb-0">

                                    <thead>

                                        <tr>

                                            <th>No Surat</th>
                                            <th>Instansi</th>
                                            <th>Tanggal</th>
                                            <th>Sifat</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <tr>

                                            <td>001/BKD/VII/2026</td>

                                            <td>BKPSDM</td>

                                            <td>30 Jul 2026</td>

                                            <td>

                                                <span class="badge bg-success">

                                                    Biasa

                                                </span>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>002/BKD/VII/2026</td>

                                            <td>Dinkes</td>

                                            <td>29 Jul 2026</td>

                                            <td>

                                                <span class="badge bg-warning text-dark">

                                                    Penting

                                                </span>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>003/BKD/VII/2026</td>

                                            <td>BPKAD</td>

                                            <td>29 Jul 2026</td>

                                            <td>

                                                <span class="badge bg-danger">

                                                    Rahasia

                                                </span>

                                            </td>

                                        </tr>

                                        <tr>

                                            <td>004/BKD/VII/2026</td>

                                            <td>Disdik</td>

                                            <td>28 Jul 2026</td>

                                            <td>

                                                <span class="badge bg-info">

                                                    Segera

                                                </span>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="card dashboard-card border-0">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between">
                                <h5 class="fw-bold">
                                    Surat Keluar Terbaru
                                </h5>
                                <button class="btn btn-sm btn-success">
                                    Lihat Semua
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>No Surat</th>
                                            <th>Tujuan</th>
                                            <th>Tanggal</th>
                                            <th>Sifat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>100/BKD/VII/2026</td>
                                            <td>BKN</td>
                                            <td>30 Jul 2026</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    Biasa
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>101/BKD/VII/2026</td>
                                            <td>Bupati OKI</td>
                                            <td>29 Jul 2026</td>
                                            <td>
                                                <span class="badge bg-warning text-dark">
                                                    Penting
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>102/BKD/VII/2026</td>
                                            <td>Inspektorat</td>
                                            <td>28 Jul 2026</td>
                                            <td>
                                                <span class="badge bg-danger">
                                                    Rahasia
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>103/BKD/VII/2026</td>
                                            <td>Disdukcapil</td>
                                            <td>27 Jul 2026</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    Segera
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // area chart
        var options = {
            series: [{
                    name: 'Surat Masuk',
                    data: [15, 22, 18, 35, 28, 42, 50, 45, 39, 48, 55, 60]
                },
                {
                    name: 'Surat Keluar',
                    data: [8, 14, 12, 18, 20, 28, 32, 30, 25, 35, 40, 44]
                }
            ],

            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },

                zoom: {
                    enabled: false
                }
            },

            colors: ['#2563eb', '#22c55e'],
            dataLabels: {
                enabled: false
            },

            stroke: {
                curve: 'smooth',
                width: 3
            },

            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05
                }
            },

            xaxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'Mei',
                    'Jun',
                    'Jul',
                    'Ags',
                    'Sep',
                    'Okt',
                    'Nov',
                    'Des'
                ]
            },

            legend: {
                position: 'top'
            }
        };

        new ApexCharts(
            document.querySelector("#chartSurat"),
            options
        ).render();
        // area chart

        //donut chart
        var donut = {
            series: [62, 38],
            chart: {
                type: 'donut',
                height: 320
            },

            labels: [
                'Surat Masuk',
                'Surat Keluar'
            ],

            colors: [
                '#2563eb',
                '#22c55e'
            ],

            legend: {
                position: 'bottom'
            },

            dataLabels: {
                enabled: true
            },

            plotOptions: {
                pie: {
                    donut: {
                        size: '70%'
                    }
                }
            }
        };

        new ApexCharts(
            document.querySelector("#chartDonut"),
            donut
        ).render();
        //donut chart

        //chart statistik unit kerja
        let dataMasuk = [320, 210, 185, 162, 145, 110];
        let dataKeluar = [250, 180, 160, 120, 105, 90];
        let kategori = [
            'BKPSDM Kab. OKI',
            'Dinas Kesehatan',
            'Dinas Pendidikan',
            'BAPPEDA',
            'BPKAD',
            'Inspektorat'
        ];

        var optionsInstansi = {
            series: [{
                name: 'Jumlah Surat',
                data: dataMasuk
            }],

            chart: {
                type: 'bar',
                height: 340,
                toolbar: {
                    show: false
                }
            },
            colors: ['#2563EB'],
            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 6,
                    barHeight: '45%'
                }
            },
            dataLabels: {
                enabled: true
            },

            xaxis: {
                categories: kategori
            },

            grid: {
                borderColor: '#f1f1f1'
            },

            legend: {
                show: false
            }

        };

        var chartInstansi = new ApexCharts(
            document.querySelector("#chartInstansi"),
            optionsInstansi
        );

        chartInstansi.render();

        //script tombol masuk
        $('#btnMasuk').click(function() {
            chartInstansi.updateSeries([{
                data: dataMasuk
            }]);

            chartInstansi.updateOptions({
                colors: ['#2563EB']
            });
            $('#judulInstansi').text('Statistik Surat Masuk per Instansi');
            $('#btnMasuk')
                .removeClass('btn-outline-primary')
                .addClass('btn-primary');
            $('#btnKeluar')
                .removeClass('btn-success')
                .addClass('btn-outline-success');
        });

        //tombol keluar
        $('#btnKeluar').click(function() {
            chartInstansi.updateSeries([{
                data: dataKeluar
            }]);
            chartInstansi.updateOptions({
                colors: ['#22C55E']
            });
            $('#judulInstansi').text('Statistik Surat Keluar per Instansi');
            $('#btnKeluar')
                .removeClass('btn-outline-success')
                .addClass('btn-success');
            $('#btnMasuk')
                .removeClass('btn-primary')
                .addClass('btn-outline-primary');
        });

        //chart statistik unit kerja
    </script>
@endpush
