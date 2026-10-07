<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form id="formFilterAgenda">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold">
                                <i class="fa fa-filter text-primary me-2"></i>
                                Filter Laporan
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3 align-items-end">
                                <!-- Tanggal Awal -->
                                <div class="col-xl-2 col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Awal</label>
                                    <input type="date" name="tgl_awal" id="tgl_awal" class="form-control">
                                </div>
                                <!-- Tanggal Akhir -->
                                <div class="col-xl-2 col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Akhir</label>
                                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control">
                                </div>
                                <!-- Tanggal Surat -->
                                <div class="col-xl-2 col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Surat</label>
                                    <input type="date" name="tgl_surat" id="tgl_surat" class="form-control">
                                </div>

                                <div class="col-xl-2 col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">
                                        Jenis Surat Keluar
                                    </label>

                                    <select name="jenis_suratkeluar_id" id="jenis_suratkeluar_id" class="form-select">

                                        <option value="">
                                            Semua Jenis Surat
                                        </option>

                                        @foreach ($jenisSuratKeluar as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->jenis_suratkeluar }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <!-- Sifat Surat -->
                                <div class="col-xl-2 col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Sifat Surat</label>
                                    <select name="sifat_surat" id="sifat_surat" class="form-select">
                                        <option value="">Semua Sifat Surat</option>
                                        @foreach ($sifatSurat as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama_sifat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- instansi -->
                                <div class="col-xl-4 col-lg-6 col-md-6">
                                    <label class="form-label fw-semibold">Instansi</label>
                                    <select name="instansi_id" id="instansi_id" class="form-select">
                                        <option value="">Semua Instansi</option>

                                        @foreach ($instansiview as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama_instansi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Tombol -->
                                <div class="col-xl-3 col-lg-6 col-md-6">
                                    <div class="d-grid gap-2 d-md-flex">
                                        <button type="button" id="btnFilter" class="btn btn-primary" title="Lihat">
                                            <i class="fa fa-search me-1"></i>
                                        </button>

                                        <button type="button" id="btnDownload" class="btn btn-success"
                                            title="Download">

                                            <i class="fa fa-download me-1"></i>

                                        </button>

                                        <button type="button" id="btnReset" class="btn btn-secondary" title="Reset">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>

                <div class="alert alert-light border mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Periode</strong><br>
                            <span id="periode">-</span>
                        </div>

                        <div class="col-md-3">
                            <strong>Sifat Surat</strong><br>
                            <span id="info_sifat">Semua</span>
                        </div>

                        <div class="col-md-3">
                            <strong>Instansi</strong><br>
                            <span id="info_instansi">Semua</span>
                        </div>

                        <div class="col-md-2 text-end">
                            <strong>Jumlah Surat</strong><br>
                            <span class="badge bg-primary fs-6" id="jumlah_surat">
                                0 Surat
                            </span>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <div class="col-md-3">
                        <strong>Jenis Surat</strong><br>
                        <span id="info_jenis">Semua</span>
                    </div>
                    <table id="ekspedisisuratkeluar"
                        class="table table-bordered table-striped table-hover table-sm w-100">
                        <thead class="table-primary text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">No. Agenda</th>
                                <th width="12%">Jenis Surat Keluar</th>
                                <th width="18%">Detail Surat Tugas dan Surat Perintah Tugas</th>
                                <th width="18%">No. & Tgl. Surat Keluar</th>
                                <th width="18%">Sifat Surat</th>
                                <th width="18%">Lampiran</th>
                                <th width="20%">Tujuan</th>
                                <th>Perihal</th>
                                <th width="8%" class="text-center">File</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@push('myscript')
    {{-- =====================================================
         DATATABLES EKSPEDISI SURAT KELUAR
    ====================================================== --}}
    <script>
        $(document).ready(function() {

            let table = $('#ekspedisisuratkeluar').DataTable({

                processing: true,
                serverSide: true,
                searching: false,
                responsive: true,
                autoWidth: false,

                // =====================================================
                // AJAX
                // =====================================================

                ajax: {
                    url: "{{ route('get.EkspedisiSuratKeluar') }}",

                    data: function(d) {

                        d.tgl_awal =
                            $('#tgl_awal').val();

                        d.tgl_akhir =
                            $('#tgl_akhir').val();

                        d.tgl_surat =
                            $('#tgl_surat').val();

                        d.jenis_suratkeluar_id =
                            $('#jenis_suratkeluar_id').val();

                        d.sifat_surat =
                            $('#sifat_surat').val();

                        d.instansi_id =
                            $('#instansi_id').val();
                    }
                },

                // =====================================================
                // COLUMNS
                // =====================================================

                columns: [

                    // NO
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },

                    // NO AGENDA
                    {
                        data: 'no_agenda',
                        name: 'no_agenda'
                    },

                    // JENIS SURAT KELUAR
                    {
                        data: 'jenis_suratkeluar',
                        name: 'jenis_suratkeluar'
                    },

                    // DETAIL SURAT TUGAS
                    {
                        data: 'detail_tugas',
                        name: 'detail_tugas',
                        orderable: false,
                        searchable: false
                    },

                    // NO SURAT + TANGGAL
                    {
                        data: 'no_surat',
                        name: 'no_surat'
                    },

                    // SIFAT SURAT
                    {
                        data: 'sifat_surat',
                        name: 'sifat_surat'
                    },

                    // LAMPIRAN
                    {
                        data: 'lampiran',
                        name: 'lampiran'
                    },

                    // TUJUAN / INSTANSI
                    {
                        data: 'instansi',
                        name: 'instansi'
                    },

                    // PERIHAL
                    {
                        data: 'perihal',
                        name: 'perihal'
                    },

                    // FILE
                    {
                        data: 'lihatsurat',
                        name: 'lihatsurat',
                        orderable: false,
                        searchable: false
                    }

                ], // <-- INI PENTING, ADA KOMA SEBELUM language

                // =====================================================
                // LANGUAGE DATATABLES
                // =====================================================

                language: {

                    processing: "Memuat data...",

                    emptyTable: "Belum ada data",

                    zeroRecords: "Data tidak ditemukan",

                    search: "Cari:",

                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }

                }

            });


            // =====================================================
            // BUTTON FILTER
            // =====================================================

            $('#btnFilter').click(function() {

                table.ajax.reload();

                updateInformasi();

            });


            // =====================================================
            // BUTTON RESET
            // =====================================================

            $('#btnReset').click(function() {

                $('#formFilterAgenda')[0].reset();

                table.ajax.reload();

                $('#periode').html('-');

                $('#info_jenis').html('Semua');

                $('#info_sifat').html('Semua');

                $('#info_instansi').html('Semua');

                $('#jumlah_surat').html('0 Surat');

            });


            // =====================================================
            // UPDATE INFORMASI FILTER
            // =====================================================

            function updateInformasi() {

                // -------------------------------------------------
                // PERIODE
                // -------------------------------------------------

                let awal =
                    $('#tgl_awal').val();

                let akhir =
                    $('#tgl_akhir').val();

                if (awal !== '' && akhir !== '') {

                    $('#periode').html(
                        awal + ' s.d ' + akhir
                    );

                } else {

                    $('#periode').html('-');

                }


                // -------------------------------------------------
                // JENIS SURAT
                // -------------------------------------------------

                let jenis =
                    $('#jenis_suratkeluar_id option:selected').text();

                if (
                    $('#jenis_suratkeluar_id').val() === '' ||
                    $('#jenis_suratkeluar_id').val() === null
                ) {

                    jenis = 'Semua';

                }

                $('#info_jenis').html(jenis);


                // -------------------------------------------------
                // SIFAT SURAT
                // -------------------------------------------------

                let sifat =
                    $('#sifat_surat option:selected').text();

                if (
                    $('#sifat_surat').val() === '' ||
                    $('#sifat_surat').val() === null
                ) {

                    sifat = 'Semua';

                }

                $('#info_sifat').html(sifat);


                // -------------------------------------------------
                // INSTANSI
                // -------------------------------------------------

                let instansi =
                    $('#instansi_id option:selected').text();

                if (
                    $('#instansi_id').val() === '' ||
                    $('#instansi_id').val() === null
                ) {

                    instansi = 'Semua';

                }

                $('#info_instansi').html(instansi);

            }


            // =====================================================
            // UPDATE JUMLAH SURAT
            // =====================================================

            table.on('xhr.dt', function() {

                let json =
                    table.ajax.json();

                if (
                    json &&
                    json.recordsFiltered !== undefined
                ) {

                    $('#jumlah_surat').html(
                        json.recordsFiltered + ' Surat'
                    );

                }

            });


            // =====================================================
            // UPDATE INFORMASI SAAT HALAMAN PERTAMA DIBUKA
            // =====================================================

            updateInformasi();

        });
    </script>


    {{-- =====================================================
         PREVIEW SURAT
    ====================================================== --}}

    <script>
        // =====================================================
        // PREVIEW SURAT
        // =====================================================

        $(document).on(
            'click',
            '.btn-preview-surat',
            function() {

                let file =
                    $(this).data('file');

                $('#previewSurat').attr(
                    'src',
                    file
                );

            }
        );


        // =====================================================
        // BERSIHKAN IFRAME SAAT MODAL DITUTUP
        // =====================================================

        $('#modalPreviewSurat').on(
            'hidden.bs.modal',
            function() {

                $('#previewSurat').attr(
                    'src',
                    ''
                );

            }
        );
    </script>


    {{-- =====================================================
         DOWNLOAD EKSPEDISI SURAT KELUAR
    ====================================================== --}}

    <script>
        $('#btnDownload').click(function() {

            let form = $('<form>', {

                method: 'POST',

                action: "{{ route('download.EkspedisiSuratKeluar') }}"

            });


            // =====================================================
            // CSRF TOKEN
            // =====================================================

            form.append(
                $('<input>', {

                    type: 'hidden',

                    name: '_token',

                    value: "{{ csrf_token() }}"

                })
            );


            // =====================================================
            // FILTER
            // =====================================================

            const filters = {

                tgl_awal: $('#tgl_awal').val(),

                tgl_akhir: $('#tgl_akhir').val(),

                tgl_surat: $('#tgl_surat').val(),

                jenis_suratkeluar_id: $('#jenis_suratkeluar_id').val(),

                sifat_surat: $('#sifat_surat').val(),

                instansi_id: $('#instansi_id').val()

            };


            // =====================================================
            // MASUKKAN FILTER KE FORM
            // =====================================================

            $.each(
                filters,
                function(name, value) {

                    form.append(
                        $('<input>', {

                            type: 'hidden',

                            name: name,

                            value: value || ''

                        })
                    );

                }
            );


            // =====================================================
            // MASUKKAN FORM KE BODY
            // =====================================================

            $('body').append(form);


            // =====================================================
            // SUBMIT
            // =====================================================

            form.submit();


            // =====================================================
            // HAPUS FORM
            // =====================================================

            form.remove();

        });
    </script>
@endpush
