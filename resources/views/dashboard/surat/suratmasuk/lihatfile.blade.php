<button type="button" class="btn btn-success btn-icon btn-round btn-view-file" data-bs-toggle="modal"
    data-bs-target="#modalFileSurat" title="Lihat File" data-file="{{ route('surat-masuk.preview', $surat->id) }}">

    <i class="fa fa-eye"></i>

</button>


{{-- modal --}}
<div class="modal fade" id="modalFileSurat" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Preview File Surat
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body p-0">
                <iframe id="pdfViewer" width="100%" height="700" style="border:none;">
                </iframe>
            </div>
        </div>
    </div>
</div>
