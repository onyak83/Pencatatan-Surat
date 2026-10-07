<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="card-body">

                {{-- =====================================================
                    FILTER AGENDA SURAT MASUK
                ====================================================== --}}
                <form id="formFilterAgenda">

                    <div class="card shadow-sm border-0">

                        <div class="card-header bg-light">

                            <h5 class="mb-0 fw-bold">
                                <i class="fa fa-filter text-primary me-2"></i>
                                Filter Agenda Surat Masuk
                            </h5>

                        </div>

                        <div class="card-body">

                            <div class="row g-3 align-items-end">

                                {{-- Tanggal Awal --}}
                                <div class="col-xl-2 col-lg-6 col-md-6">

                                    <label class="form-label fw-semibold">
                                        Tanggal Awal
                                    </label>

                                    <input type="date" name="tgl_awal" id="tgl_awal" class="form-control">

                                </div>

                                {{-- Tanggal Akhir --}}
                                <div class="col-xl-2 col-lg-6 col-md-6">

                                    <label class="form-label fw-semibold">
                                        Tanggal Akhir
                                    </label>

                                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control">

                                </div>

                                {{-- Tanggal Surat --}}
                                <div class="col-xl-2 col-lg-6 col-md-6">

                                    <label class="form-label fw-semibold">
                                        Tanggal Surat
                                    </label>

                                    <input type="date" name="tgl_surat" id="tgl_surat" class="form-control">

                                </div>

                                {{-- Sifat Surat --}}
                                <div class="col-xl-2 col-lg-6 col-md-6">

                                    <label class="form-label fw-semibold">
                                        Sifat Surat
                                    </label>

                                    <select name="sifat_surat" id="sifat_surat" class="form-select">

                                        <option value="">
                                            Semua Sifat Surat
                                        </option>

                                        @foreach ($sifatSurat as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama_sifat }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                {{-- Instansi --}}
                                <div class="col-xl-3 col-lg-6 col-md-6">

                                    <label class="form-label fw-semibold">
                                        Instansi
                                    </label>

                                    <select name="instansi_id" id="instansi_id" class="form-select">

                                        <option value="">
                                            Semua Instansi
                                        </option>

                                        @foreach ($instansiview as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->nama_instansi }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                {{-- Status Disposisi --}}
                                <div class="col-xl-3 col-lg-6 col-md-6">

                                    <label class="form-label fw-semibold">
                                        Status Disposisi
                                    </label>

                                    <select name="status_disposisi" id="status_disposisi" class="form-select">

                                        <option value="">
                                            Semua Status
                                        </option>

                                        <option value="belum_disposisi">
                                            Belum Disposisi
                                        </option>

                                        <option value="dikirim">
                                            Menunggu Diterima
                                        </option>

                                        <option value="diterima">
                                            Sudah Diterima
                                        </option>

                                        <option value="diteruskan">
                                            Sedang Diteruskan
                                        </option>

                                        <option value="selesai">
                                            Selesai
                                        </option>

                                    </select>

                                </div>

                                {{-- Tombol --}}
                                <div class="col-xl-2 col-lg-6 col-md-6">

                                    <div class="d-grid gap-2 d-md-flex">

                                        <button type="button" id="btnFilter" class="btn btn-primary" title="Lihat">

                                            <i class="fa fa-search me-1"></i>
                                            Filter

                                        </button>

                                        <button type="button" id="btnDownload" class="btn btn-success"
                                            title="Download">

                                            <i class="fa fa-download me-1"></i>
                                            Download

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


                {{-- =====================================================
                    INFORMASI
                ====================================================== --}}
                <div class="alert alert-light border mb-4 mt-4">

                    <div class="row">

                        <div class="col-md-3">

                            <strong>Periode</strong>
                            <br>

                            <span id="periode">
                                -
                            </span>

                        </div>

                        <div class="col-md-2">

                            <strong>Sifat Surat</strong>
                            <br>

                            <span id="info_sifat">
                                Semua
                            </span>

                        </div>

                        <div class="col-md-3">

                            <strong>Instansi</strong>
                            <br>

                            <span id="info_instansi">
                                Semua
                            </span>

                        </div>

                        <div class="col-md-2">

                            <strong>Status Disposisi</strong>
                            <br>

                            <span id="info_status_disposisi">
                                Semua
                            </span>

                        </div>

                        <div class="col-md-2 text-end">

                            <strong>Jumlah Surat</strong>
                            <br>

                            <span class="badge bg-primary fs-6" id="jumlah_surat">

                                0 Surat

                            </span>

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    TABLE AGENDA SURAT MASUK
                ====================================================== --}}
                <div class="table-responsive">

                    <table id="disposisisuratmasuk"
                        class="table table-bordered table-striped table-hover table-sm w-100">

                        <thead class="table-primary text-center">

                            <tr>

                                <th width="4%">
                                    No
                                </th>

                                <th width="12%">
                                    No. Agenda
                                </th>

                                <th width="10%">
                                    Tgl. Terima
                                </th>

                                <th width="17%">
                                    No. & Tgl. Surat
                                </th>

                                <th width="13%">
                                    Sifat Surat
                                </th>

                                <th width="17%">
                                    Pengirim
                                </th>

                                <th>
                                    Perihal
                                </th>

                                <th width="13%">
                                    Status Disposisi
                                </th>

                                <th width="12%" class="text-center">

                                    Aksi

                                </th>

                            </tr>

                        </thead>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
    MODAL PREVIEW SURAT
============================================================= --}}
<div class="modal fade" id="modalPreviewSurat" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">

                    <i class="fa fa-file-pdf text-danger me-2"></i>
                    Preview Surat

                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body p-0">

                <iframe id="previewSurat" src="" width="100%" height="650px" frameborder="0">
                </iframe>

            </div>

        </div>

    </div>

</div>


{{-- =============================================================
    SCRIPT DATATABLES
============================================================= --}}
@push('myscript')
    <script>
        $(document).ready(function() {

            //    DATATABLES
            let table = $('#disposisisuratmasuk').DataTable({

                processing: true,

                serverSide: true,

                searching: false,

                responsive: true,

                autoWidth: false,

                ajax: {

                    url: "{{ route('get.DisposisiSuratMasuk') }}",

                    data: function(d) {

                        d.tgl_awal =
                            $('#tgl_awal').val();

                        d.tgl_akhir =
                            $('#tgl_akhir').val();

                        d.tgl_surat =
                            $('#tgl_surat').val();

                        d.sifat_surat =
                            $('#sifat_surat').val();

                        d.instansi_id =
                            $('#instansi_id').val();

                        d.status_disposisi =
                            $('#status_disposisi').val();

                    }

                },

                columns: [
                    //    NO
                    {
                        data: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        className: 'text-center align-middle',
                        width: '4%'
                    },

                    //    NO AGENDA
                    {
                        data: 'no_agenda',
                        className: 'text-center align-middle'
                    },

                    //    TANGGAL DITERIMA
                    {
                        data: 'tgl_diterima',
                        className: 'text-center align-middle'
                    },

                    //    NO & TANGGAL SURAT
                    {
                        data: 'no_surat',
                        className: 'align-middle'
                    },

                    //    SIFAT SURAT
                    {
                        data: 'sifat_surat',
                        className: 'text-center align-middle'
                    },

                    //    INSTANSI / PENGIRIM
                    {
                        data: 'instansi',
                        className: 'align-middle'
                    },

                    //    PERIHAL
                    {
                        data: 'perihal',
                        className: 'align-middle'
                    },


                    //    STATUS DISPOSISI
                    {
                        data: 'status_disposisi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center align-middle',
                        render: function(data, type, row) {
                            let status =
                                data || 'belum_disposisi';
                            switch (status) {
                                case 'dikirim':
                                    return `
                                   <span class="badge bg-info">
                                       Menunggu Diterima
                                   </span>
                               `;
                                case 'diterima':
                                    return `
                                   <span class="badge bg-primary">
                                       Sudah Diterima
                                   </span>
                               `;
                                case 'diteruskan':
                                    return `
                                   <span class="badge bg-warning text-dark">
                                       Sedang Diteruskan
                                   </span>
                               `;
                                case 'selesai':
                                    return `
                                   <span class="badge bg-success">
                                       Selesai
                                   </span>
                               `;
                                case 'belum_disposisi':
                                default:
                                    return `
                                   <span class="badge bg-secondary">
                                       Belum Disposisi
                                   </span>
                               `;
                            }
                        }
                    },
                    //    AKSI
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }

                ],


                language: {
                    search: "",
                    searchPlaceholder: "",
                    zeroRecords: "Data tidak ditemukan",
                    emptyTable: "Belum ada data",
                    processing: "Memuat data...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }

            });

            //    FILTER
            $('#btnFilter').click(function() {

                table.ajax.reload();

                updateInformasi();

            });


            //    RESET
            $('#btnReset').click(function() {
                $('#formFilterAgenda')[0].reset();
                table.ajax.reload();
                $('#periode').html('-');
                $('#info_sifat').html('Semua');
                $('#info_instansi').html('Semua');
                $('#info_status_disposisi').html('Semua');
                $('#jumlah_surat').html('0 Surat');
            });


            //    INFORMASI FILTER
            function updateInformasi() {
                let awal = $('#tgl_awal').val();
                let akhir = $('#tgl_akhir').val();

                /* Periode */

                if (
                    awal !== '' &&
                    akhir !== ''
                ) {
                    $('#periode').html(
                        awal + ' s.d ' + akhir
                    );
                } else {
                    $('#periode').html('-');
                }


                /* Sifat */

                let sifat = $('#sifat_surat option:selected').text();
                if (
                    $('#sifat_surat').val() === ''
                ) {

                    sifat = 'Semua';

                }

                $('#info_sifat').html(sifat);


                /* Instansi */
                let instansi =
                    $('#instansi_id option:selected')
                    .text();

                if (
                    $('#instansi_id').val() === ''
                ) {

                    instansi = 'Semua';

                }

                $('#info_instansi').html(instansi);


                /* Status Disposisi */

                let status =
                    $('#status_disposisi option:selected')
                    .text();

                if (
                    $('#status_disposisi').val() === ''
                ) {

                    status = 'Semua';

                }

                $('#info_status_disposisi').html(status);

            }


            //    JUMLAH SURAT
            table.on('xhr.dt', function() {

                let json =
                    table.ajax.json();

                if (
                    json &&
                    json.recordsFiltered !== undefined
                ) {

                    $('#jumlah_surat').html(
                        json.recordsFiltered +
                        ' Surat'
                    );

                }

            });

            //    BERSIHKAN IFRAME
            $('#modalPreviewSurat').on(
                'hidden.bs.modal',
                function() {

                    $('#previewSurat')
                        .attr('src', '');

                }
            );

            //    DOWNLOAD
            $('#btnDownload').click(function() {

                let form =
                    $('<form>', {

                        method: 'POST',

                        action: "{{ route('download.AgendaSuratMasuk') }}"

                    });


                /* CSRF */

                form.append(
                    $('<input>', {

                        type: 'hidden',

                        name: '_token',

                        value: "{{ csrf_token() }}"

                    })
                );


                /* Tanggal Awal */

                form.append(
                    $('<input>', {

                        type: 'hidden',

                        name: 'tgl_awal',

                        value: $('#tgl_awal').val()

                    })
                );


                /* Tanggal Akhir */

                form.append(
                    $('<input>', {

                        type: 'hidden',

                        name: 'tgl_akhir',

                        value: $('#tgl_akhir').val()

                    })
                );


                /* Tanggal Surat */

                form.append(
                    $('<input>', {

                        type: 'hidden',

                        name: 'tgl_surat',

                        value: $('#tgl_surat').val()

                    })
                );


                /* Sifat Surat */

                form.append(
                    $('<input>', {

                        type: 'hidden',

                        name: 'sifat_surat',

                        value: $('#sifat_surat').val()

                    })
                );


                /* Instansi */

                form.append(
                    $('<input>', {

                        type: 'hidden',

                        name: 'instansi_id',

                        value: $('#instansi_id').val()

                    })
                );


                /* Status Disposisi */

                form.append(
                    $('<input>', {

                        type: 'hidden',

                        name: 'status_disposisi',

                        value: $('#status_disposisi').val()

                    })
                );


                /* Masukkan form ke body */

                $('body').append(form);


                /* Submit */

                form.submit();


                /* Hapus */

                form.remove();

            });

        });
    </script>


    <script>
        $(document).on('click', '.btn-delete', function() {

            const id = $(this).data('id');

            Swal.fire({
                title: 'Hapus Disposisi?',
                text: 'Data disposisi yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {
                    $('#form-delete-' + id).submit();
                }

            });

        });
    </script>


    <script>
        $(document).on('click', '.btn-detail-surat', function() {

            let id = $(this).data('id');

            // Reset
            $('#loadingDetailSurat').show();
            $('#contentDetailSurat').hide();

            $('#detail_no_agenda').text('-');
            $('#detail_tgl_diterima').text('-');
            $('#detail_no_surat').text('-');
            $('#detail_tgl_surat').text('-');
            $('#detail_sifat_surat').text('-');
            $('#detail_instansi').text('-');
            $('#detail_perihal').text('-');

            $('#detail_file_surat').hide().attr('src', '');
            $('#detail_no_file').hide();

            // Tampilkan modal
            $('#modalDetailSurat').modal('show');

            // Ambil data
            $.ajax({
                url: "{{ route('detail.smDisposisi', ':id') }}".replace(':id', id),
                type: 'GET',

                success: function(response) {

                    if (!response.success) {
                        Swal.fire(
                            'Gagal',
                            'Data surat tidak ditemukan.',
                            'error'
                        );

                        $('#modalDetailSurat').modal('hide');
                        return;
                    }

                    let data = response.data;

                    $('#detail_no_agenda').text(data.no_agenda);
                    $('#detail_tgl_diterima').text(data.tgl_diterima);
                    $('#detail_no_surat').text(data.no_surat);
                    $('#detail_tgl_surat').text(data.tgl_surat);
                    $('#detail_sifat_surat').text(data.sifat_surat);
                    $('#detail_instansi').text(data.instansi);
                    $('#detail_perihal').text(data.perihal);

                    if (data.file_surat) {

                        $('#detail_file_surat')
                            .attr('src', data.file_surat)
                            .show();

                        $('#detail_no_file').hide();

                    } else {

                        $('#detail_file_surat')
                            .hide()
                            .attr('src', '');

                        $('#detail_no_file').show();
                    }

                    $('#loadingDetailSurat').hide();
                    $('#contentDetailSurat').show();
                },

                error: function(xhr) {

                    $('#modalDetailSurat').modal('hide');

                    Swal.fire(
                        'Gagal',
                        'Terjadi kesalahan saat mengambil data surat.',
                        'error'
                    );
                }
            });
        });
    </script>
@endpush
