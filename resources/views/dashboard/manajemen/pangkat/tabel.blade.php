<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('create.Pangkat') }}" class="btn btn-primary btn-round">
                    <i class="fa fa-plus me-1"></i> Tambah Pangkat
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataPangkat" class="display table table-striped table-hover">
                        <thead>
                            <tr class='text-center'>
                                <th>No</th>
                                <th>Golongan</th>
                                <th>Pangkat</th>
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
            $('#dataPangkat').DataTable({
                processing: true,
                serverSide: true,
                responsive: true, // ✅ Aktifkan fitur responsif
                ajax: "{{ route('get.Pangkat') }}", // Pastikan route sesuai
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
                        data: 'nm_gol',
                        name: 'nm_gol',
                        className: 'text-center'
                    },
                    {
                        data: 'nm_pangkat',
                        name: 'nm_pangkat',
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
@endpush
