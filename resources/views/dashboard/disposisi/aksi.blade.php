<div class="d-flex align-items-center justify-content-center gap-1">

    {{-- DETAIL SURAT MASUK --}}
    <button type="button" class="btn btn-info btn-icon btn-round btn-detail-surat" data-id="{{ $row->id }}"
        title="Detail Surat">
        <i class="fas fa-eye"></i>
    </button>


    {{-- MODAL DETAIL SURAT MASUK --}}
    <div class="modal fade" id="modalDetailSurat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-envelope me-2"></i>
                        Detail Surat Masuk
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <div id="loadingDetailSurat" class="text-center py-5">
                        <div class="spinner-border text-info"></div>
                        <p class="mt-2 mb-0">
                            Memuat data surat...
                        </p>
                    </div>

                    <div id="contentDetailSurat" style="display:none;">

                        <div class="row">

                            {{-- INFORMASI SURAT --}}
                            <div class="col-md-5">

                                <div class="card border">
                                    <div class="card-header">
                                        <strong>
                                            <i class="fas fa-info-circle me-1"></i>
                                            Informasi Surat
                                        </strong>
                                    </div>

                                    <div class="card-body p-0">

                                        <table class="table table-bordered mb-0">

                                            <tr>
                                                <th width="40%">No. Agenda</th>
                                                <td id="detail_no_agenda">-</td>
                                            </tr>

                                            <tr>
                                                <th>Tanggal Diterima</th>
                                                <td id="detail_tgl_diterima">-</td>
                                            </tr>

                                            <tr>
                                                <th>No. Surat</th>
                                                <td id="detail_no_surat">-</td>
                                            </tr>

                                            <tr>
                                                <th>Tanggal Surat</th>
                                                <td id="detail_tgl_surat">-</td>
                                            </tr>

                                            <tr>
                                                <th>Sifat Surat</th>
                                                <td id="detail_sifat_surat">-</td>
                                            </tr>

                                            <tr>
                                                <th>Pengirim</th>
                                                <td id="detail_instansi">-</td>
                                            </tr>

                                            <tr>
                                                <th>Perihal</th>
                                                <td id="detail_perihal">-</td>
                                            </tr>

                                        </table>

                                    </div>
                                </div>

                            </div>

                            {{-- FILE SURAT --}}
                            <div class="col-md-7">

                                <div class="card border">
                                    <div class="card-header">
                                        <strong>
                                            <i class="fas fa-file-pdf text-danger me-1"></i>
                                            File Surat Masuk
                                        </strong>
                                    </div>

                                    <div class="card-body p-0">

                                        <iframe id="detail_file_surat" src="" width="100%" height="550"
                                            style="border:0;">
                                        </iframe>

                                        <div id="detail_no_file" class="text-center py-5" style="display:none;">

                                            <i class="fas fa-file fa-3x text-muted mb-3"></i>

                                            <p class="text-muted mb-0">
                                                File surat belum tersedia.
                                            </p>

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Tutup
                    </button>

                </div>

            </div>
        </div>
    </div>

    {{-- BUAT / LIHAT DISPOSISI --}}
    <a href="{{ route('create.DisposisiSuratMasuk', $row->id) }}" class="btn btn-success btn-icon btn-round"
        title="Disposisi Surat">
        <i class="fas fa-share"></i>
    </a>

</div>
