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
                                    <div class="text-muted small">Surat Masuk</div>
                                    <h2 class="mb-1 fw-bold">
                                        {{ number_format($totalSuratMasuk, 0, '.', ',') }}
                                    </h2>
                                    <small class="{{ $persentaseSuratMasuk >= 0 ? 'text-success' : 'text-danger' }}">
                                        <i
                                            class="fas {{ $persentaseSuratMasuk >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} me-1"></i>
                                        {{ number_format(abs($persentaseSuratMasuk), 1) }}%
                                        dari bulan lalu
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
                                    <div class="text-muted small">Surat Keluar</div>
                                    <h2 class="mb-1 fw-bold">
                                        {{ number_format($totalSuratKeluar, 0, '.', ',') }}
                                    </h2>
                                    <small class="{{ $persentaseSuratKeluar >= 0 ? 'text-success' : 'text-danger' }}">
                                        <i
                                            class="fas {{ $persentaseSuratKeluar >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} me-1"></i>
                                        {{ number_format(abs($persentaseSuratKeluar), 1) }}%
                                        dari bulan lalu
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hari Ini -->
                <!-- Surat Masuk Hari Ini -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card dashboard-card border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="dashboard-icon bg-info">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <div class="text-muted small">Surat Masuk Hari Ini</div>
                                    <h2 class="mb-1 fw-bold">
                                        {{ number_format($suratMasukHariIni, 0, ',', '.') }}
                                    </h2>
                                    <a href="{{ route('index.SuratMasuk') }}"
                                        class="text-primary text-decoration-none small">
                                        Lihat Detail
                                        <i class="fas fa-angle-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Surat Keluar Hari Ini -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card dashboard-card border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="dashboard-icon bg-warning">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <div class="text-muted small">Surat Keluar Hari Ini</div>
                                    <h2 class="mb-1 fw-bold">
                                        {{ number_format($suratKeluarHariIni, 0, ',', '.') }}
                                    </h2>
                                    <a href="{{ route('index.SuratKeluar') }}"
                                        class="text-primary text-decoration-none small">
                                        Lihat Detail
                                        <i class="fas fa-angle-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (in_array(auth()->user()->role_id, [1, 2]))
                <div class="row mt-4">
                    <!-- Grafik Surat -->
                    <div class="col-lg-4">
                        <div class="card dashboard-card border-0">
                            <div class="card-header bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 fw-bold">Grafik Surat Masuk & Surat Keluar</h5>
                                    <span class="badge bg-primary">Tahun 2026</span>
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
                                <h5 class="fw-bold">Komposisi Surat</h5>
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
                                    <h5 class="fw-bold mb-0" id="judulInstansi">Statistik Surat Masuk per Instansi</h5>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-primary" id="btnMasuk">
                                            <i class="fas fa-download me-1"></i>Masuk
                                        </button>
                                        <button type="button" class="btn btn-outline-success" id="btnKeluar">
                                            <i class="fas fa-upload me-1"></i>Keluar
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
                    <div class="col-lg-5">
                        <div class="card dashboard-card border-0">
                            <div class="card-header bg-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-0">Surat Masuk Terbaru</h5>
                                    <a href="{{ route('index.SuratMasuk') }}" class="btn btn-sm btn-primary">Lihat
                                        Semua</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>No. Agenda</th>
                                                <th>Instansi Pengirim</th>
                                                <th>No. & Tgl. Surat & Tgl. Diterima</th>
                                                <th>Sifat</th>
                                                <th>Perihal</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse ($suratMasukTerbaru as $surat)
                                                <tr>
                                                    <td>
                                                        {{ $surat->no_agenda ?? '-' }}
                                                    </td>
                                                    <td>
                                                        {{ $surat->instansi->nama_instansi ?? '-' }}
                                                    </td>

                                                    <td>
                                                        <div>
                                                            <small class="text-muted">No. Surat:</small>
                                                            {{ $surat->no_surat }}
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">Tgl. Surat:</small>
                                                            {{ \Carbon\Carbon::parse($surat->tgl_surat)->translatedFormat('d M Y') }}
                                                        </div>

                                                        <div>
                                                            <small class="text-muted">Tgl. Diterima:</small>
                                                            {{ \Carbon\Carbon::parse($surat->tgl_diterima)->translatedFormat('d M Y') }}
                                                        </div>
                                                    </td>

                                                    <td>

                                                        @php
                                                            $warnaSifat = [
                                                                'Biasa' => 'success',
                                                                'Penting' => 'warning',
                                                                'Rahasia' => 'danger',
                                                                'Segera' => 'info',
                                                            ];

                                                            $namaSifat = $surat->sifatSurat->nama_sifat ?? '-';

                                                            $warna = $warnaSifat[$namaSifat] ?? 'secondary';
                                                        @endphp

                                                        <span
                                                            class="badge bg-{{ $warna }}
                    {{ $warna == 'warning' ? 'text-dark' : '' }}">

                                                            {{ $namaSifat }}

                                                        </span>

                                                    </td>
                                                    <td>
                                                        {{ $surat->perihal }}
                                                    </td>

                                                </tr>

                                            @empty

                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">
                                                        Belum ada surat masuk.
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="card dashboard-card border-0">
                            <div class="card-header bg-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-0">Surat Keluar Terbaru</h5>
                                    <a href="{{ route('index.SuratKeluar') }}" class="btn btn-sm btn-success">Lihat
                                        Semua</a>

                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th>No. Agenda</th>
                                                <th>No. & Tgl. Surat & Sifat</th>
                                                <th>Jenis Surat Keluar</th>
                                                <th>Detail ST & SPT</th>
                                                <th>Tujuan</th>
                                                <th>Perihal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($suratKeluarTerbaru as $surat)
                                                <tr>
                                                    <td>
                                                        {{ $surat->no_agenda }}
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <small class="text-muted">No. Surat:</small>
                                                            {{ $surat->no_surat }}
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">Tgl. Surat:</small>
                                                            {{ \Carbon\Carbon::parse($surat->tgl_surat)->translatedFormat('d M Y') }}
                                                        </div>
                                                        @php
                                                            $warnaSifat = [
                                                                'Biasa' => 'success',
                                                                'Penting' => 'warning',
                                                                'Rahasia' => 'danger',
                                                                'Segera' => 'info',
                                                            ];
                                                            $namaSifat = $surat->sifatSurat->nama_sifat ?? '-';
                                                            $warna = $warnaSifat[$namaSifat] ?? 'secondary';
                                                        @endphp

                                                        <span
                                                            class="badge bg-{{ $warna }}
                                                     {{ $warna == 'warning' ? 'text-dark' : '' }}">
                                                            {{ $namaSifat }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        @php
                                                            $warnaJenis = [
                                                                'Surat Biasa' => 'success',
                                                                'Surat Tugas' => 'primary',
                                                                'Surat Perintah Tugas' => 'warning',
                                                                'Nota Dinas' => 'info',
                                                            ];
                                                            $namaJenis =
                                                                $surat->jenisSuratKeluar->jenis_suratkeluar ?? '-';
                                                            $warna = $warnaJenis[$namaJenis] ?? 'secondary';
                                                        @endphp

                                                        <span
                                                            class="badge bg-{{ $warna }}
                                                         {{ $warna == 'warning' ? 'text-dark' : '' }}">
                                                            {{ $namaJenis }}
                                                        </span>
                                                    </td>

                                                    <td style="min-width: 250px; line-height: 1.5;">
                                                        @php
                                                            $adaPegawai = $surat->pegawai->count() > 0;
                                                            $adaDetailTugas =
                                                                !empty($surat->jumlah_hari_tugas) ||
                                                                !empty($surat->tujuan_tugas) ||
                                                                !empty($surat->maksud_tujuan_tugas) ||
                                                                !empty($surat->mulai_tugas) ||
                                                                !empty($surat->selesai_tugas);
                                                        @endphp

                                                        {{-- JIKA SEMUA DATA KOSONG --}}
                                                        @if (!$adaPegawai && !$adaDetailTugas)
                                                            <div class="text-center">-</div>
                                                        @else
                                                            {{-- PEGAWAI --}}
                                                            @if ($adaPegawai)
                                                                <div class="fw-bold mb-2">
                                                                    Pegawai Ditugaskan
                                                                </div>

                                                                @foreach ($surat->pegawai as $index => $pegawai)
                                                                    <div class="mb-2">
                                                                        <div class="fw-bold">
                                                                            {{ $index + 1 }}.
                                                                            {{ $pegawai->nama ?: '-' }}
                                                                        </div>
                                                                        <div>
                                                                            NIP : {{ $pegawai->nip ?: '-' }}
                                                                        </div>
                                                                        <div>
                                                                            Jabatan : {{ $pegawai->jabatan ?: '-' }}
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif

                                                            {{-- GARIS PEMISAH --}}
                                                            @if ($adaPegawai && $adaDetailTugas)
                                                                <hr class="my-2">
                                                            @endif

                                                            {{-- DETAIL SURAT TUGAS --}}
                                                            @if ($adaDetailTugas)
                                                                <div>
                                                                    <strong>Jumlah Hari :</strong>
                                                                    {{ $surat->jumlah_hari_tugas ? $surat->jumlah_hari_tugas . ' Hari' : '-' }}
                                                                </div>
                                                                <div>
                                                                    <strong>Tujuan :</strong>
                                                                    {{ $surat->tujuan_tugas ?: '-' }}
                                                                </div>
                                                                <div>
                                                                    <strong>Maksud/Tujuan :</strong>
                                                                    {{ $surat->maksud_tujuan_tugas ?: '-' }}
                                                                </div>
                                                                <div>
                                                                    <strong>Mulai :</strong>
                                                                    {{ $surat->mulai_tugas ? \Carbon\Carbon::parse($surat->mulai_tugas)->translatedFormat('d M Y') : '-' }}
                                                                </div>
                                                                <div>
                                                                    <strong>Selesai :</strong>
                                                                    {{ $surat->selesai_tugas ? \Carbon\Carbon::parse($surat->selesai_tugas)->translatedFormat('d M Y') : '-' }}
                                                                </div>
                                                            @endif
                                                        @endif

                                                    </td>

                                                    <td>
                                                        {{ $surat->instansi->nama_instansi ?? '-' }}
                                                    </td>

                                                    <td>
                                                        {{ $surat->perihal }}
                                                    </td>
                                                </tr>
                                            @empty

                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">
                                                        Belum ada surat keluar.
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // area chart
        // =========================================================
        // GRAFIK SURAT MASUK & SURAT KELUAR
        // =========================================================

        var options = {

            series: [

                {
                    name: 'Surat Masuk',
                    data: @json($grafikSuratMasuk)
                },

                {
                    name: 'Surat Keluar',
                    data: @json($grafikSuratKeluar)
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


            colors: [
                '#2563eb',
                '#22c55e'
            ],


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


            yaxis: {

                min: 0,

                forceNiceScale: true,

                labels: {

                    formatter: function(value) {

                        return Math.round(value);

                    }

                }

            },


            tooltip: {

                y: {

                    formatter: function(value) {

                        return value + ' surat';

                    }

                }

            },


            legend: {

                position: 'top'

            }

        };


        // =========================================================
        // RENDER CHART
        // =========================================================

        new ApexCharts(

            document.querySelector("#chartSurat"),

            options

        ).render();
        // area chart

        //donut chart
        var donut = {

            series: [
                {{ $totalSuratMasuk }},
                {{ $totalSuratKeluar }}
            ],

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
                enabled: true,

                formatter: function(value) {
                    return value.toFixed(1) + '%';
                }
            },

            plotOptions: {

                pie: {

                    donut: {

                        size: '70%',

                        labels: {

                            show: true,

                            total: {

                                show: true,

                                label: 'Total Surat',

                                formatter: function(w) {

                                    return w.globals.seriesTotals
                                        .reduce((a, b) => a + b, 0);

                                }

                            }

                        }

                    }

                }

            },

            tooltip: {

                y: {

                    formatter: function(value) {

                        return value.toLocaleString('id-ID') + ' surat';

                    }

                }

            }

        };


        // =========================================================
        // RENDER DONUT
        // =========================================================

        new ApexCharts(
            document.querySelector("#chartDonut"),
            donut
        ).render();
        //donut chart

        //chart statistik unit kerja
        // =========================================================
        // DATA STATISTIK INSTANSI DARI DATABASE
        // =========================================================

        let dataMasuk = @json($suratMasukPerInstansi->pluck('total')->map(fn($total) => (int) $total));

        let kategoriMasuk = @json(
            $suratMasukPerInstansi->map(function ($item) {
                return $item->instansi->nama_instansi ?? 'Tidak diketahui';
            }));


        let dataKeluar = @json($suratKeluarPerInstansi->pluck('total')->map(fn($total) => (int) $total));

        let kategoriKeluar = @json(
            $suratKeluarPerInstansi->map(function ($item) {
                return $item->instansi->nama_instansi ?? 'Tidak diketahui';
            }));


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
                categories: kategoriMasuk
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
                name: 'Surat Masuk',
                data: dataMasuk
            }]);

            chartInstansi.updateOptions({
                colors: ['#2563EB'],
                xaxis: {
                    categories: kategoriMasuk
                }
            });

            $('#judulInstansi')
                .text('Statistik Surat Masuk per Instansi');

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
                name: 'Surat Keluar',
                data: dataKeluar
            }]);

            chartInstansi.updateOptions({
                colors: ['#22C55E'],
                xaxis: {
                    categories: kategoriKeluar
                }
            });

            $('#judulInstansi')
                .text('Statistik Surat Keluar per Instansi');

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
