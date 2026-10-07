@if ($row->file_surat)
    <button type="button" class="btn btn-sm btn-outline-primary btn-preview-surat"
        data-file="{{ Storage::url($row->file_surat) }}" data-bs-toggle="modal" data-bs-target="#modalPreviewSurat"
        title="Lihat Surat">

        <i class="fa fa-eye"></i>

    </button>
@else
    <span class="text-muted">
        Tidak Ada
    </span>
@endif

<!-- MODAL PREVIEW SURAT -->
<div class="modal fade" id="modalPreviewSurat" tabindex="-1" aria-labelledby="modalPreviewSuratLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title" id="modalPreviewSuratLabel">
                    <i class="fa fa-file-pdf me-2"></i>
                    Preview Surat
                </h5>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                </button>

            </div>

            <div class="modal-body p-0">

                <iframe id="previewSurat" width="100%" height="700" style="border:none;" src="">
                </iframe>

            </div>

        </div>

    </div>

</div>
