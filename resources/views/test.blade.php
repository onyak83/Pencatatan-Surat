    public function getSuratKeluar(Request $request)
    {
    if ($request->ajax()) {
    $dataSuratKeluar = Suratkeluar::with(['sifatSurat','instansi','jenisSuratKeluar','pegawai'])
    ->orderBy('created_at', 'desc');

    return datatables()->of($dataSuratKeluar)

    // NOMOR AGENDA
    ->editColumn('no_agenda', function ($row) {
    return $row->no_agenda ?: '-';
    })

    // NOMOR SURAT
    ->editColumn('no_surat', function ($row) {
    $tglSurat = $row->tgl_surat
    ? Carbon::parse($row->tgl_surat)
    ->locale('id')
    ->translatedFormat('d M Y')
    : '-';

    return '
    <div class="text-start">
        <small>
            <b>No. Surat</b> :
            ' . e($row->no_surat) . '
        </small>
        <br>
        <small>
            <b>Tgl. Surat</b> :
            ' . $tglSurat . '
        </small>
    </div>
    ';
    })

    // JENIS SURAT
    ->addColumn('jenis_suratkeluar', function ($row) {
    $namaJenis = optional($row->jenisSuratKeluar)
    ->jenis_suratkeluar ?? '-';

    switch ((int) $row->jenis_suratkeluar_id) {

    case 1:
    $class = 'bg-secondary';
    break;

    case 2:
    $class = 'bg-primary';
    break;

    case 3:
    $class = 'bg-success';
    break;

    case 4:
    $class = 'bg-warning text-dark';
    break;

    default:
    $class = 'bg-light text-dark';
    break;
    }

    return '
    <span class="badge ' . $class . ' px-3 py-2">
        ' . e($namaJenis) . '
    </span>
    ';
    })

    // DETAIL SURAT TUGAS
    ->addColumn('detail_tugas', function ($row) {

    // Jika bukan Surat Tugas / Surat Perintah Tugas
    if (!in_array((int) $row->jenis_suratkeluar_id, [2, 3])) {
    return '-';
    }

    $mulai = $row->mulai_tugas
    ? Carbon::parse($row->mulai_tugas)
    ->locale('id')
    ->translatedFormat('d M Y')
    : '-';

    $selesai = $row->selesai_tugas
    ? Carbon::parse($row->selesai_tugas)
    ->locale('id')
    ->translatedFormat('d M Y')
    : '-';

    // DATA PEGAWAI
    $dataPegawai = '';

    if ($row->pegawai && $row->pegawai->count() > 0) {
    $dataPegawai .= '
    <small>
        <b>Pegawai Ditugaskan</b>
    </small>
    ';


    foreach ($row->pegawai as $index => $pegawai) {
    if ($pegawai->pegawaiPu) {
    $dataPegawai .= '

    <div class="mt-2">

        <small>
            <b>' . ($index + 1) . '. '
                . e($pegawai->pegawaiPu->nama) .
                '</b>
        </small>

        <br>


        <small>
            <b>NIP</b> :
            ' . e($pegawai->pegawaiPu->nip) . '
        </small>

        <br>


        <small>
            <b>Jabatan</b> :
            ' . e($pegawai->pegawaiPu->jabatan) . '
        </small>

    </div>

    ';
    }
    }
    } else {
    $dataPegawai .= '

    <small>
        <b>Pegawai Ditugaskan</b> : -
    </small>

    ';
    }

    return '
    <div class="text-start">

        ' . $dataPegawai . '

        <hr class="my-2">

        <small>
            <b>Jumlah Hari</b> :
            ' . e($row->jumlah_hari_tugas ?: '-') . '
        </small>

        <br>

        <small>
            <b>Tujuan</b> :
            ' . e($row->tujuan_tugas ?: '-') . '
        </small>

        <br>

        <small>
            <b>Maksud/Tujuan</b> :
            ' . e($row->maksud_tujuan_tugas ?: '-') . '
        </small>

        <br>

        <small>
            <b>Mulai</b> :
            ' . $mulai . '
        </small>

        <br>

        <small>
            <b>Selesai</b> :
            ' . $selesai . '
        </small>

    </div>
    ';
    })

    // SIFAT SURAT
    ->addColumn('sifat_surat', function ($row) {
    $namaSifat = optional($row->sifatSurat)
    ->nama_sifat ?? '-';

    // | Tentukan warna berdasarkan sifat surat

    $nama = strtolower(trim($namaSifat));
    switch ($nama) {
    case 'biasa':
    $class = 'bg-secondary';
    break;
    case 'rahasia':
    $class = 'bg-warning text-dark';
    break;
    case 'sangat rahasia':
    $class = 'bg-danger';
    break;
    case 'terbatas':
    $class = 'bg-primary';
    break;
    case 'penting':
    $class = 'bg-success';
    break;
    default:
    $class = 'bg-light text-dark';
    break;
    }
    return '
    <span class="badge ' . $class . ' px-3 py-2">
        ' . e($namaSifat) . '
    </span>
    ';
    })

    // LAMPIRAN
    ->addColumn('lampiran', function ($row) {
    return !empty($row->lampiran)
    ? e($row->lampiran)
    : '-';
    })

    // LIHAT FILE
    ->addColumn('lihatfile', function ($row) {
    return view(
    'dashboard.surat.suratkeluar.lihatfile',
    [
    'surat' => $row,
    ]
    );
    })

    // INSTANSI PENGIRIM
    ->addColumn('instansi', function ($row) {
    return optional($row->instansi)
    ->nama_instansi ?? '-';
    })

    // AKSI
    ->addColumn('aksi', function ($row) {
    return view(
    'dashboard.surat.suratkeluar.aksi',
    [
    'surat' => $row,
    ]
    );
    })

    // RAW COLUMNS
    ->rawColumns(['jenis_suratkeluar', 'detail_tugas', 'no_surat','sifat_surat','lihatfile','instansi','aksi'])
    ->make(true);
    }
    }
