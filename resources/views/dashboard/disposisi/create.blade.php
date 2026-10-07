@extends('layout.master')

@section('content')
    <div class="container">
        <div class="page-inner">

            {{-- =====================================================
            HEADER
        ====================================================== --}}
            <div class="page-header d-flex justify-content-between align-items-center">

                <div>
                    <h3 class="fw-bold mb-1">
                        Kirim Disposisi Surat Masuk
                    </h3>

                    <p class="text-muted mb-0">
                        Tentukan tujuan dan instruksi disposisi surat masuk
                    </p>
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
                        <a href="{{ route('index.DisposisiSuratMasuk') }}">
                            Disposisi Surat Masuk
                        </a>
                    </li>

                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>

                    <li class="nav-item">
                        <a href="#">
                            Kirim Disposisi
                        </a>
                    </li>

                </ul>

            </div>


            {{-- =====================================================
            INFORMASI SURAT
        ====================================================== --}}
            <div class="card">

                <div class="card-header">
                    <div class="card-title">

                        <i class="fas fa-envelope-open-text text-primary me-2"></i>

                        Informasi Surat Masuk

                    </div>
                </div>


                <div class="card-body">

                    <div class="row">


                        {{-- =================================================
                        DATA SURAT
                    ================================================== --}}
                        <div class="col-lg-6">

                            <div class="row">


                                {{-- NO AGENDA --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">
                                        No. Agenda
                                    </label>

                                    <input type="text" class="form-control" value="{{ $suratMasuk->no_agenda ?? '-' }}"
                                        readonly>

                                </div>


                                {{-- TANGGAL DITERIMA --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">
                                        Tanggal Diterima
                                    </label>

                                    <input type="text" class="form-control"
                                        value="{{ $suratMasuk->tgl_diterima
                                            ? \Carbon\Carbon::parse($suratMasuk->tgl_diterima)->locale('id')->translatedFormat('d F Y')
                                            : '-' }}"
                                        readonly>

                                </div>


                                {{-- NOMOR SURAT --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">
                                        Nomor Surat
                                    </label>

                                    <input type="text" class="form-control" value="{{ $suratMasuk->no_surat ?? '-' }}"
                                        readonly>

                                </div>


                                {{-- TANGGAL SURAT --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">
                                        Tanggal Surat
                                    </label>

                                    <input type="text" class="form-control"
                                        value="{{ $suratMasuk->tgl_surat
                                            ? \Carbon\Carbon::parse($suratMasuk->tgl_surat)->locale('id')->translatedFormat('d F Y')
                                            : '-' }}"
                                        readonly>

                                </div>


                                {{-- PENGIRIM --}}
                                <div class="col-md-12 mb-3">

                                    <label class="form-label fw-bold">
                                        Pengirim
                                    </label>

                                    <input type="text" class="form-control"
                                        value="{{ $suratMasuk->instansi->nama_instansi ?? '-' }}" readonly>

                                </div>


                                {{-- SIFAT SURAT --}}
                                <div class="col-md-12 mb-3">

                                    <label class="form-label fw-bold">
                                        Sifat Surat
                                    </label>

                                    <input type="text" class="form-control"
                                        value="{{ $suratMasuk->sifatSurat->nama_sifat ?? '-' }}" readonly>

                                </div>


                                {{-- PERIHAL --}}
                                <div class="col-md-12 mb-3">

                                    <label class="form-label fw-bold">
                                        Perihal
                                    </label>

                                    <textarea class="form-control" rows="4" readonly>{{ $suratMasuk->perihal ?? '-' }}</textarea>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                        FILE SURAT
                    ================================================== --}}
                        <div class="col-lg-6">

                            <div class="card border shadow-sm h-100">

                                <div class="card-header bg-light">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <h6 class="mb-0 fw-bold">

                                            <i class="fas fa-file-pdf text-danger me-2"></i>

                                            Dokumen Surat

                                        </h6>

                                        @if ($suratMasuk->file_surat)
                                            <a href="{{ asset('storage/' . $suratMasuk->file_surat) }}" target="_blank"
                                                class="btn btn-sm btn-primary">

                                                <i class="fas fa-external-link-alt me-1"></i>

                                                Buka

                                            </a>
                                        @endif

                                    </div>

                                </div>


                                <div class="card-body p-0">

                                    @if ($suratMasuk->file_surat)
                                        <iframe src="{{ asset('storage/' . $suratMasuk->file_surat) }}" width="100%"
                                            height="600" style="border: none;">
                                        </iframe>
                                    @else
                                        <div class="d-flex flex-column
                                        align-items-center
                                        justify-content-center"
                                            style="height: 600px;">

                                            <i class="fas fa-file fa-4x text-muted mb-3"></i>

                                            <h6 class="text-muted mb-1">
                                                File surat belum tersedia
                                            </h6>

                                            <small class="text-muted">
                                                Tidak terdapat dokumen yang dapat ditampilkan.
                                            </small>

                                        </div>
                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
            FORM PENGIRIMAN DISPOSISI
        ====================================================== --}}
            <div class="card mt-4">

                <div class="card-header">

                    <div class="card-title">

                        <i class="fas fa-paper-plane text-success me-2"></i>

                        Tujuan Pengiriman Disposisi

                    </div>

                </div>


                <form action="{{ route('store.DisposisiSuratMasuk') }}" method="POST">

                    @csrf


                    {{-- ID SURAT MASUK --}}
                    <input type="hidden" name="suratmasuk_id" value="{{ $suratMasuk->id }}">


                    <div class="card-body">


                        {{-- =================================================
                        INFORMASI SINGKAT
                    ================================================== --}}
                        <div class="alert alert-info">

                            <div class="d-flex">

                                <div class="me-3">
                                    <i class="fas fa-info-circle fa-lg"></i>
                                </div>

                                <div>

                                    <strong>
                                        Pengiriman Disposisi
                                    </strong>

                                    <div class="small mt-1">

                                        Pilih pegawai yang menjadi tujuan disposisi
                                        surat ini. Setelah dikirim, penerima akan
                                        mendapatkan disposisi untuk ditindaklanjuti.

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="row">


                            {{-- =================================================
                            KEPADA
                        ================================================== --}}
                            <div class="col-md-12 mb-4">

                                <label class="form-label fw-bold">

                                    Kepada

                                    <span class="text-danger">*</span>

                                </label>


                                <select name="kepada_pegawai_id" id="kepada_pegawai_id"
                                    class="form-select @error('kepada_pegawai_id') is-invalid @enderror" required>

                                    <option value="">
                                        -- Pilih Pegawai Tujuan Disposisi --
                                    </option>


                                    @foreach ($pegawai as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('kepada_pegawai_id') == $item->id ? 'selected' : '' }}>

                                            {{ $item->nama }}

                                            @if ($item->jabatan)
                                                - {{ $item->jabatan }}
                                            @endif

                                        </option>
                                    @endforeach

                                </select>


                                @error('kepada_pegawai_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror


                                <small class="text-muted">
                                    Pilih pegawai yang akan menerima dan menindaklanjuti disposisi.
                                </small>

                            </div>


                            {{-- =================================================
                            INSTRUKSI
                        ================================================== --}}
                            <div class="col-md-12 mb-4">

                                <label class="form-label fw-bold">

                                    Instruksi Disposisi

                                </label>


                                <textarea name="instruksi" id="instruksi" rows="5"
                                    class="form-control @error('instruksi') is-invalid @enderror"
                                    placeholder="Tuliskan instruksi atau arahan untuk penerima disposisi...">{{ old('instruksi') }}</textarea>


                                @error('instruksi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror


                                <small class="text-muted">
                                    Contoh: Mohon ditindaklanjuti dan dilaporkan hasilnya.
                                </small>

                            </div>


                            {{-- =================================================
                            BATAS WAKTU
                        ================================================== --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">

                                    Batas Waktu

                                </label>


                                <input type="date" name="batas_waktu" id="batas_waktu"
                                    class="form-control @error('batas_waktu') is-invalid @enderror"
                                    value="{{ old('batas_waktu') }}">


                                @error('batas_waktu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror


                                <small class="text-muted">
                                    Kosongkan jika tidak ada batas waktu.
                                </small>

                            </div>


                            {{-- =================================================
                            STATUS OTOMATIS
                        ================================================== --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">
                                    Status Setelah Dikirim
                                </label>


                                <div class="form-control bg-light">

                                    <span class="badge bg-warning text-dark">

                                        <i class="fas fa-clock me-1"></i>

                                        Menunggu Diterima

                                    </span>

                                </div>


                                <small class="text-muted">

                                    Status akan berubah otomatis setelah
                                    penerima menerima disposisi.

                                </small>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    FOOTER BUTTON
                ================================================== --}}
                    <div class="card-action d-flex justify-content-center gap-2">

                        <a href="{{ route('index.DisposisiSuratMasuk') }}" class="btn btn-danger">

                            <i class="fas fa-arrow-left me-1"></i>

                            Kembali

                        </a>


                        <button type="submit" class="btn btn-success">

                            <i class="fas fa-paper-plane me-1"></i>

                            Kirim Disposisi

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
@endsection
