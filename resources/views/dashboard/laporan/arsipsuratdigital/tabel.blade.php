<style>
    .card-arsip {
        transition: .3s;
        cursor: pointer;
    }

    .card-arsip:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
    }

    .arsip-card {
        border-radius: 16px;
        transition: .3s;
        overflow: hidden;
    }

    .arsip-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, .15);
    }

    .arsip-header {
        color: #fff;
        padding: 12px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
    }

    .pdf-icon {
        font-size: 70px;
        color: #dc3545;
        transition: .3s;
    }

    .arsip-card:hover .pdf-icon {
        transform: scale(1.1);
    }

    .nomor-surat {
        font-weight: 700;
        text-align: center;
        margin-bottom: 12px;
        font-size: 15px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .perihal {
        text-align: center;
        min-height: 48px;
        line-height: 22px;
        font-size: 14px;
        font-weight: 500;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .info {
        font-size: 13px;
    }

    .info div {
        margin-bottom: 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-footer {
        border-top: 1px solid #eee;
        padding: 12px;
    }

    .card-footer .btn {
        border-radius: 10px;
    }

    .card-footer .btn:hover {
        background: #0d6efd;
        color: #fff;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {{-- button  --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <button type="button" id="btnMasuk" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-inbox me-2"></i>
                            Arsip Digital Surat Masuk
                        </button>
                    </div>

                    <div class="col-md-6">
                        <button type="button" id="btnKeluar" class="btn btn-outline-success btn-lg w-100">
                            <i class="fas fa-paper-plane me-2"></i>
                            Arsip Digital Surat Keluar
                        </button>
                    </div>
                </div>

                <input type="hidden" id="jenis_surat" value="masuk">

                {{-- form filter --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-search me-2"></i>
                            Pencarian Arsip
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Nomor Surat</label>
                                <input type="text" class="form-control" id="nomor_surat">
                            </div>

                            <div class="col-md-3">
                                <label>Tanggal Surat</label>
                                <input type="date" class="form-control" id="tanggal_surat">
                            </div>

                            <div class="col-md-3">
                                <label>Perihal</label>
                                <input type="text" class="form-control" id="perihal">
                            </div>

                            <div class="col-md-3">
                                <label>Instansi</label>
                                <select class="form-select" id="instansi_id">
                                    <option value="">-- Semua Instansi --</option>
                                    @foreach ($instansi as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama_instansi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="mt-3">
                            <button type="button" id="btnCari" class="btn btn-primary">
                                <i class="fa fa-search"></i> Cari
                            </button>

                            <button type="button" id="btnReset" class="btn btn-secondary">
                                Reset
                            </button>
                        </div>
                    </div>

                </div>

                {{-- rown menampilkan data surat --}}
                <div class="row" id="dataArsip">
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDetail" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-scrollable">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    <i class="fas fa-file-alt me-2"></i>
                    Detail Arsip Surat
                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                </button>

            </div>


            <div class="modal-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="30%">Nomor Surat</th>
                        <td id="d_no_surat">-</td>
                    </tr>

                    <tr>
                        <th>Jenis Surat</th>
                        <td id="d_jenis">-</td>
                    </tr>

                    <tr>
                        <th>Tanggal Surat</th>
                        <td id="d_tanggal">-</td>
                    </tr>

                    <tr>
                        <th>No Agenda</th>
                        <td id="d_agenda">-</td>
                    </tr>

                    <tr>
                        <th>Instansi</th>
                        <td id="d_instansi">-</td>
                    </tr>

                    <tr>
                        <th>Sifat Surat</th>
                        <td id="d_sifat">-</td>
                    </tr>

                    <tr>
                        <th>Perihal</th>
                        <td id="d_perihal">-</td>
                    </tr>

                    <tr>
                        <th>Lampiran</th>
                        <td id="d_lampiran">-</td>
                    </tr>

                    <tr>
                        <th>Keterangan</th>
                        <td id="d_keterangan">-</td>
                    </tr>

                </table>


                {{-- ================================================= --}}
                {{-- DATA KHUSUS SURAT KELUAR --}}
                {{-- ================================================= --}}

                <div id="detailSuratKeluar" class="mt-4" style="display:none;">

                    <div class="card border-success">

                        <div class="card-header bg-success text-white">

                            <strong>
                                <i class="fas fa-briefcase me-2"></i>
                                Data Surat Tugas
                            </strong>

                        </div>

                        <div class="card-body">


                            {{-- Pegawai --}}
                            <h6 class="fw-bold mb-3">
                                <i class="fas fa-users me-2"></i>
                                Pegawai Ditugaskan
                            </h6>

                            <div id="d_pegawai">
                                -
                            </div>


                            <hr>


                            {{-- Detail tugas --}}
                            <div class="row">

                                <div class="col-md-6 mb-2">

                                    <strong>
                                        Jumlah Hari
                                    </strong>

                                    <div id="d_jumlah_hari">
                                        -
                                    </div>

                                </div>


                                <div class="col-md-6 mb-2">

                                    <strong>
                                        Tujuan
                                    </strong>

                                    <div id="d_tujuan">
                                        -
                                    </div>

                                </div>


                                <div class="col-md-12 mb-2">

                                    <strong>
                                        Maksud/Tujuan
                                    </strong>

                                    <div id="d_maksud_tujuan">
                                        -
                                    </div>

                                </div>


                                <div class="col-md-6 mb-2">

                                    <strong>
                                        Mulai
                                    </strong>

                                    <div id="d_mulai">
                                        -
                                    </div>

                                </div>


                                <div class="col-md-6 mb-2">

                                    <strong>
                                        Selesai
                                    </strong>

                                    <div id="d_selesai">
                                        -
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- File --}}
                <div class="mt-3 text-end">

                    <a href="#" id="btnLihatPdf" target="_blank" class="btn btn-primary" style="display:none;">

                        <i class="fas fa-file-pdf me-1"></i>
                        Lihat Surat

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>


@push('myscript')
    <script>
        $(document).ready(function() {

            // =========================================================
            // DEFAULT
            // =========================================================

            aktifSuratMasuk();

            loadArsip();


            // =========================================================
            // SURAT MASUK
            // =========================================================

            $('#btnMasuk').click(function() {

                $('#jenis_surat').val('masuk');

                aktifSuratMasuk();

                loadArsip();

            });


            // =========================================================
            // SURAT KELUAR
            // =========================================================

            $('#btnKeluar').click(function() {

                $('#jenis_surat').val('keluar');

                aktifSuratKeluar();

                loadArsip();

            });


            // =========================================================
            // CARI
            // =========================================================

            $('#btnCari').click(function() {

                loadArsip();

            });


            // =========================================================
            // ENTER
            // =========================================================

            $('#nomor_surat, #tanggal_surat, #perihal').keypress(function(e) {

                if (e.which == 13) {

                    loadArsip();

                }

            });


            // =========================================================
            // INSTANSI
            // =========================================================

            $('#instansi_id').change(function() {

                loadArsip();

            });


            // =========================================================
            // RESET
            // =========================================================

            $('#btnReset').click(function() {

                $('#nomor_surat').val('');

                $('#tanggal_surat').val('');

                $('#perihal').val('');

                $('#instansi_id').val('');

                loadArsip();

            });

        });


        // =============================================================
        // LOAD ARSIP
        // =============================================================

        function loadArsip() {

            $('#dataArsip').html(`

        <div class="col-md-12">

            <div class="text-center py-5">

                <div class="spinner-border text-primary"></div>

                <br><br>

                Memuat data...

            </div>

        </div>

    `);


            $.ajax({

                url: "{{ route('get.ArsipDigital') }}",

                type: "GET",

                data: {

                    jenis_surat: $('#jenis_surat').val(),

                    nomor_surat: $('#nomor_surat').val(),

                    tgl_surat: $('#tanggal_surat').val(),

                    perihal: $('#perihal').val(),

                    instansi_id: $('#instansi_id').val()

                },


                success: function(response) {

                    let html = '';


                    // =================================================
                    // TIDAK ADA DATA
                    // =================================================

                    if (!response || response.length === 0) {

                        html = `

                    <div class="col-md-12">

                        <div class="alert alert-warning text-center">

                            <i class="fas fa-folder-open fa-3x mb-3"></i>

                            <br>

                            Data arsip tidak ditemukan.

                        </div>

                    </div>

                `;

                    }


                    // =================================================
                    // ADA DATA
                    // =================================================
                    else {

                        $.each(response, function(i, item) {


                            let jenisSurat =
                                item.jenis_surat == 'masuk' ?
                                'SURAT MASUK' :
                                'SURAT KELUAR';


                            let warnaHeader =
                                item.jenis_surat == 'masuk' ?
                                'bg-primary' :
                                'bg-success';


                            let iconJenis =
                                item.jenis_surat == 'masuk' ?
                                'fa-inbox' :
                                'fa-paper-plane';


                            let sifat =
                                item.sifat_surat ?
                                item.sifat_surat.nama_sifat :
                                '-';


                            let instansi =
                                item.instansi ?
                                item.instansi.nama_instansi :
                                '-';


                            let noSurat =
                                item.no_surat ?
                                item.no_surat :
                                '-';


                            let perihal =
                                item.perihal ?
                                item.perihal :
                                '-';


                            let tanggal =
                                item.tgl_surat ?
                                item.tgl_surat :
                                '-';


                            // =================================================
                            // FILE
                            // =================================================

                            let fileHtml = '';

                            let tombolLihat = '';

                            let tombolDownload = '';

                            let tombolPrint = '';


                            if (item.file_surat) {

                                fileHtml = `

                            <a
                                href="/storage/${item.file_surat}"
                                target="_blank">

                                <i class="fas fa-file-pdf pdf-icon"></i>

                            </a>

                        `;


                                tombolLihat = `

                            <a
                                href="/storage/${item.file_surat}"
                                target="_blank"
                                class="btn btn-primary btn-sm w-100"
                                title="Lihat PDF">

                                <i class="fas fa-eye"></i>

                            </a>

                        `;


                                tombolDownload = `

                            <a
                                href="/storage/${item.file_surat}"
                                download
                                class="btn btn-success btn-sm w-100"
                                title="Download">

                                <i class="fas fa-download"></i>

                            </a>

                        `;


                                tombolPrint = `

                            <button
                                type="button"
                                class="btn btn-danger btn-sm w-100 btn-print"
                                data-file="${item.file_surat}"
                                title="Cetak">

                                <i class="fas fa-print"></i>

                            </button>

                        `;

                            } else {

                                fileHtml = `

                            <i class="fas fa-file-pdf pdf-icon text-secondary"></i>

                            <div class="small text-muted mt-2">

                                File tidak tersedia

                            </div>

                        `;


                                tombolLihat = `

                            <button
                                type="button"
                                class="btn btn-secondary btn-sm w-100"
                                disabled>

                                <i class="fas fa-eye-slash"></i>

                            </button>

                        `;


                                tombolDownload = `

                            <button
                                type="button"
                                class="btn btn-secondary btn-sm w-100"
                                disabled>

                                <i class="fas fa-download"></i>

                            </button>

                        `;


                                tombolPrint = `

                            <button
                                type="button"
                                class="btn btn-secondary btn-sm w-100"
                                disabled>

                                <i class="fas fa-print"></i>

                            </button>

                        `;

                            }


                            // =================================================
                            // CARD
                            // =================================================

                            html += `

                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">

                        <div class="card arsip-card border-0 shadow-sm h-100">


                            <!-- HEADER -->

                            <div class="arsip-header ${warnaHeader}">

                                <span>

                                    <i class="fas ${iconJenis} me-1"></i>

                                    ${jenisSurat}

                                </span>


                                <span class="badge bg-warning text-dark">

                                    ${sifat}

                                </span>

                            </div>


                            <!-- BODY -->

                            <div class="card-body">


                                <div class="text-center mb-3">

                                    ${fileHtml}

                                </div>


                                <div class="nomor-surat">

                                    ${noSurat}

                                </div>


                                <div class="perihal">

                                    ${perihal}

                                </div>


                                <hr>


                                <div class="info">


                                    <div>

                                        <i class="fas fa-building text-primary"></i>

                                        ${instansi}

                                    </div>


                                    <div>

                                        <i class="fas fa-calendar-alt text-success"></i>

                                        ${tanggal}

                                    </div>


                                    ${
                                        item.jenis_surat == 'keluar'
                                        ?
                                        `

                                                                    <div>

                                                                        <i class="fas fa-users text-warning"></i>

                                                                        ${
                                                                            item.pegawai &&
                                                                            item.pegawai.length > 0
                                                                            ?
                                                                            item.pegawai.length +
                                                                            ' Pegawai Ditugaskan'
                                                                            :
                                                                            'Pegawai : -'
                                                                        }

                                                                    </div>

                                                                    `
                                        :
                                        ''
                                    }


                                </div>


                            </div>


                            <!-- FOOTER -->

                            <div class="card-footer bg-light">

                                <div class="row g-2">


                                    <!-- DETAIL -->

                                    <div class="col-3">

                                        <button
                                            type="button"
                                            class="btn btn-warning btn-sm w-100 btn-detail"
                                            data-id="${item.id}"
                                            data-jenis="${item.jenis_surat}"
                                            title="Detail Surat">

                                            <i class="fas fa-info-circle"></i>

                                        </button>

                                    </div>


                                    <!-- LIHAT -->

                                    <div class="col-3">

                                        ${tombolLihat}

                                    </div>


                                    <!-- DOWNLOAD -->

                                    <div class="col-3">

                                        ${tombolDownload}

                                    </div>


                                    <!-- CETAK -->

                                    <div class="col-3">

                                        ${tombolPrint}

                                    </div>


                                </div>

                            </div>


                        </div>

                    </div>

                    `;

                        });

                    }


                    $('#dataArsip').html(html);

                },


                error: function(xhr) {

                    console.log(xhr.responseText);

                    $('#dataArsip').html(`

                <div class="col-md-12">

                    <div class="alert alert-danger text-center">

                        <i class="fas fa-exclamation-triangle me-2"></i>

                        Terjadi kesalahan saat mengambil data.

                    </div>

                </div>

            `);

                }

            });

        }


        // =============================================================
        // BUTTON AKTIF SURAT MASUK
        // =============================================================

        function aktifSuratMasuk() {

            $('#btnMasuk')

                .removeClass('btn-outline-primary')

                .addClass('btn-primary');


            $('#btnKeluar')

                .removeClass('btn-success')

                .addClass('btn-outline-success');

        }


        // =============================================================
        // BUTTON AKTIF SURAT KELUAR
        // =============================================================

        function aktifSuratKeluar() {

            $('#btnKeluar')

                .removeClass('btn-outline-success')

                .addClass('btn-success');


            $('#btnMasuk')

                .removeClass('btn-primary')

                .addClass('btn-outline-primary');

        }
    </script>




    <script>
        $(document).on('click', '.btn-print', function() {
            let file = $(this).data('file');
            window.open('/storage/' + file, '_blank');
        });
    </script>

    <script>
        // =============================================================
        // DETAIL ARSIP SURAT
        // =============================================================

        $(document).on('click', '.btn-detail', function() {

            let id = $(this).data('id');
            let jenis = $(this).data('jenis');

            // =========================================================
            // RESET MODAL
            // =========================================================

            $('#d_no_surat').text('-');
            $('#d_jenis').text('-');
            $('#d_tanggal').text('-');
            $('#d_agenda').text('-');
            $('#d_instansi').text('-');
            $('#d_sifat').text('-');
            $('#d_perihal').text('-');
            $('#d_lampiran').text('-');
            $('#d_keterangan').text('-');

            $('#d_pegawai').html('-');
            $('#d_jumlah_hari').text('-');
            $('#d_tujuan').text('-');
            $('#d_maksud_tujuan').text('-');
            $('#d_mulai').text('-');
            $('#d_selesai').text('-');

            $('#detailSuratKeluar').hide();

            $('#btnLihatPdf')
                .hide()
                .attr('href', '#');


            // =========================================================
            // LOADING
            // =========================================================

            $('#d_no_surat').html(
                '<span class="text-muted">' +
                '<i class="fas fa-spinner fa-spin me-1"></i>' +
                'Memuat data...' +
                '</span>'
            );


            // =========================================================
            // TAMPILKAN MODAL
            // =========================================================

            $('#modalDetail').modal('show');


            // =========================================================
            // AJAX
            // =========================================================

            $.ajax({

                url: "{{ url('arsip-digital/detail') }}/" + id,

                type: "GET",

                data: {
                    jenis_surat: jenis
                },


                success: function(data) {

                    console.log('DETAIL SURAT:', data);


                    // =================================================
                    // DATA UMUM
                    // =================================================

                    $('#d_no_surat').text(
                        data.no_surat ?? '-'
                    );


                    $('#d_jenis').text(
                        data.jenis_surat === 'masuk' ?
                        'Surat Masuk' :
                        'Surat Keluar'
                    );


                    $('#d_tanggal').text(
                        data.tgl_surat ?? '-'
                    );


                    $('#d_agenda').text(
                        data.no_agenda ?? '-'
                    );


                    $('#d_perihal').text(
                        data.perihal ?? '-'
                    );


                    $('#d_lampiran').text(
                        data.lampiran ?? '-'
                    );


                    $('#d_keterangan').text(
                        data.keterangan ?? '-'
                    );


                    // =================================================
                    // SURAT MASUK
                    // =================================================

                    if (data.jenis_surat === 'masuk') {

                        // Instansi
                        if (data.instansi) {

                            $('#d_instansi').text(
                                data.instansi.nama_instansi ?? '-'
                            );

                        } else {

                            $('#d_instansi').text('-');

                        }


                        // Sifat Surat
                        if (data.sifat_surat) {

                            $('#d_sifat').text(
                                data.sifat_surat.nama_sifat ?? '-'
                            );

                        } else {

                            $('#d_sifat').text('-');

                        }


                        // Pastikan detail surat keluar disembunyikan
                        $('#detailSuratKeluar').hide();

                    }


                    // =================================================
                    // SURAT KELUAR
                    // =================================================
                    else if (data.jenis_surat === 'keluar') {

                        // ---------------------------------------------
                        // Instansi dan sifat surat tidak digunakan
                        // ---------------------------------------------

                        $('#d_instansi').text('-');

                        $('#d_sifat').text('-');


                        // ---------------------------------------------
                        // Tampilkan detail surat keluar
                        // ---------------------------------------------

                        $('#detailSuratKeluar').show();


                        // ---------------------------------------------
                        // Pegawai
                        // ---------------------------------------------

                        if (
                            data.pegawai &&
                            Array.isArray(data.pegawai) &&
                            data.pegawai.length > 0
                        ) {

                            let htmlPegawai = '';


                            $.each(data.pegawai, function(index, pegawai) {

                                let namaPegawai =
                                    pegawai.nama_pegawai ??
                                    pegawai.nama ??
                                    '-';


                                htmlPegawai += `

                                <div class="mb-2">

                                    <span class="badge bg-light text-dark border">

                                        <i class="fas fa-user me-1"></i>

                                        ${namaPegawai}

                                    </span>

                                </div>

                            `;

                            });


                            $('#d_pegawai').html(htmlPegawai);

                        } else {

                            $('#d_pegawai').html(
                                '<span class="text-muted">Tidak ada pegawai ditugaskan</span>'
                            );

                        }


                        // ---------------------------------------------
                        // Jumlah Hari
                        // ---------------------------------------------

                        $('#d_jumlah_hari').text(
                            data.jumlah_hari_tugas ?? '-'
                        );


                        // ---------------------------------------------
                        // Tujuan
                        // ---------------------------------------------

                        $('#d_tujuan').text(
                            data.tujuan_tugas ?? '-'
                        );


                        // ---------------------------------------------
                        // Maksud / Tujuan
                        // ---------------------------------------------

                        $('#d_maksud_tujuan').text(
                            data.maksud_tujuan_tugas ?? '-'
                        );


                        // ---------------------------------------------
                        // Mulai
                        // ---------------------------------------------

                        $('#d_mulai').text(
                            data.mulai_tugas ?? '-'
                        );


                        // ---------------------------------------------
                        // Selesai
                        // ---------------------------------------------

                        $('#d_selesai').text(
                            data.selesai_tugas ?? '-'
                        );

                    }


                    // =================================================
                    // FILE SURAT
                    // =================================================

                    if (data.file_surat) {

                        $('#btnLihatPdf')
                            .attr(
                                'href',
                                '/storage/' + data.file_surat
                            )
                            .show();

                    } else {

                        $('#btnLihatPdf')
                            .hide()
                            .attr('href', '#');
                    }
                },

                // =====================================================
                // ERROR
                // =====================================================

                error: function(xhr) {

                    console.log(
                        'ERROR DETAIL:',
                        xhr.responseText
                    );


                    $('#modalDetail').modal('hide');


                    alert(
                        'Data detail surat tidak dapat dimuat.'
                    );

                }

            });

        });
    </script>
@endpush
