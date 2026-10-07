<style>
    .badge-masuk {
        background: #2563EB;
        color: #fff;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-keluar {
        background: #22C55E;
        color: #fff;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('create.SuratMasuk') }}" class="btn btn-primary btn-round">
                    <i class="fa fa-plus me-1"></i> Tambah Surat Masuk
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataSuratMasuk" class="display table table-striped table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. Agenda</th>
                                <th>No. & Tgl.Surat</th>
                                <th>Sifat Surat</th>
                                <th>Lampiran</th>
                                <th>Pengirim</th>
                                <th>Perihal</th>
                                <th>File</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataSuratMasuk').DataTable({
                processing: true,
                serverSide: true,
                responsive: true, // ✅ Aktifkan fitur responsif
                ajax: "{{ route('get.SuratMasuk') }}", // Pastikan route sesuai
                columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart +
                                1; // Agar tetap berurutan saat paginasi
                        }
                    },
                    {
                        data: 'no_agenda',
                        name: 'no_agenda',
                        className: 'text-center'
                    },
                    {
                        data: 'no_surat',
                        name: 'no_surat',
                        className: 'text-center'
                    },
                    {
                        data: 'sifat_surat',
                        name: 'sifat_surat',
                        className: 'text-center'
                    },
                    {
                        data: 'lampiran',
                        name: 'lampiran',
                        className: 'text-center'
                    },
                    {
                        data: 'instansi',
                        name: 'instansi',
                        className: 'text-center'
                    },
                    {
                        data: 'perihal',
                        name: 'perihal',
                        className: 'text-center'
                    },
                    {
                        data: 'lihatfile',
                        name: 'lihatfile',
                        className: 'text-center'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
                },
                searching: true,
                lengthChange: true,
                paging: true,
                info: true,
                ordering: true
            });
        });
    </script>

    <script>
        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Yakin?',
                text: 'Data akan dihapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete-' + id).submit();
                }
            });
        });
    </script>

    <script>
        $(document).on('click', '.btn-view-file', function() {

            let file = $(this).data('file');

            console.log('Preview URL:', file);

            $('#pdfViewer').attr('src', file);

        });

        $('#modalFileSurat').on('hidden.bs.modal', function() {

            $('#pdfViewer').attr('src', '');

        });
    </script>
@endpush
