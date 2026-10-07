@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Edit Surat Masuk</h3>
                </div>

                <ul class="breadcrumbs mb-0">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('index.SuratMasuk') }}">Semua Surat Masuk</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit Surat Masuk</a>
                    </li>
                </ul>
            </div>

            <!-- Card Form -->
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-xl-10">
                            <div class="card">
                                <form action="{{ route('update.SuratMasuk', $surat->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="card-body">
                                        <div class="row">
                                            <!-- ================================================= -->
                                            <!-- NOMOR AGENDA -->
                                            <!-- ================================================= -->

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label for="no_agenda">
                                                        Nomor Agenda
                                                        <span class="text-danger">*</span>
                                                    </label>

                                                    <input type="text" name="no_agenda" id="no_agenda"
                                                        class="form-control"
                                                        value="{{ old('no_agenda', $surat->no_agenda) }}"
                                                        placeholder="Masukkan nomor agenda" maxlength="100" required>

                                                    @error('no_agenda')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror

                                                </div>

                                            </div>


                                            <!-- ================================================= -->
                                            <!-- SIFAT SURAT -->
                                            <!-- ================================================= -->

                                            <div class="col-md-6">

                                                <div class="form-group h-100">

                                                    <label for="sifat_surat_id">
                                                        Sifat Surat
                                                        <span class="text-danger">*</span>
                                                    </label>

                                                    <select name="sifat_surat_id" id="sifat_surat_id" class="form-select"
                                                        required>

                                                        <option value="">
                                                            -- Pilih Sifat Surat --
                                                        </option>

                                                        @foreach ($sifatSurat as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ old('sifat_surat_id', $surat->sifat_surat_id) == $item->id ? 'selected' : '' }}>

                                                                {{ $item->nama_sifat }}

                                                            </option>
                                                        @endforeach

                                                    </select>

                                                    @error('sifat_surat_id')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror

                                                </div>

                                            </div>


                                            <!-- ================================================= -->
                                            <!-- NOMOR SURAT -->
                                            <!-- ================================================= -->

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label for="no_surat">
                                                        Nomor Surat
                                                        <span class="text-danger">*</span>
                                                    </label>

                                                    <input type="text" name="no_surat" id="no_surat"
                                                        class="form-control" value="{{ old('no_surat', $surat->no_surat) }}"
                                                        placeholder="Masukkan nomor surat" required>

                                                    @error('no_surat')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror

                                                </div>

                                            </div>


                                            <!-- ================================================= -->
                                            <!-- TANGGAL SURAT -->
                                            <!-- ================================================= -->

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label for="tgl_surat">
                                                        Tanggal Surat
                                                        <span class="text-danger">*</span>
                                                    </label>

                                                    <input type="date" name="tgl_surat" id="tgl_surat"
                                                        class="form-control"
                                                        value="{{ old('tgl_surat', $surat->tgl_surat) }}" required>

                                                    @error('tgl_surat')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror

                                                </div>

                                            </div>


                                            <!-- ================================================= -->
                                            <!-- TANGGAL DITERIMA -->
                                            <!-- ================================================= -->

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label for="tgl_diterima">
                                                        Tanggal Diterima
                                                        <span class="text-danger">*</span>
                                                    </label>

                                                    <input type="date" name="tgl_diterima" id="tgl_diterima"
                                                        class="form-control"
                                                        value="{{ old('tgl_diterima', $surat->tgl_diterima) }}" required>

                                                    @error('tgl_diterima')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror

                                                </div>

                                            </div>


                                            <!-- ================================================= -->
                                            <!-- PENGIRIM -->
                                            <!-- ================================================= -->

                                            <div class="col-md-6">

                                                <div class="form-group h-100">

                                                    <label for="instansi_id">
                                                        Pengirim
                                                        <span class="text-danger">*</span>
                                                    </label>

                                                    <div class="input-group">

                                                        <select name="instansi_id" id="instansi_id" class="form-select"
                                                            required>

                                                            <option value="">
                                                                -- Pilih Instansi --
                                                            </option>

                                                            @foreach ($instansi as $item)
                                                                <option value="{{ $item->id }}"
                                                                    {{ old('instansi_id', $surat->instansi_id) == $item->id ? 'selected' : '' }}>

                                                                    {{ $item->nama_instansi }}

                                                                </option>
                                                            @endforeach

                                                        </select>


                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#modalInstansi">

                                                            <i class="fa fa-plus"></i>

                                                        </button>

                                                    </div>

                                                    @error('instansi_id')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror

                                                </div>

                                            </div>


                                            <!-- ================================================= -->
                                            <!-- PERIHAL -->
                                            <!-- ================================================= -->

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label for="perihal">
                                                        Perihal
                                                        <span class="text-danger">*</span>
                                                    </label>

                                                    <input type="text" name="perihal" id="perihal"
                                                        class="form-control"
                                                        value="{{ old('perihal', $surat->perihal) }}"
                                                        placeholder="Masukkan perihal surat" required>

                                                    @error('perihal')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror

                                                </div>

                                            </div>


                                            <!-- ================================================= -->
                                            <!-- LAMPIRAN -->
                                            <!-- ================================================= -->

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label for="lampiran">
                                                        Lampiran
                                                    </label>

                                                    <input type="text" name="lampiran" id="lampiran"
                                                        class="form-control"
                                                        value="{{ old('lampiran', $surat->lampiran) }}"
                                                        placeholder="Contoh : 1 Berkas">

                                                    @error('lampiran')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror

                                                </div>

                                            </div>


                                            <!-- ================================================= -->
                                            <!-- FILE SURAT -->
                                            <!-- ================================================= -->

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label for="file_surat">

                                                        File Surat

                                                        <small class="text-muted">
                                                            (Kosongkan jika tidak ingin mengganti)
                                                        </small>

                                                    </label>


                                                    <input type="file" name="file_surat" id="file_surat"
                                                        class="form-control" accept=".pdf">

                                                    @error('file_surat')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror


                                                    @if ($surat->file_surat)
                                                        <div class="mt-2">

                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-primary btn-view-file"
                                                                data-bs-toggle="modal" data-bs-target="#modalFileSurat"
                                                                data-file="{{ route('surat-masuk.preview', $surat->id) }}">

                                                                <i class="fa fa-eye"></i>

                                                                Lihat File Saat Ini

                                                            </button>

                                                        </div>
                                                    @endif

                                                </div>

                                            </div>


                                            <!-- ================================================= -->
                                            <!-- KETERANGAN -->
                                            <!-- ================================================= -->

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label for="keterangan">
                                                        Keterangan
                                                    </label>

                                                    <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Keterangan tambahan">{{ old('keterangan', $surat->keterangan) }}</textarea>

                                                    @error('keterangan')
                                                        <small class="text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <!-- ================================================= -->
                                    <!-- ACTION -->
                                    <!-- ================================================= -->

                                    <div class="card-action text-center">

                                        <a href="{{ route('index.SuratMasuk') }}" class="btn btn-danger">

                                            <i class="fa fa-times"></i>

                                            Batal

                                        </a>


                                        <button type="submit" class="btn btn-success">

                                            <i class="fa fa-save"></i>

                                            Update

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal Tambah Instansi -->
    <div class="modal fade" id="modalFileSurat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-file-pdf text-danger"></i>
                        Preview File Surat
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body p-0">
                    <iframe id="pdfViewer" src="" width="100%" height="700" style="border:none;">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInstansi" tabindex="-1" aria-labelledby="modalInstansiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form id="formInstansi">
                    @csrf

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalInstansiLabel">
                            <i class="fa fa-building"></i>
                            Tambah Instansi
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <!-- Kode Instansi -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        Kode Instansi
                                    </label>
                                    <input type="text" name="kode_instansi" class="form-control" maxlength="30"
                                        placeholder="Contoh : BKPSDM">
                                    <small class="text-danger error-kode_instansi"></small>
                                </div>
                            </div>

                            <!-- Jenis Instansi -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Instansispan class="text-danger">*</span></label>
                                    <select name="jenis_instansi" class="form-control">
                                        <option value="">-- Pilih Jenis Instansi --</option>
                                        <option value="Kementerian">Kementerian</option>
                                        <option value="Lembaga">Lembaga</option>
                                        <option value="Pemerintah Provinsi">Pemerintah Provinsi</option>
                                        <option value="Pemerintah Kabupaten/Kota">Pemerintah Kabupaten/Kota</option>
                                        <option value="OPD">OPD</option>
                                        <option value="Kecamatan">Kecamatan</option>
                                        <option value="Kelurahan">Kelurahan</option>
                                        <option value="BUMN">BUMN</option>
                                        <option value="BUMD">BUMD</option>
                                        <option value="Swasta">Swasta</option>
                                        <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                                        <option value="Organisasi">Organisasi</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <small class="text-danger error-jenis_instansi"></small>
                                </div>
                            </div>

                            <!-- Nama Instansi -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nama Instansi<span class="text-danger">*</span></label>
                                    <input type="text" name="nama_instansi" class="form-control"
                                        placeholder="Masukkan Nama Instansi">
                                    <small class="text-danger error-nama_instansi"></small>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" rows="3" class="form-control" placeholder="Masukkan Alamat"></textarea>
                                    <small class="text-danger error-alamat"></small>
                                </div>
                            </div>

                            <!-- Telepon -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Telepon</label>
                                    <input type="text" name="telepon" class="form-control" maxlength="30"
                                        placeholder="08xxxxxxxxxx">
                                    <small class="text-danger error-telepon"></small>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="contoh@email.com">
                                    <small class="text-danger error-email"></small>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="statusModal"
                                            name="status" value="1" checked>
                                        <label class="custom-control-label" for="statusModal">Status Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>Batal</button>

                        <button type="submit" id="btnSimpanInstansi" class="btn btn-success">
                            <i class="fa fa-save"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <!-- SCRIPT TAMBAH INSTANSI -->
    <script>
        function reloadInstansiDropdown(selected = '') {
            $.ajax({
                url: "{{ route('get.InstansiDropdown') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    let html = '';
                    html += '<option value="">-- Pilih Instansi --</option>';
                    $.each(response, function(i, item) {
                        html += `
                   <option value="${item.id}">
                        ${item.nama_instansi}
                    </option>
                `;
                    });
                    $('#instansi_id').html(html);

                    if (selected !== '') {
                        $('#instansi_id').val(selected);
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat memuat data Instansi.'
                    });
                }
            });
        }

        $(document).ready(function() {

            // =========================================================
            // SIMPAN INSTANSI
            // =========================================================
            $('#formInstansi').on('submit', function(e) {
                e.preventDefault();

                // Bersihkan error
                $('.error-kode_instansi').text('');
                $('.error-jenis_instansi').text('');
                $('.error-nama_instansi').text('');
                $('.error-alamat').text('');
                $('.error-telepon').text('');
                $('.error-email').text('');

                // Disable tombol
                $('#btnSimpanInstansi')
                    .prop('disabled', true)
                    .html(
                        '<i class="fa fa-spinner fa-spin"></i> Menyimpan...'
                    );

                // AJAX
                $.ajax({
                    url: "{{ route('store.Instansi') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $(this).serialize(),
                    dataType: "json",

                    // =================================================
                    // SUCCESS
                    // =================================================
                    success: function(response) {
                        $('#btnSimpanInstansi')
                            .prop('disabled', false)
                            .html(
                                '<i class="fa fa-save"></i> Simpan'
                            );

                        if (response.success) {
                            // Reload dropdown
                            reloadInstansiDropdown(
                                response.data.id
                            );

                            // Reset form
                            $('#formInstansi')[0].reset();
                            // Tutup modal
                            const modalElement =
                                document.getElementById('modalInstansi');
                            const modal =
                                bootstrap.Modal.getInstance(modalElement);
                            if (modal) {
                                modal.hide();
                            }

                            // Bersihkan backdrop
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();

                            // Notifikasi
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                html: '<b>Instansi berhasil ditambahkan.</b><br>' +
                                    'Silakan lanjutkan memilih instansi.',
                                timer: 1800,
                                showConfirmButton: false
                            });
                        }
                    },

                    // =================================================
                    // ERROR
                    // =================================================
                    error: function(xhr) {
                        $('#btnSimpanInstansi')
                            .prop('disabled', false)
                            .html(
                                '<i class="fa fa-save"></i> Simpan'
                            );

                        if (xhr.status === 422) {
                            $.each(
                                xhr.responseJSON.errors,
                                function(key, value) {
                                    $('.error-' + key)
                                        .text(value[0]);
                                }
                            );
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan pada server.'
                            });
                        }
                    }
                });
            });
        });
    </script>

    <!-- ========================================================= -->
    <!-- SCRIPT PREVIEW FILE SURAT -->
    <!-- ========================================================= -->

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
