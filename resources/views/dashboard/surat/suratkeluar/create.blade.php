@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">Input Surat Keluar</h3>
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
                        <a href="{{ route('index.SuratKeluar') }}">Semua Surat Keluar</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Input Surat Keluar</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('store.SuratKeluar') }}" method="POST" enctype="multipart/form-data"
                        id="formSuratKeluar">
                        @csrf
                        <div class="card border mb-4">
                            <div class="card-body">
                                <div class="row">
                                    {{-- JENIS SURAT --}}

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Jenis Surat Keluar
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="jenis_suratkeluar_id" id="jenis_suratkeluar_id" class="form-select"
                                            @error('jenis_suratkeluar_id') is-invalid @enderror">
                                            <option value="">-- Pilih Jenis Surat --</option>
                                            @foreach ($jenisSuratKeluar as $jenis)
                                                <option value="{{ $jenis->id }}"
                                                    {{ old('jenis_suratkeluar_id') == $jenis->id ? 'selected' : '' }}>
                                                    {{ $jenis->jenis_suratkeluar }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('jenis_suratkeluar_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- SIFAT SURAT --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Sifat Surat
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="sifat_surat_id" class="form-select"
                                            @error('sifat_surat_id') is-invalid @enderror">
                                            <option value="">
                                                -- Pilih Sifat Surat --
                                            </option>
                                            @foreach ($sifatSurat as $sifat)
                                                <option value="{{ $sifat->id }}"
                                                    {{ old('sifat_surat_id') == $sifat->id ? 'selected' : '' }}>
                                                    {{ $sifat->nama_sifat }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sifat_surat_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- NOMOR AGENDA --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Nomor Agenda
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="no_agenda" value="{{ old('no_agenda') }}"
                                            class="form-control @error('no_agenda') is-invalid @enderror"
                                            placeholder="Masukkan nomor agenda">
                                        @error('no_agenda')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        {{-- AGENDA TERAKHIR --}}
                                        @if ($agendaTerakhir->count())
                                            <small class="text-muted d-block mt-1">
                                                <i class="fa fa-info-circle"></i>
                                                Agenda terakhir:
                                                @foreach ($agendaTerakhir as $agenda)
                                                    <span class="badge bg-secondary">
                                                        {{ $agenda->no_agenda }}
                                                    </span>
                                                @endforeach
                                            </small>
                                        @endif
                                    </div>

                                    {{-- NOMOR SURAT --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Nomor Surat
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="no_surat" value="{{ old('no_surat') }}"
                                            class="form-control @error('no_surat') is-invalid @enderror"
                                            placeholder="Masukkan nomor surat">
                                        @error('no_surat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- TANGGAL SURAT --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Tanggal Surat
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="tgl_surat"
                                            value="{{ old('tgl_surat', date('Y-m-d')) }}"
                                            class="form-control @error('tgl_surat') is-invalid @enderror">
                                        @error('tgl_surat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- INSTANSI --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Instansi
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group">
                                            <select name="instansi_id" id="instansi_id"
                                                class="form-select @error('instansi_id') is-invalid @enderror">
                                                <option value="">-- Pilih Instansi --</option>

                                                @foreach ($instansi as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('instansi_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama_instansi }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalInstansi">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>

                                        @error('instansi_id')
                                            <div class="invalid-feedback d-block js-validation-error">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    {{-- PERIHAL --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Perihal
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="perihal" value="{{ old('perihal') }}"
                                            class="form-control @error('perihal') is-invalid @enderror"
                                            placeholder="Masukkan perihal surat">
                                        @error('perihal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- LAMPIRAN --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Lampiran
                                        </label>
                                        <input type="text" name="lampiran" value="{{ old('lampiran') }}"
                                            class="form-control @error('lampiran') is-invalid @enderror"
                                            placeholder="Contoh: 1 berkas">
                                        @error('lampiran')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div id="dataSuratTugas" class="card border mb-4" style="display:none;">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fa fa-briefcase me-2"></i>
                                    Data Surat Tugas
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- JUMLAH HARI --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Jumlah Hari Tugas
                                        </label>
                                        <input type="text" name="jumlah_hari_tugas"
                                            value="{{ old('jumlah_hari_tugas') }}"
                                            class="form-control @error('jumlah_hari_tugas') is-invalid @enderror"
                                            placeholder="Contoh: 3 Hari">
                                        @error('jumlah_hari_tugas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- TUJUAN --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Tujuan Tugas
                                        </label>
                                        <input type="text" name="tujuan_tugas" value="{{ old('tujuan_tugas') }}"
                                            class="form-control @error('tujuan_tugas') is-invalid @enderror"
                                            placeholder="Contoh: Palembang">
                                        @error('tujuan_tugas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- MULAI --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Mulai Tugas
                                        </label>
                                        <input type="date" name="mulai_tugas" value="{{ old('mulai_tugas') }}"
                                            class="form-control @error('mulai_tugas') is-invalid @enderror">
                                        @error('mulai_tugas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- SELESAI --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Selesai Tugas
                                        </label>
                                        <input type="date" name="selesai_tugas" value="{{ old('selesai_tugas') }}"
                                            class="form-control @error('selesai_tugas') is-invalid @enderror">
                                        @error('selesai_tugas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- MAKSUD TUJUAN --}}
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">
                                            Maksud / Tujuan Tugas
                                        </label>
                                        <textarea name="maksud_tujuan_tugas" rows="3"
                                            class="form-control @error('maksud_tujuan_tugas') is-invalid @enderror"
                                            placeholder="Jelaskan maksud dan tujuan tugas">{{ old('maksud_tujuan_tugas') }}</textarea>
                                        @error('maksud_tujuan_tugas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="dataPegawai" class="card border mb-4" style="display:none;">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fa fa-users me-2"></i>Pegawai yang Ditugaskan
                                </h5>

                                <button type="button" class="btn btn-sm btn-primary" id="btnTambahPegawai">
                                    <i class="fa fa-plus"></i>Tambah Pegawai
                                </button>
                            </div>

                            <div class="card-body">
                                <div id="pegawaiContainer">
                                    {{-- DEFAULT 1 PEGAWAI --}}
                                    <div class="pegawai-item border rounded p-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-5 mb-2">
                                                <label class="form-label">Pilih Pegawai</label>
                                                <select name="pegawai[0][pegawaipu_id]" class="form-select pegawaiSelect">
                                                    <option value="">-- Pilih Pegawai --</option>
                                                    @foreach ($dataPegawai as $pegawai)
                                                        <option value="{{ $pegawai->id }}"
                                                            data-nama="{{ $pegawai->nama }}"
                                                            data-nip="{{ $pegawai->nip }}"
                                                            data-jabatan="{{ $pegawai->jabatan }}">
                                                            {{ $pegawai->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">NIP</label>
                                                <input type="text" class="form-control nipPegawai" readonly>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <label class="form-label">Jabatan</label>
                                                <input type="text" class="form-control jabatanPegawai" readonly>
                                            </div>

                                            <div class="col-md-1 d-flex align-items-end mb-2">
                                                <button type="button" class="btn btn-danger btnHapusPegawai w-100">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border mb-4">
                            <div class="card-body">
                                <div class="row">
                                    {{-- FILE --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            File Surat
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" name="file_surat" accept="application/pdf"
                                            class="form-control @error('file_surat') is-invalid @enderror">
                                        <small class="text-muted">
                                            Format PDF, maksimal 2 MB.
                                        </small>
                                        @error('file_surat')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- KETERANGAN --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Keterangan</label>
                                        <textarea name="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror"
                                            placeholder="Keterangan tambahan">{{ old('keterangan') }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action text-center">
                            <a href="{{ route('index.SuratKeluar') }}" class="btn btn-danger">
                                <i class="fa fa-times"></i> Batal
                            </a>

                            <button type="button" class="btn btn-secondary" id="btnReset">
                                <i class="fa fa-refresh me-1"></i>
                                Reset
                            </button>

                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal Tambah Instansi -->
    <div class="modal fade" id="modalInstansi" tabindex="-1" aria-labelledby="modalInstansiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form id="formInstansi">
                    @csrf

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalInstansiLabel"><i class="fa fa-building"></i>
                            Tambah Instansi
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <!-- Kode Instansi -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Instansi</label>
                                    <input type="text" name="kode_instansi" class="form-control" maxlength="30"
                                        placeholder="Contoh : BKPSDM">
                                    <small class="text-danger error-kode_instansi"></small>
                                </div>
                            </div>

                            <!-- Jenis Instansi -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        Jenis Instansi
                                        <span class="text-danger">*</span>
                                    </label>

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
                                        <label class="custom-control-label" for="statusModal">
                                            Status Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Batal
                        </button>

                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    //button reset
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('formSuratKeluar');
            const btnReset = document.getElementById('btnReset');

            if (!form || !btnReset) {
                return;
            }

            btnReset.addEventListener('click', function() {

                // Reset seluruh input
                form.reset();

                // ===============================
                // RESET SELECT
                // ===============================

                form.querySelectorAll('select').forEach(function(select) {
                    select.selectedIndex = 0;
                });

                // Reset khusus Select2 Instansi
                if ($('#instansi_id').hasClass('select2-hidden-accessible')) {
                    $('#instansi_id').val(null).trigger('change');
                } else {
                    $('#instansi_id').val('');
                }

                // Reset Jenis Surat
                const jenisSurat = document.getElementById('jenis_suratkeluar_id');

                if (jenisSurat) {
                    jenisSurat.value = '';
                }

                // ===============================
                // HAPUS VALIDASI
                // ===============================

                form.querySelectorAll('.is-invalid').forEach(function(element) {
                    element.classList.remove('is-invalid');
                });

                form.querySelectorAll('.is-valid').forEach(function(element) {
                    element.classList.remove('is-valid');
                });

                // Hapus pesan error
                form.querySelectorAll('.invalid-feedback').forEach(function(element) {
                    element.remove();
                });

                // ===============================
                // RESET FILE
                // ===============================

                form.querySelectorAll('input[type="file"]').forEach(function(input) {
                    input.value = '';
                });

                // ===============================
                // RESET SURAT TUGAS
                // ===============================

                const bagianSuratTugas =
                    document.getElementById('bagianSuratTugas');

                if (bagianSuratTugas) {
                    bagianSuratTugas.style.display = 'none';
                }

                // ===============================
                // RESET PEGAWAI
                // ===============================

                const bagianPegawai =
                    document.getElementById('bagianPegawai');

                if (bagianPegawai) {
                    bagianPegawai.style.display = 'none';
                }

                const containerPegawai =
                    document.getElementById('containerPegawai');

                if (containerPegawai) {
                    containerPegawai.innerHTML = '';
                }

            });

        });


        // TAMPILKAN DATA PEGAWAI SETELAH DIPILIH
        document.addEventListener('change', function(e) {

            if (e.target.classList.contains('pegawaiSelect')) {

                let selected = e.target.options[e.target.selectedIndex];

                let nip = selected.getAttribute('data-nip') || '';

                let jabatan = selected.getAttribute('data-jabatan') || '';


                let parent = e.target.closest('.pegawai-item');


                parent.querySelector('.nipPegawai').value = nip;

                parent.querySelector('.jabatanPegawai').value = jabatan;

            }

        });
    </script>

    <script>
        // =========================================================
        // RELOAD DROPDOWN INSTANSI
        // =========================================================
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

                    // Update dropdown
                    $('#instansi_id').html(html);

                    // Pilih instansi yang baru ditambahkan
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


        // =========================================================
        // SIMPAN INSTANSI DARI MODAL
        // =========================================================
        $(document).ready(function() {

            $('#formInstansi').on('submit', function(e) {

                e.preventDefault();


                // -------------------------------------------------
                // Bersihkan error sebelumnya
                // -------------------------------------------------
                $('.error-kode_instansi').text('');
                $('.error-jenis_instansi').text('');
                $('.error-nama_instansi').text('');
                $('.error-alamat').text('');
                $('.error-telepon').text('');
                $('.error-email').text('');


                // -------------------------------------------------
                // Disable tombol simpan
                // -------------------------------------------------
                $('#btnSimpanInstansi')
                    .prop('disabled', true)
                    .html(
                        '<i class="fa fa-spinner fa-spin"></i> Menyimpan...'
                    );


                // -------------------------------------------------
                // AJAX SIMPAN INSTANSI
                // -------------------------------------------------
                $.ajax({

                    url: "{{ route('store.Instansi') }}",

                    type: "POST",

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    data: $(this).serialize(),

                    dataType: "json",


                    // =================================================
                    // BERHASIL
                    // =================================================
                    success: function(response) {

                        // Aktifkan kembali tombol
                        $('#btnSimpanInstansi')
                            .prop('disabled', false)
                            .html(
                                '<i class="fa fa-save"></i> Simpan'
                            );


                        if (response.success) {

                            // -------------------------------------------------
                            // Reload dropdown instansi
                            // -------------------------------------------------
                            reloadInstansiDropdown(response.data.id);


                            // -------------------------------------------------
                            // Reset form instansi
                            // -------------------------------------------------
                            $('#formInstansi')[0].reset();


                            // -------------------------------------------------
                            // Tutup modal
                            // -------------------------------------------------
                            const modalElement =
                                document.getElementById('modalInstansi');

                            const modal =
                                bootstrap.Modal.getInstance(modalElement);

                            if (modal) {
                                modal.hide();
                            }


                            // -------------------------------------------------
                            // Bersihkan backdrop modal
                            // -------------------------------------------------
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();


                            // -------------------------------------------------
                            // Notifikasi berhasil
                            // -------------------------------------------------
                            Swal.fire({

                                icon: 'success',

                                title: 'Berhasil',

                                text: response.message,

                                timer: 1500,

                                showConfirmButton: false

                            });

                        }

                    },


                    // =================================================
                    // ERROR
                    // =================================================
                    error: function(xhr) {

                        // Aktifkan kembali tombol
                        $('#btnSimpanInstansi')
                            .prop('disabled', false)
                            .html(
                                '<i class="fa fa-save"></i> Simpan'
                            );


                        // -------------------------------------------------
                        // Validation Error Laravel
                        // -------------------------------------------------
                        if (xhr.status === 422) {

                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {

                                $('.error-' + key)
                                    .text(value[0]);

                            });

                        } else {

                            // -------------------------------------------------
                            // Error Server
                            // -------------------------------------------------
                            console.log(xhr.responseText);

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const jenisSurat =
                document.getElementById('jenis_suratkeluar_id');

            const dataSuratTugas =
                document.getElementById('dataSuratTugas');

            const dataPegawai =
                document.getElementById('dataPegawai');

            const pegawaiContainer =
                document.getElementById('pegawaiContainer');

            const btnTambahPegawai =
                document.getElementById('btnTambahPegawai');


            let pegawaiIndex =
                document.querySelectorAll('.pegawai-item').length;

            btnTambahPegawai.addEventListener('click', function() {

                const html = `

    <div class="pegawai-item border rounded p-3 mb-3">

        <div class="row">

            <div class="col-md-5 mb-2">

                <label class="form-label">
                    Pilih Pegawai
                </label>


                <select 
                    name="pegawai[${pegawaiIndex}][pegawaipu_id]"
                    class="form-select pegawaiSelect">

                    <option value="">
                        -- Pilih Pegawai --
                    </option>


                    @foreach ($dataPegawai as $pegawai)

                    <option 
                        value="{{ $pegawai->id }}"
                        data-nip="{{ $pegawai->nip }}"
                        data-jabatan="{{ $pegawai->jabatan }}">

                        {{ $pegawai->nama }}

                    </option>

                    @endforeach

                </select>

            </div>


            <div class="col-md-3 mb-2">

                <label>NIP</label>

                <input type="text"
                    class="form-control nipPegawai"
                    readonly>

            </div>


            <div class="col-md-3 mb-2">

                <label>Jabatan</label>

                <input type="text"
                    class="form-control jabatanPegawai"
                    readonly>

            </div>


            <div class="col-md-1 d-flex align-items-end">

                <button type="button"
                    class="btn btn-danger btnHapusPegawai">

                    <i class="fa fa-trash"></i>

                </button>

            </div>


        </div>

    </div>

    `;


                pegawaiContainer.insertAdjacentHTML(
                    'beforeend',
                    html
                );


                pegawaiIndex++;

            });


            // TAMPIL / SEMBUNYIKAN DATA SURAT TUGAS & PEGAWAI
            // ID 2 DAN 3
            function toggleJenisSurat() {

                const id =
                    jenisSurat.value;


                if (id === '2' || id === '3') {

                    dataSuratTugas.style.display = 'block';

                    dataPegawai.style.display = 'block';

                } else {

                    dataSuratTugas.style.display = 'none';

                    dataPegawai.style.display = 'none';

                }

            }


            // HAPUS PEGAWAI
            document.addEventListener('click', function(event) {

                const button =
                    event.target.closest('.btnHapusPegawai');


                if (!button) {
                    return;
                }


                const items =
                    document.querySelectorAll('.pegawai-item');


                // minimal 1 pegawai
                if (items.length <= 1) {

                    alert(
                        'Minimal harus ada 1 pegawai.'
                    );

                    return;
                }

                button
                    .closest('.pegawai-item')
                    .remove();

            });

            // PERUBAHAN JENIS SURAT
            jenisSurat.addEventListener(
                'change',
                toggleJenisSurat
            );


            // LOAD AWAL Penting untuk old()
            toggleJenisSurat();

        });
    </script>
@endpush
