<?php

namespace App\Http\Controllers;

use App\Exports\AgendaSuratMasukExport;
use App\Exports\EkspedisiSuratKeluarExport;
use App\Models\Disposisi;
use App\Models\Instansi;
use App\Models\Pegawaipu;
use App\Models\Suratkeluar;
use App\Models\Suratkeluarpegawai;
use App\Models\Suratmasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        // TOTAL SURAT
        $totalSuratMasuk = Suratmasuk::count();
        $totalSuratKeluar = Suratkeluar::count();

        // SURAT HARI INI
        $suratMasukHariIni = Suratmasuk::whereDate('created_at', Carbon::today())->count();

        $suratKeluarHariIni = Suratkeluar::whereDate('created_at', Carbon::today())->count();

        // BULAN INI
        $suratMasukBulanIni = Suratmasuk::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $suratKeluarBulanIni = Suratkeluar::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // BULAN LALU
        $bulanLalu = Carbon::now()->subMonth();
        $suratMasukBulanLalu = Suratmasuk::whereMonth('created_at', $bulanLalu->month)
            ->whereYear('created_at', $bulanLalu->year)
            ->count();

        $suratKeluarBulanLalu = Suratkeluar::whereMonth('created_at', $bulanLalu->month)
            ->whereYear('created_at', $bulanLalu->year)
            ->count();

        // PERSENTASE PERUBAHAN SURAT MASUK
        if ($suratMasukBulanLalu > 0) {
            $persentaseSuratMasuk = (
                ($suratMasukBulanIni - $suratMasukBulanLalu)
                / $suratMasukBulanLalu
            ) * 100;
        } else {
            $persentaseSuratMasuk =
                $suratMasukBulanIni > 0 ? 100 : 0;
        }

        // PERSENTASE PERUBAHAN SURAT KELUAR
        if ($suratKeluarBulanLalu > 0) {
            $persentaseSuratKeluar = (
                ($suratKeluarBulanIni - $suratKeluarBulanLalu)
                / $suratKeluarBulanLalu
            ) * 100;
        } else {
            $persentaseSuratKeluar =
                $suratKeluarBulanIni > 0 ? 100 : 0;
        }

        // GRAFIK SURAT PER BULAN
        $tahun = Carbon::now()->year;

        // Default 12 bulan = 0
        $grafikSuratMasuk = array_fill(0, 12, 0);
        $grafikSuratKeluar = array_fill(0, 12, 0);

        // SURAT MASUK
        $suratMasukPerBulan = Suratmasuk::selectRaw(
            'MONTH(created_at) as bulan, COUNT(*) as total'
        )
                ->whereYear('created_at', $tahun)
                ->groupByRaw('MONTH(created_at)')
                ->orderByRaw('MONTH(created_at)')
                ->get();

        foreach ($suratMasukPerBulan as $item) {
            $grafikSuratMasuk[$item->bulan - 1] =
                (int) $item->total;
        }


        // SURAT KELUAR
        $suratKeluarPerBulan = Suratkeluar::selectRaw(
            'MONTH(created_at) as bulan, COUNT(*) as total'
        )
            ->whereYear('created_at', $tahun)
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();

        foreach ($suratKeluarPerBulan as $item) {
            $grafikSuratKeluar[$item->bulan - 1] =
                (int) $item->total;
        }

        // STATISTIK SURAT PER INSTANSI
        // SURAT MASUK PER INSTANSI
        $suratMasukPerInstansi = Suratmasuk::with('instansi')
            ->selectRaw('instansi_id, COUNT(*) as total')
            ->whereNotNull('instansi_id')
            ->groupBy('instansi_id')
            ->orderByDesc('total')
            ->get();


        // SURAT KELUAR PER INSTANSI
        $suratKeluarPerInstansi = Suratkeluar::with('instansi')
            ->selectRaw('instansi_id, COUNT(*) as total')
            ->whereNotNull('instansi_id')
            ->groupBy('instansi_id')
            ->orderByDesc('total')
            ->get();


        // =========================================================
        // SURAT TERBARU
        // =========================================================

        // 5 SURAT MASUK TERBARU
        $suratMasukTerbaru = Suratmasuk::with([
            'instansi',
            'sifatSurat',
        ])
            ->latest('created_at')
            ->take(5)
            ->get();


        // 5 SURAT KELUAR TERBARU
        $suratKeluarTerbaru = Suratkeluar::with([
            'instansi',
            'sifatSurat',
        ])
            ->latest('created_at')
            ->take(5)
            ->get();


        // =========================================================
        // 4 SURAT MASUK TERAKHIR
        // =========================================================

        $suratMasukTerbaru = Suratmasuk::with([
            'instansi',
            'sifatSurat',
        ])
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();


        // 4 SURAT KELUAR TERAKHIR
        $suratKeluarTerbaru = Suratkeluar::with([
            'instansi',
            'sifatSurat',
            'pegawai',
        ])
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        // KIRIM KE DASHBOARD
        return view(
            'dashboard.dashboard',
            compact(
                'totalSuratMasuk',
                'totalSuratKeluar',
                'suratMasukHariIni',
                'suratKeluarHariIni',
                'suratMasukBulanIni',
                'suratKeluarBulanIni',
                'suratMasukBulanLalu',
                'suratKeluarBulanLalu',
                'persentaseSuratMasuk',
                'persentaseSuratKeluar',
                'grafikSuratMasuk',
                'grafikSuratKeluar',
                'tahun',
                // STATISTIK INSTANSI
                'suratMasukPerInstansi',
                'suratKeluarPerInstansi',

                // SURAT TERBARU
                'suratMasukTerbaru',
                'suratKeluarTerbaru'
            )
        );
    }

    public function getInstansiDropdown()
    {
        $viewInstansi = Instansi::where('status', true)
            ->orderBy('nama_instansi', 'ASC')
            ->get(['id', 'nama_instansi','jenis_instansi']);

        return response()->json($viewInstansi);
    }

    public function indexSuratMasuk()
    {
        return view('dashboard.surat.suratmasuk.index');
    }

    public function getSuratMasuk(Request $request)
    {
        if ($request->ajax()) {
            $dataSuratMasuk = Suratmasuk::with(['sifatSurat','instansi'])
            ->orderBy('created_at', 'desc');

            return datatables()->of($dataSuratMasuk)

            // TANGGAL DITERIMA
            ->editColumn('tgl_diterima', function ($row) {
                return $row->tgl_diterima
                    ? Carbon::parse($row->tgl_diterima)
                        ->locale('id')
                        ->translatedFormat('d M Y')
                    : '-';
            })

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

                $tglDiterima = $row->tgl_diterima
                    ? Carbon::parse($row->tgl_diterima)
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
                        <br>
                        <small>
                            <b>Tgl. Diterima</b> :
                            ' . $tglDiterima . '
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
                    'dashboard.surat.suratmasuk.lihatfile',
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
                    'dashboard.surat.suratmasuk.aksi',
                    [
                        'surat' => $row,
                    ]
                );
            })

            // RAW COLUMNS
            ->rawColumns(['no_surat','sifat_surat','lihatfile','instansi','aksi'])
            ->make(true);
        }
    }

    public function previewSuratMasuk(string $id)
    {
        $surat = Suratmasuk::findOrFail($id);

        $path = storage_path('app/public/' . $surat->file_surat);

        if (!file_exists($path)) {
            abort(404, 'File surat tidak ditemukan.');
        }

        return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
    ]);
    }

    public function createSuratMasuk()
    {
        $sifatSurat = DB::table('sifatsurats')->get();
        $instansi = Instansi::where('status', true)
            ->orderBy('nama_instansi')
            ->get();

        $agendaTerakhir = Suratmasuk::orderBy('created_at', 'desc')
            ->take(3)
            ->get(['no_agenda']);

        return view('dashboard.surat.suratmasuk.create', compact('sifatSurat', 'instansi', 'agendaTerakhir'));
    }

    public function storeSuratMasuk(Request $request)
    {
        $rules = [
            'no_agenda' => ['required','string','max:100','unique:suratmasuks,no_agenda',],
            'sifat_surat_id' => ['required','exists:sifatsurats,id',],
            'no_surat'       => ['required','string', 'max:255','unique:suratmasuks,no_surat',],
            'tgl_surat'      => ['required','date',],
            'tgl_diterima'   => ['required','date','after_or_equal:tgl_surat',],
            'instansi_id'    => ['required','exists:instansis,id',],
            'perihal'        => ['required','string','max:255',],
            'lampiran'       => ['nullable','string','max:255',],
            'file_surat'     => ['required','file','mimes:pdf','max:2048',],
            'keterangan'     => ['nullable','string',],
        ];

        //validasi
        $messages = [
            'no_agenda.required' => 'Nomor Agenda wajib diisi.',
            'no_agenda.unique'   => 'Nomor Agenda sudah digunakan. Silakan gunakan nomor agenda lain.',
            'no_agenda.max'      => 'Nomor Agenda maksimal 100 karakter.',
            'sifat_surat_id.required' => 'Sifat Surat wajib dipilih.',
            'sifat_surat_id.exists'   => 'Sifat Surat tidak ditemukan.',
            'no_surat.required' => 'Nomor Surat wajib diisi.',
            'no_surat.unique'   => 'Nomor Surat sudah terdaftar.',
            'no_surat.max'      => 'Nomor Surat maksimal 255 karakter.',
            'tgl_surat.required' => 'Tanggal Surat wajib diisi.',
            'tgl_surat.date'     => 'Format Tanggal Surat tidak valid.',
            'tgl_diterima.required'      => 'Tanggal Diterima wajib diisi.',
            'tgl_diterima.date'          => 'Format Tanggal Diterima tidak valid.',
            'tgl_diterima.after_or_equal' => 'Tanggal Diterima tidak boleh lebih kecil dari Tanggal Surat.',
            'instansi_id.required' => 'Instansi Pengirim wajib dipilih.',
            'instansi_id.exists'   => 'Instansi Pengirim tidak ditemukan.',
            'perihal.required' => 'Perihal wajib diisi.',
            'perihal.max'      => 'Perihal maksimal 255 karakter.',

            'lampiran.max' => 'Lampiran maksimal 255 karakter.',

            'file_surat.required' => 'File Surat wajib diunggah.',
            'file_surat.file'     => 'File Surat tidak valid.',
            'file_surat.mimes'    => 'File Surat harus berformat PDF.',
            'file_surat.max'      => 'Ukuran File Surat maksimal 2 MB.',

            'keterangan.string' => 'Keterangan harus berupa teks.',
        ];

        //validator
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        }

        //transaksi database
        DB::beginTransaction();

        $folder   = null;
        $namaFile = null;

        try {
            // upload file
            $file = $request->file('file_surat');
            $tahun = now()->year;
            $folder = 'surat/masuk/' . $tahun;
            $namaFile = 'SM_' .now()->format('YmdHis') .'_' .Str::upper(Str::random(8)) .'.pdf';
            $file->storeAs($folder, $namaFile, 'public');

            //simpan surat masuk

            Suratmasuk::create([
            'instansi_id'    => $request->instansi_id,
            'sifat_surat_id' => $request->sifat_surat_id,
            'no_agenda'      => trim($request->no_agenda),
            'no_surat'       => trim($request->no_surat),
            'tgl_surat'      => $request->tgl_surat,
            'tgl_diterima'   => $request->tgl_diterima,
            'perihal'        => trim($request->perihal),
            'lampiran'       => $request->lampiran
                ? trim($request->lampiran)
                : null,
            'file_surat'     => $folder . '/' . $namaFile,
            'keterangan'     => $request->keterangan
                ? trim($request->keterangan)
                : null,
            'created_by'     => Auth::id(),
        ]);

            // commit
            DB::commit();

            //notifikasi
            Alert::success(
                'Berhasil',
                'Surat masuk berhasil disimpan.'
            );

            return redirect()->route('index.SuratMasuk');
        } catch (\Exception $e) {

            // rollback
            DB::rollBack();

            // hapus file jika database gagal

            if ($namaFile && $folder && Storage::disk('public')->exists($folder . '/' . $namaFile)
            ) {
                Storage::disk('public')->delete($folder . '/' . $namaFile);
            }

            //log error
            Log::error(
                'Store Surat Masuk Error',
                [
                'request' => $request->except('_token'),
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                ]
            );

            //notifikasi error
            Alert::error(
                'Gagal',
                'Terjadi kesalahan saat menyimpan surat masuk.'
            );

            return redirect()
            ->back()
            ->withInput();
        }
    }

    public function editSuratMasuk(string $id)
    {
        $sifatSurat = DB::table('sifatsurats')->get();
        $instansi = Instansi::where('status', true)
            ->orderBy('nama_instansi')
            ->get();

        $surat = Suratmasuk::findOrFail($id);

        return view('dashboard.surat.suratmasuk.edit', compact('surat', 'sifatSurat', 'instansi'));
    }

    public function updateSuratMasuk(Request $request, string $id)
    {
        // CARI DATA SURAT
        $surat = Suratmasuk::findOrFail($id);

        // VALIDASI
        $rules = [
                'no_agenda' => [
                    'required',
                    'string',
                    'max:100',
                    'unique:suratmasuks,no_agenda,' . $surat->id,
                ],

                'sifat_surat_id' => [
                    'required',
                    'exists:sifatsurats,id',
                ],

                'no_surat' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:suratmasuks,no_surat,' . $surat->id,
                ],

                'tgl_surat' => [
                    'required',
                    'date',
                ],

                'tgl_diterima' => [
                    'required',
                    'date',
                    'after_or_equal:tgl_surat',
                ],

                'instansi_id' => [
                    'required',
                    'exists:instansis,id',
                ],

                'perihal' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'lampiran' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                // Saat edit file tidak wajib
                'file_surat' => [
                    'nullable',
                    'file',
                    'mimes:pdf',
                    'max:2048',
                ],

                'keterangan' => [
                    'nullable',
                    'string',
                ],
            ];

        // PESAN VALIDASI
        $messages = [
            'no_agenda.required' =>
                'Nomor Agenda wajib diisi.',
            'no_agenda.unique' =>
                'Nomor Agenda sudah digunakan. Silakan gunakan nomor agenda lain.',
            'no_agenda.max' =>
                'Nomor Agenda maksimal 100 karakter.',
            'sifat_surat_id.required' =>
                'Sifat Surat wajib dipilih.',
            'sifat_surat_id.exists' =>
                'Sifat Surat tidak ditemukan.',
            'no_surat.required' =>
                'Nomor Surat wajib diisi.',
            'no_surat.unique' =>
                'Nomor Surat sudah terdaftar.',
            'no_surat.max' =>
                'Nomor Surat maksimal 255 karakter.',
            'tgl_surat.required' =>
                'Tanggal Surat wajib diisi.',
            'tgl_surat.date' =>
                'Format Tanggal Surat tidak valid.',
            'tgl_diterima.required' =>
                'Tanggal Diterima wajib diisi.',
            'tgl_diterima.date' =>
                'Format Tanggal Diterima tidak valid.',
            'tgl_diterima.after_or_equal' =>
                'Tanggal Diterima tidak boleh lebih kecil dari Tanggal Surat.',
            'instansi_id.required' =>
                'Instansi Pengirim wajib dipilih.',
            'instansi_id.exists' =>
                'Instansi Pengirim tidak ditemukan.',
            'perihal.required' =>
                'Perihal wajib diisi.',
            'perihal.max' =>
                'Perihal maksimal 255 karakter.',
            'lampiran.max' =>
            'Lampiran maksimal 255 karakter.',
            'file_surat.file' =>
            'File Surat tidak valid.',
            'file_surat.mimes' =>
            'File Surat harus berformat PDF.',
            'file_surat.max' =>
                'Ukuran File Surat maksimal 2 MB.',
            'keterangan.string' =>
                'Keterangan harus berupa teks.',
        ];

        // VALIDATOR
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // TRANSAKSI DATABASE
        DB::beginTransaction();

        $folder   = null;
        $namaFile = null;

        try {
            // FILE LAMA
            $fileLama = $surat->file_surat;

            // Default tetap menggunakan file lama
            $pathFile = $fileLama;

            // JIKA ADA FILE BARU
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');

                // Folder mengikuti storeSuratMasuk()
                $tahun  = now()->year;
                $folder = 'surat/masuk/' . $tahun;

                // Nama file mengikuti storeSuratMasuk()
                $namaFile = 'SM_' . now()->format('YmdHis') . '_' . Str::upper(Str::random(8)) . '.pdf';

                // Simpan file baru
                $file->storeAs($folder, $namaFile, 'public');

                // Path file baru
                $pathFile = $folder . '/' . $namaFile;
            }

            // UPDATE DATA SURAT
            $surat->update([

            'instansi_id' =>
                $request->instansi_id,

            'sifat_surat_id' =>
                $request->sifat_surat_id,

            'no_agenda' =>
                trim($request->no_agenda),

            'no_surat' =>
                trim($request->no_surat),

            'tgl_surat' =>
                $request->tgl_surat,

            'tgl_diterima' =>
                $request->tgl_diterima,

            'perihal' =>
                trim($request->perihal),

            'lampiran' =>
                $request->lampiran
                    ? trim($request->lampiran)
                    : null,

            'file_surat' =>
                $pathFile,

            'keterangan' =>
                $request->keterangan
                    ? trim($request->keterangan)
                    : null,
        ]);
            // HAPUS FILE LAMA
            // Dilakukan SETELAH database berhasil di-update
            // supaya lebih aman jika terjadi error database.

            if (
                $request->hasFile('file_surat') &&
                !empty($fileLama) &&
                Storage::disk('public')->exists($fileLama)
            ) {
                Storage::disk('public')->delete($fileLama);
            }

            // =====================================================
            // COMMIT
            // =====================================================
            DB::commit();

            // =====================================================
            // NOTIFIKASI
            // =====================================================
            Alert::success(
                'Berhasil',
                'Surat masuk berhasil diperbarui.'
            );

            return redirect()->route(
                'index.SuratMasuk'
            );
        } catch (\Exception $e) {

            // =====================================================
            // ROLLBACK DATABASE
            // =====================================================
            DB::rollBack();

            // =====================================================
            // HAPUS FILE BARU JIKA DATABASE GAGAL
            // =====================================================
            if (
                $namaFile &&
                $folder &&
                Storage::disk('public')->exists(
                    $folder . '/' . $namaFile
                )
            ) {
                Storage::disk('public')->delete(
                    $folder . '/' . $namaFile
                );
            }

            // =====================================================
            // LOG ERROR
            // =====================================================
            Log::error(
                'Update Surat Masuk Error',
                [
                'id'      => $id,
                'request' => $request->except('_token'),
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]
            );

            // =====================================================
            // NOTIFIKASI ERROR
            // =====================================================
            Alert::error(
                'Gagal',
                'Terjadi kesalahan saat memperbarui surat masuk.'
            );

            return redirect()
            ->back()
            ->withInput();
        }
    }

    public function deleteSuratMasuk(string $id)
    {
        DB::beginTransaction();

        try {
            // CARI DATA SURAT
            $surat = Suratmasuk::findOrFail($id);

            // Simpan path file sebelum data dihapus
            $fileSurat = $surat->file_surat;

            // HAPUS DATA DATABASE
            $surat->delete();

            // COMMIT DATABASE
            DB::commit();

            // HAPUS FILE PDF
            if (
                !empty($fileSurat) &&
                Storage::disk('public')->exists($fileSurat)
            ) {
                Storage::disk('public')->delete($fileSurat);
            }

            // NOTIFIKASI
            Alert::success('Berhasil', 'Surat masuk berhasil dihapus.');

            return redirect()->route('index.SuratMasuk');
        } catch (\Exception $e) {

            // ROLLBACK
            DB::rollBack();

            // LOG ERROR

            Log::error(
                'Delete Surat Masuk Error',
                [
                'id'      => $id,
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]
            );
            // NOTIFIKASI ERROR
            Alert::error(
                'Gagal',
                'Terjadi kesalahan saat menghapus surat masuk.'
            );

            return redirect()->back();
        }
    }

    // surat keluar
    public function indexSuratKeluar()
    {
        return view('dashboard.surat.suratkeluar.index');
    }

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

    public function previewSuratKeluar(string $id)
    {
        $surat = Suratkeluar::findOrFail($id);

        $path = storage_path('app/public/' . $surat->file_surat);

        if (!file_exists($path)) {
            abort(404, 'File surat tidak ditemukan.');
        }

        return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
    ]);
    }

    public function createSuratKeluar()
    {
        $sifatSurat = DB::table('sifatsurats')
            ->orderBy('nama_sifat')
            ->get();
        $jenisSuratKeluar = DB::table('jenissuratkeluars')->get();
        $instansi = Instansi::where('status', true)
            ->orderBy('nama_instansi')
            ->get();

        $agendaTerakhir = Suratkeluar::orderBy('created_at', 'desc')
            ->take(3)
            ->get(['no_agenda']);

        $dataPegawai = Pegawaipu::all();
        // return $dataPegawai;

        return view('dashboard.surat.suratkeluar.create', compact('jenisSuratKeluar', 'sifatSurat', 'instansi', 'agendaTerakhir', 'dataPegawai'));
    }

    public function storeSuratKeluar(Request $request)
    {
        // | VALIDATION RULES
        $rules = [

        // MASTER
        'jenis_suratkeluar_id' => [
            'required',
            'exists:jenissuratkeluars,id',
        ],

        'instansi_id' => [
            'required',
            'exists:instansis,id',
        ],

        'sifat_surat_id' => [
            'required',
            'exists:sifatsurats,id',
        ],


        // DATA SURAT
        'no_agenda' => [
            'required',
            'string',
            'max:100',
            'unique:suratkeluars,no_agenda',
        ],

        'no_surat' => [
            'required',
            'string',
            'max:100',
            'unique:suratkeluars,no_surat',
        ],

        'tgl_surat' => [
            'required',
            'date',
        ],

        'perihal' => [
            'required',
            'string',
            'max:255',
        ],

        'lampiran' => [
            'nullable',
            'string',
            'max:255',
        ],


        // SURAT TUGAS
        'jumlah_hari_tugas' => [
            'nullable',
            'string',
            'max:255',
            'required_if:jenis_suratkeluar_id,2,3',
        ],

        'tujuan_tugas' => [
            'nullable',
            'string',
            'max:255',
            'required_if:jenis_suratkeluar_id,2,3',
        ],

        'maksud_tujuan_tugas' => [
            'nullable',
            'string',
            'required_if:jenis_suratkeluar_id,2,3',
        ],

        'mulai_tugas' => [
            'nullable',
            'date',
            'required_if:jenis_suratkeluar_id,2,3',
        ],

        'selesai_tugas' => [
            'nullable',
            'date',
            'required_if:jenis_suratkeluar_id,2,3',
            'after_or_equal:mulai_tugas',
        ],


        // FILE
        'file_surat' => [
            'required',
            'file',
            'mimes:pdf',
            'max:2048',
        ],


        // PEGAWAI
        'pegawai' => [
            'nullable',
            'array',
        ],

       'pegawai.*.pegawaipu_id' => [
            'nullable',
            'exists:pegawaipus,id',
            'distinct',
        ],


        // KETERANGAN
        'keterangan' => [
            'nullable',
            'string',
        ],

    ];
        // | VALIDATION MESSAGE
        $messages = [

        'jenis_suratkeluar_id.required'
            => 'Jenis Surat Keluar wajib dipilih.',

        'jenis_suratkeluar_id.exists'
            => 'Jenis Surat Keluar tidak ditemukan.',


        'instansi_id.required'
            => 'Instansi Pengirim wajib dipilih.',

        'instansi_id.exists'
            => 'Instansi Pengirim tidak ditemukan.',


        'sifat_surat_id.required'
            => 'Sifat Surat wajib dipilih.',

        'sifat_surat_id.exists'
            => 'Sifat Surat tidak ditemukan.',


        'no_agenda.required'
            => 'Nomor Agenda wajib diisi.',

        'no_agenda.unique'
            => 'Nomor Agenda sudah digunakan.',


        'no_surat.required'
            => 'Nomor Surat wajib diisi.',

        'no_surat.unique'
            => 'Nomor Surat sudah terdaftar.',


        'tgl_surat.required'
            => 'Tanggal Surat wajib diisi.',


        'perihal.required'
            => 'Perihal wajib diisi.',


        'jumlah_hari_tugas.required_if'
            => 'Jumlah hari tugas wajib diisi.',


        'tujuan_tugas.required_if'
            => 'Tujuan tugas wajib diisi.',


        'maksud_tujuan_tugas.required_if'
            => 'Maksud tujuan tugas wajib diisi.',


        'mulai_tugas.required_if'
            => 'Tanggal mulai tugas wajib diisi.',


        'selesai_tugas.required_if'
            => 'Tanggal selesai tugas wajib diisi.',


        'selesai_tugas.after_or_equal'
            => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',


        'file_surat.required'
            => 'File surat wajib diupload.',

        'file_surat.mimes'
            => 'File harus PDF.',

        'file_surat.max'
            => 'Ukuran file maksimal 2 MB.',


        'pegawai.*.pegawaipu_id.required'
            => 'Pegawai wajib dipilih.',

        'pegawai.*.pegawaipu_id.exists'
            => 'Data pegawai tidak ditemukan.',

        'pegawai.*.pegawaipu_id.distinct'
            => 'Pegawai tidak boleh dipilih dua kali.',

    ];

        $validator = Validator::make(
            $request->all(),
            $rules,
            $messages
        );

        // | VALIDASI KHUSUS SURAT TUGAS
        $isSuratTugas = in_array(
            (string)$request->jenis_suratkeluar_id,
            ['2','3']
        );

        if ($isSuratTugas) {
            $validator->after(function ($validator) use ($request) {
                $pegawai = $request->input('pegawai', []);


                if (!is_array($pegawai) || count($pegawai) < 1) {
                    $validator->errors()->add(
                        'pegawai',
                        'Minimal pilih satu pegawai.'
                    );


                    return;
                }

                foreach ($pegawai as $index => $item) {
                    if (empty($item['pegawaipu_id'])) {
                        $validator->errors()->add(
                            "pegawai.$index.pegawaipu_id",
                            'Pegawai wajib dipilih.'
                        );
                    }
                }
            });
        }

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        }

        // | DATABASE TRANSACTION
        DB::beginTransaction();

        $folder = null;
        $namaFile = null;

        try {

            // | UPLOAD FILE
            $file = $request->file('file_surat');
            $folder = 'surat/keluar/'.now()->year;
            $namaFile =
            'SK_'
            .now()->format('YmdHis')
            .'_'
            .Str::upper(Str::random(8))
            .'.pdf';
            $file->storeAs(
                $folder,
                $namaFile,
                'public'
            );

            // | SIMPAN SURAT KELUAR
            $suratKeluar = Suratkeluar::create([
            'jenis_suratkeluar_id'
                => $request->jenis_suratkeluar_id,
            'instansi_id'
                => $request->instansi_id,
            'sifat_surat_id'
                => $request->sifat_surat_id,
            'no_agenda'
                => trim($request->no_agenda),
            'no_surat'
                => trim($request->no_surat),
            'tgl_surat'
                => $request->tgl_surat,
            'perihal'
                => trim($request->perihal),
            'lampiran'
                => $request->lampiran
                ? trim($request->lampiran)
                : null,

            // SURAT TUGAS

            'jumlah_hari_tugas'
                => $request->jumlah_hari_tugas
                ? trim($request->jumlah_hari_tugas)
                : null,

            'tujuan_tugas'
                => $request->tujuan_tugas
                ? trim($request->tujuan_tugas)
                : null,

            'maksud_tujuan_tugas'
                => $request->maksud_tujuan_tugas
                ? trim($request->maksud_tujuan_tugas)
                : null,

            'mulai_tugas'
                => $request->mulai_tugas ?: null,

            'selesai_tugas'
                => $request->selesai_tugas ?: null,

            'file_surat'
                => $folder.'/'.$namaFile,

            'keterangan'
                => $request->keterangan
                ? trim($request->keterangan)
                : null,

            'created_by'
                => Auth::id(),
        ]);

            // | SIMPAN PEGAWAI
            if ($isSuratTugas) {
                foreach (
                    $request->input('pegawai', []) as $pegawai
                ) {
                    Suratkeluarpegawai::create([
                    'suratkeluar_id'
                        => $suratKeluar->id,
                    'pegawaipu_id'
                        => $pegawai['pegawaipu_id'],
                ]);
                }
            }

            DB::commit();
            Alert::success('Berhasil', 'Surat keluar berhasil disimpan.');

            return redirect()->route('index.SuratKeluar');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($folder && $namaFile && Storage::disk('public')->exists($folder.'/'.$namaFile)
            ) {
                Storage::disk('public')->delete($folder.'/'.$namaFile);
            }

            Log::error(
                'Store Surat Keluar Error',
                [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request' => $request->except('_token'),
            ]
            );

            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan surat keluar.');

            return redirect()->back()->withInput();
        }
    }

    public function editSuratKeluar(string $id)
    {
        $suratKeluar = Suratkeluar::with([
            'jenisSuratKeluar',
            'sifatSurat',
            'instansi',
            'pegawai.pegawaiPu',
        ])->findOrFail($id);

        $sifatSurat = DB::table('sifatsurats')
            ->orderBy('nama_sifat')
            ->get();

        $jenisSuratKeluar = DB::table('jenissuratkeluars')
            ->orderBy('id')
            ->get();

        $instansi = Instansi::where('status', true)
            ->orderBy('nama_instansi')
            ->get();

        // Dropdown pegawai
        $dataPegawai = Pegawaipu::orderBy('nama')
            ->get();

        $agendaTerakhir = Suratkeluar::where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get([
                'no_agenda',
            ]);

        return view(
            'dashboard.surat.suratkeluar.edit',
            compact(
                'suratKeluar',
                'jenisSuratKeluar',
                'sifatSurat',
                'instansi',
                'dataPegawai',
                'agendaTerakhir'
            )
        );
    }

    public function updateSuratKeluar(Request $request, string $id)
    {
        // =========================================================
        // CARI DATA SURAT
        // =========================================================
        $surat = Suratkeluar::with(['pegawai.pegawaiPu',])
            ->findOrFail($id);

        // VALIDASI
        $rules = [
            // DATA SURAT
            'jenis_suratkeluar_id' => [
                'required',
                'exists:jenissuratkeluars,id',
            ],

            'sifat_surat_id' => [
                'required',
                'exists:sifatsurats,id',
            ],

            'no_agenda' => [
                'required',
                'string',
                'max:100',
                'unique:suratkeluars,no_agenda,' . $surat->id,
            ],

            'no_surat' => [
                'required',
                'string',
                'max:255',
                'unique:suratkeluars,no_surat,' . $surat->id,
            ],

            'tgl_surat' => [
                'required',
                'date',
            ],

            'instansi_id' => [
                'required',
                'exists:instansis,id',
            ],

            'perihal' => [
                'required',
                'string',
                'max:255',
            ],

            'lampiran' => [
                'nullable',
                'string',
                'max:255',
            ],


            // -----------------------------------------------------
            // DATA SURAT TUGAS
            // -----------------------------------------------------
            'jumlah_hari_tugas' => [
                'nullable',
                'string',
                'max:50',
            ],

            'tujuan_tugas' => [
                'nullable',
                'string',
                'max:255',
            ],

            'mulai_tugas' => [
                'nullable',
                'date',
            ],

            'selesai_tugas' => [
                'nullable',
                'date',
                'after_or_equal:mulai_tugas',
            ],

            'maksud_tujuan_tugas' => [
                'nullable',
                'string',
            ],

            // DATA PEGAWAI
            'pegawai' => [
                'nullable',
                'array',
            ],

            'pegawai.*.pegawaipu_id' => [
                'nullable',
                'exists:pegawaipus,id',
                'distinct',
            ],


            // -----------------------------------------------------
            // FILE
            // -----------------------------------------------------
            'file_surat' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:2048',
            ],


            // -----------------------------------------------------
            // KETERANGAN
            // -----------------------------------------------------
            'keterangan' => [
                'nullable',
                'string',
            ],
        ];


        // =========================================================
        // PESAN VALIDASI
        // =========================================================
        $messages = [

            // DATA SURAT
            'jenis_suratkeluar_id.required' =>
                'Jenis Surat Keluar wajib dipilih.',

            'jenis_suratkeluar_id.exists' =>
                'Jenis Surat Keluar tidak ditemukan.',

            'sifat_surat_id.required' =>
                'Sifat Surat wajib dipilih.',

            'sifat_surat_id.exists' =>
                'Sifat Surat tidak ditemukan.',

            'no_agenda.required' =>
                'Nomor Agenda wajib diisi.',

            'no_agenda.unique' =>
                'Nomor Agenda sudah digunakan. Silakan gunakan nomor agenda lain.',

            'no_agenda.max' =>
                'Nomor Agenda maksimal 100 karakter.',

            'no_surat.required' =>
                'Nomor Surat wajib diisi.',

            'no_surat.unique' =>
                'Nomor Surat sudah terdaftar.',

            'no_surat.max' =>
                'Nomor Surat maksimal 255 karakter.',

            'tgl_surat.required' =>
                'Tanggal Surat wajib diisi.',

            'tgl_surat.date' =>
                'Format Tanggal Surat tidak valid.',

            'instansi_id.required' =>
                'Instansi wajib dipilih.',

            'instansi_id.exists' =>
                'Instansi tidak ditemukan.',

            'perihal.required' =>
                'Perihal wajib diisi.',

            'perihal.max' =>
                'Perihal maksimal 255 karakter.',

            'lampiran.max' =>
                'Lampiran maksimal 255 karakter.',


            // DATA SURAT TUGAS
            'jumlah_hari_tugas.max' =>
                'Jumlah hari tugas maksimal 50 karakter.',

            'tujuan_tugas.max' =>
                'Tujuan tugas maksimal 255 karakter.',

            'mulai_tugas.date' =>
                'Format tanggal mulai tugas tidak valid.',

            'selesai_tugas.date' =>
                'Format tanggal selesai tugas tidak valid.',

            'selesai_tugas.after_or_equal' =>
                'Tanggal selesai tugas tidak boleh sebelum tanggal mulai tugas.',


            // PEGAWAI
            'pegawai.array' =>
                'Format data pegawai tidak valid.',

            'pegawai.*.nama.string' =>
                'Nama pegawai harus berupa teks.',

            'pegawai.*.nip.string' =>
                'NIP harus berupa teks.',

            'pegawai.*.jabatan.string' =>
                'Jabatan harus berupa teks.',


            // FILE
            'file_surat.file' =>
                'File Surat tidak valid.',

            'file_surat.mimes' =>
                'File Surat harus berformat PDF.',

            'file_surat.max' =>
                'Ukuran File Surat maksimal 2 MB.',


            // KETERANGAN
            'keterangan.string' =>
                'Keterangan harus berupa teks.',
        ];


        // =========================================================
        // VALIDATOR
        // =========================================================
        $validator = Validator::make(
            $request->all(),
            $rules,
            $messages
        );

        $isSuratTugas = in_array(
            (int)$request->jenis_suratkeluar_id,
            [2,3]
        );


        if ($isSuratTugas) {
            $validator->after(function ($validator) use ($request) {
                $pegawai = $request->input('pegawai', []);


                if (empty($pegawai)) {
                    $validator->errors()->add(
                        'pegawai',
                        'Pegawai yang ditugaskan wajib dipilih.'
                    );

                    return;
                }


                foreach ($pegawai as $index => $item) {
                    if (empty($item['pegawaipu_id'])) {
                        $validator->errors()->add(
                            "pegawai.$index.pegawaipu_id",
                            'Pegawai wajib dipilih.'
                        );
                    }
                }
            });
        }

        // =========================================================
        // VALIDASI GAGAL
        // =========================================================
        if ($validator->fails()) {
            dd($validator->errors());
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        // =========================================================
        // TRANSAKSI DATABASE
        // =========================================================
        DB::beginTransaction();

        $fileLama = $surat->file_surat;
        $pathFileBaru = null;


        try {

            // =====================================================
            // DEFAULT FILE
            // =====================================================
            $pathFile = $fileLama;


            // =====================================================
            // UPLOAD FILE BARU
            // =====================================================
            if ($request->hasFile('file_surat')) {
                $file = $request->file('file_surat');

                $tahun = now()->year;

                $folder = 'surat/keluar/' . $tahun;

                $namaFile =
                    'SK_' .
                    now()->format('YmdHis') .
                    '_' .
                    Str::upper(Str::random(8)) .
                    '.pdf';


                $pathFileBaru =
                    $folder . '/' . $namaFile;


                // Simpan file
                $tersimpan = $file->storeAs(
                    $folder,
                    $namaFile,
                    'public'
                );


                // Pastikan file benar-benar tersimpan
                if (!$tersimpan) {
                    throw new \Exception(
                        'File surat gagal disimpan.'
                    );
                }


                $pathFile = $pathFileBaru;
            }


            // =====================================================
            // UPDATE DATA SURAT
            // =====================================================
            $surat->update([

                'jenis_suratkeluar_id' =>
                    $request->jenis_suratkeluar_id,

                'instansi_id' =>
                    $request->instansi_id,

                'sifat_surat_id' =>
                    $request->sifat_surat_id,

                'no_agenda' =>
                    trim($request->no_agenda),

                'no_surat' =>
                    trim($request->no_surat),

                'tgl_surat' =>
                    $request->tgl_surat,

                'perihal' =>
                    trim($request->perihal),

                'lampiran' =>
                    $request->filled('lampiran')
                        ? trim($request->lampiran)
                        : null,

                'jumlah_hari_tugas' =>
                    $request->filled('jumlah_hari_tugas')
                        ? trim($request->jumlah_hari_tugas)
                        : null,

                'tujuan_tugas' =>
                    $request->filled('tujuan_tugas')
                        ? trim($request->tujuan_tugas)
                        : null,

                'mulai_tugas' =>
                    $request->filled('mulai_tugas')
                        ? $request->mulai_tugas
                        : null,

                'selesai_tugas' =>
                    $request->filled('selesai_tugas')
                        ? $request->selesai_tugas
                        : null,

                'maksud_tujuan_tugas' =>
                    $request->filled('maksud_tujuan_tugas')
                        ? trim($request->maksud_tujuan_tugas)
                        : null,

                'file_surat' =>
                    $pathFile,

                'keterangan' =>
                    $request->filled('keterangan')
                        ? trim($request->keterangan)
                        : null,
            ]);


            // =====================================================
            // DATA PEGAWAI
            // =====================================================

            // Hapus data pegawai lama terlebih dahulu
            $surat->pegawai()->delete();


            // Hanya jenis surat 2 dan 3 yang menggunakan pegawai
            if (
                in_array(
                    (int) $request->jenis_suratkeluar_id,
                    [2, 3]
                )
            ) {
                if ($request->has('pegawai')) {
                    foreach ($request->pegawai as $pegawai) {

                        // Lewati jika semua field kosong
                        if (
                            empty(trim($pegawai['nama'] ?? '')) &&
                            empty(trim($pegawai['nip'] ?? '')) &&
                            empty(trim($pegawai['jabatan'] ?? ''))
                        ) {
                            continue;
                        }


                        $surat->pegawai()->create([

                            'nama',
                            'nip',
                            'jabatan',
                        ]);
                    }
                }
            }


            // =====================================================
            // HAPUS FILE LAMA
            // =====================================================
            if (
                $request->hasFile('file_surat') &&
                !empty($fileLama) &&
                Storage::disk('public')->exists($fileLama)
            ) {
                Storage::disk('public')->delete($fileLama);
            }


            // =====================================================
            // COMMIT
            // =====================================================
            DB::commit();


            // =====================================================
            // NOTIFIKASI
            // =====================================================
            Alert::success(
                'Berhasil',
                'Surat keluar berhasil diperbarui.'
            );


            return redirect()->route(
                'index.SuratKeluar'
            );
        } catch (\Exception $e) {

            // =====================================================
            // ROLLBACK
            // =====================================================
            DB::rollBack();


            // =====================================================
            // HAPUS FILE BARU JIKA GAGAL
            // =====================================================
            if (
                !empty($pathFileBaru) &&
                Storage::disk('public')->exists($pathFileBaru)
            ) {
                Storage::disk('public')->delete(
                    $pathFileBaru
                );
            }


            // =====================================================
            // LOG ERROR
            // =====================================================
            Log::error(
                'Update Surat Keluar Error',
                [

                    'id' =>
                        $id,

                    'request' =>
                        $request->except([
                            '_token',
                            'file_surat',
                        ]),

                    'message' =>
                        $e->getMessage(),

                    'file' =>
                        $e->getFile(),

                    'line' =>
                        $e->getLine(),
                ]
            );


            // =====================================================
            // NOTIFIKASI
            // =====================================================
            Alert::error(
                'Gagal',
                'Terjadi kesalahan saat memperbarui surat keluar.'
            );


            return redirect()
                ->back()
                ->withInput();
        }
    }

    public function deleteSuratKeluar(string $id)
    {
        // TRANSAKSI DATABASE
        DB::beginTransaction();
        try {
            // CARI DATA SURAT KELUAR BESERTA PEGAWAI
            $surat = Suratkeluar::with('pegawai')->findOrFail($id);

            // SIMPAN PATH FILE PDF
            $fileSurat = $surat->file_surat;

            // HAPUS DATA PEGAWAI
            // Karena surat keluar memiliki relasi pegawai,
            // data pegawai yang terkait harus dihapus terlebih dahulu.

            $surat->pegawai()->delete();
            // HAPUS DATA SURAT KELUAR

            $surat->delete();
            // COMMIT DATABASE

            DB::commit();
            // HAPUS FILE PDF
            if (
                !empty($fileSurat) &&
                Storage::disk('public')->exists($fileSurat)
            ) {
                Storage::disk('public')->delete($fileSurat);
            }

            // NOTIFIKASI BERHASIL
            Alert::success('Berhasil', 'Surat keluar berhasil dihapus.');

            // REDIRECT
            return redirect()->route('index.SuratKeluar');
        } catch (\Exception $e) {
            // ROLLBACK DATABASE
            DB::rollBack();

            // LOG ERROR
            Log::error(
                'Delete Surat Keluar Error',
                [
                    'id' =>
                        $id,

                    'message' =>
                        $e->getMessage(),

                    'file' =>
                        $e->getFile(),

                    'line' =>
                        $e->getLine(),
                ]
            );


            // =====================================================
            // NOTIFIKASI ERROR
            // =====================================================
            Alert::error(
                'Gagal',
                'Terjadi kesalahan saat menghapus surat keluar.'
            );


            // =====================================================
            // KEMBALI
            // =====================================================
            return redirect()
                ->back();
        }
    }

    //Agenda Surat Masuk
    public function indexAgendaSuratMasuk()
    {
        $sifatSurat = DB::table('sifatsurats')->get();
        $instansiview = DB::table('instansis')->get();

        return view('dashboard.laporan.agendasuratmasuk.index', compact('sifatSurat', 'instansiview'));
    }

    public function getAgendaSuratMasuk(Request $request)
    {
        $query = Suratmasuk::with([
            'sifatSurat',
            'instansi',
        ]);

        // =====================================================
        // FILTER TANGGAL DITERIMA
        // =====================================================

        if ($request->filled('tgl_awal')) {
            $query->whereDate(
                'tgl_diterima',
                '>=',
                $request->tgl_awal
            );
        }

        if ($request->filled('tgl_akhir')) {
            $query->whereDate(
                'tgl_diterima',
                '<=',
                $request->tgl_akhir
            );
        }


        // =====================================================
        // FILTER TANGGAL SURAT
        // =====================================================

        if ($request->filled('tgl_surat')) {
            $query->whereDate(
                'tgl_surat',
                $request->tgl_surat
            );
        }


        // =====================================================
        // FILTER SIFAT SURAT
        // =====================================================

        if ($request->filled('sifat_surat')) {
            $query->where(
                'sifat_surat_id',
                $request->sifat_surat
            );
        }


        // =====================================================
        // FILTER INSTANSI
        // =====================================================

        if ($request->filled('instansi_id')) {
            $query->where(
                'instansi_id',
                $request->instansi_id
            );
        }


        // =====================================================
        // URUTKAN NO AGENDA
        // =====================================================

        $query->orderByRaw("
            CAST(
                SUBSTRING_INDEX(no_agenda, '/', 1)
                AS UNSIGNED
            ) ASC
        ");


        // =====================================================
        // DATATABLE
        // =====================================================

        return DataTables::of($query)

            ->addIndexColumn()


            // =================================================
            // NO AGENDA
            // =================================================

            ->editColumn('no_agenda', function ($row) {
                return $row->no_agenda ?? '-';
            })


            // =================================================
            // TANGGAL DITERIMA
            // =================================================

            ->editColumn('tgl_diterima', function ($row) {
                if (!$row->tgl_diterima) {
                    return '-';
                }

                return Carbon::parse($row->tgl_diterima)
                    ->locale('id')
                    ->translatedFormat('d F Y');
            })


            // =================================================
            // SIFAT SURAT
            // =================================================

            ->editColumn('sifat_surat', function ($row) {
                return optional(
                    $row->sifatSurat
                )->nama_sifat ?? '-';
            })


            // =================================================
            // NO SURAT + TANGGAL SURAT
            // =================================================

            ->editColumn('no_surat', function ($row) {
                $noSurat = e(
                    $row->no_surat ?? '-'
                );

                $tglSurat = '-';

                if ($row->tgl_surat) {
                    $tglSurat = Carbon::parse(
                        $row->tgl_surat
                    )
                        ->locale('id')
                        ->translatedFormat('d F Y');
                }

                return '
                    <div>
                        <strong>' . $noSurat . '</strong>
                        <br>
                        <small class="text-muted">
                            ' . $tglSurat . '
                        </small>
                    </div>
                ';
            })


            // =================================================
            // INSTANSI / PENGIRIM
            // =================================================

            ->addColumn('instansi', function ($row) {
                return optional(
                    $row->instansi
                )->nama_instansi ?? '-';
            })


            // =================================================
            // PERIHAL
            // =================================================

            ->editColumn('perihal', function ($row) {
                return e(
                    $row->perihal ?? '-'
                );
            })


            // =================================================
            // LIHAT FILE
            // =================================================

            ->addColumn('lihatsurat', function ($row) {
                return view(
                    'dashboard.laporan.agendasuratmasuk.lihatsurat',
                    compact('row')
                );
            })


            ->rawColumns([
                'no_surat',
                'lihatsurat',
            ])

            ->make(true);
    }


    public function downloadAgendaSuratMasuk(Request $request)
    {
        return Excel::download(
            new AgendaSuratMasukExport(
                $request->tgl_awal,
                $request->tgl_akhir,
                $request->tgl_surat,
                $request->sifat_surat,
                $request->instansi_id
            ),
            'Laporan_Agenda_Surat_Masuk_' .
            now()->format('Y-m-d_H-i-s') .
            '.xlsx'
        );
    }

    // Ekpedisi Surat Keluar
    public function indexEkspedisiSuratKeluar()
    {
        $jenisSuratKeluar = DB::table('jenissuratkeluars')->get();
        $sifatSurat = DB::table('sifatsurats')->get();
        $instansiview = DB::table('instansis')->get();

        return view(
            'dashboard.laporan.ekspedisisuratkeluar.index',
            compact(
                'jenisSuratKeluar',
                'sifatSurat',
                'instansiview'
            )
        );
    }

    public function getEkspedisiSuratKeluar(Request $request)
    {
        $query = Suratkeluar::with([
            'sifatSurat',
            'instansi',
            'jenisSuratKeluar',
            'pegawai',
        ]);

        // =====================================================
        // FILTER TANGGAL SURAT AWAL
        // =====================================================

        if ($request->filled('tgl_awal')) {
            $query->whereDate(
                'tgl_surat',
                '>=',
                $request->tgl_awal
            );
        }

        // =====================================================
        // FILTER TANGGAL SURAT AKHIR
        // =====================================================

        if ($request->filled('tgl_akhir')) {
            $query->whereDate(
                'tgl_surat',
                '<=',
                $request->tgl_akhir
            );
        }

        // =====================================================
        // FILTER TANGGAL SURAT
        // =====================================================

        if ($request->filled('tgl_surat')) {
            $query->whereDate(
                'tgl_surat',
                $request->tgl_surat
            );
        }

        // =====================================================
        // FILTER JENIS SURAT KELUAR
        // =====================================================

        if ($request->filled('jenis_suratkeluar_id')) {
            $query->where(
                'jenis_suratkeluar_id',
                $request->jenis_suratkeluar_id
            );
        }

        // =====================================================
        // FILTER SIFAT SURAT
        // =====================================================

        if ($request->filled('sifat_surat')) {
            $query->where(
                'sifat_surat_id',
                $request->sifat_surat
            );
        }

        // =====================================================
        // FILTER INSTANSI / TUJUAN
        // =====================================================

        if ($request->filled('instansi_id')) {
            $query->where(
                'instansi_id',
                $request->instansi_id
            );
        }

        // =====================================================
        // URUTKAN NO AGENDA
        // =====================================================

        $query->orderByRaw("
        CAST(
            SUBSTRING_INDEX(no_agenda, '/', 1)
            AS UNSIGNED
        ) ASC
    ");

        // DATATABLE
        return DataTables::of($query)

            ->addIndexColumn()

            // =================================================
            // NO AGENDA
            // =================================================

            ->editColumn('no_agenda', function ($row) {
                return $row->no_agenda ?: '-';
            })

            // =================================================
            // TANGGAL SURAT
            // =================================================

            ->editColumn('tgl_surat', function ($row) {

                if (!$row->tgl_surat) {
                    return '-';
                }

                return Carbon::parse($row->tgl_surat)
                    ->locale('id')
                    ->translatedFormat('d F Y');
            })

            // =================================================
            // JENIS SURAT
            // =================================================

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

            // =================================================
            // SIFAT SURAT
            // =================================================

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

            // =================================================
            // NO SURAT
            // =================================================

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

            // =================================================
            // INSTANSI / TUJUAN SURAT
            // =================================================

          ->addColumn('instansi', function ($row) {
              return optional($row->instansi)
                  ->nama_instansi ?? '-';
          })

            // =================================================
            // PERIHAL
            // =================================================

            ->editColumn('perihal', function ($row) {

                return e(
                    $row->perihal ?? '-'
                );
            })

            // =================================================
            // LAMPIRAN
            // =================================================

            ->addColumn('lampiran', function ($row) {
                return !empty($row->lampiran)
                    ? e($row->lampiran)
                    : '-';
            })

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

            // =================================================
            // LIHAT SURAT
            // =================================================

            ->addColumn('lihatsurat', function ($row) {

                return view(
                    'dashboard.laporan.ekspedisisuratkeluar.lihatsurat',
                    compact('row')
                );
            })

            // =================================================
            // RAW HTML
            // =================================================

            ->rawColumns([
                'no_surat',
                'lihatsurat',
                'detail_tugas',
                'jenis_suratkeluar',
                'sifat_surat',
            ])

            ->make(true);
    }

    public function downloadEkspedisiSuratKeluar(Request $request)
    {
        return Excel::download(
            new EkspedisiSuratKeluarExport(
                $request->tgl_awal,
                $request->tgl_akhir,
                $request->tgl_surat,
                $request->jenis_suratkeluar_id,
                $request->sifat_surat,
                $request->instansi_id
            ),
            'Laporan_Ekspedisi_Surat_Keluar_' .
            now()->format('Y-m-d_H-i-s') .
            '.xlsx'
        );
    }




    // Arsip Digital
    public function indexArsipDigital()
    {
        $instansi = Instansi::orderBy('nama_instansi')
            ->get();

        return view('dashboard.laporan.arsipsuratdigital.index', compact('instansi'));
    }

    public function getArsipDigital(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | SURAT MASUK
        |--------------------------------------------------------------------------
        */

        if ($request->jenis_surat == 'masuk') {
            $arsip = Suratmasuk::with([
                'instansi',
                'sifatSurat',
            ])

            ->when($request->nomor_surat, function ($q) use ($request) {
                $q->where(
                    'no_surat',
                    'like',
                    '%' . $request->nomor_surat . '%'
                );
            })

            ->when($request->tgl_surat, function ($q) use ($request) {
                $q->whereDate(
                    'tgl_surat',
                    $request->tgl_surat
                );
            })

            ->when($request->perihal, function ($q) use ($request) {
                $q->where(
                    'perihal',
                    'like',
                    '%' . $request->perihal . '%'
                );
            })

            ->when($request->instansi_id, function ($q) use ($request) {
                $q->where(
                    'instansi_id',
                    $request->instansi_id
                );
            })

            ->latest()
            ->get()

            ->map(function ($item) {
                $item->jenis_surat = 'masuk';

                $item->tgl_surat = $item->tgl_surat
                    ? Carbon::parse($item->tgl_surat)
                        ->locale('id')
                        ->translatedFormat('d F Y')
                    : '-';

                return $item;
            });
        }


        /*
        |--------------------------------------------------------------------------
        | SURAT KELUAR
        |--------------------------------------------------------------------------
        */ else {
            $arsip = Suratkeluar::with([
                'instansi',
                'sifatSurat',
                'jenisSuratKeluar',
                'pegawai',
            ])

            ->when($request->nomor_surat, function ($q) use ($request) {
                $q->where(
                    'no_surat',
                    'like',
                    '%' . $request->nomor_surat . '%'
                );
            })

            ->when($request->tgl_surat, function ($q) use ($request) {
                $q->whereDate(
                    'tgl_surat',
                    $request->tgl_surat
                );
            })

            ->when($request->perihal, function ($q) use ($request) {
                $q->where(
                    'perihal',
                    'like',
                    '%' . $request->perihal . '%'
                );
            })

            ->when($request->instansi_id, function ($q) use ($request) {
                $q->where(
                    'instansi_id',
                    $request->instansi_id
                );
            })

            ->latest()
            ->get()

            ->map(function ($item) {
                $item->jenis_surat = 'keluar';

                $item->tgl_surat = $item->tgl_surat
                    ? Carbon::parse($item->tgl_surat)
                        ->locale('id')
                        ->translatedFormat('d F Y')
                    : '-';

                return $item;
            });
        }


        return response()->json($arsip);
    }

    public function detailArsipDigital(string $id)
    {
        $surat = Suratmasuk::findOrFail($id);

        // ==============================
        // SURAT MASUK
        // ==============================
        if ($surat->jenis_surat === 'masuk') {
            $surat->load([
                'instansi',
                'sifatSurat',
            ]);
        }

        // ==============================
        // SURAT KELUAR
        // ==============================
        elseif ($surat->jenis_surat === 'keluar') {
            $surat->load([
                'jenisSuratKeluar',
                'pegawai',
            ]);
        }

        return response()->json($surat);
    }

    // disposisi surat masuk
    public function indexDisposisiSuratMasuk()
    {
        $sifatSurat = DB::table('sifatsurats')->get();
        $instansiview = DB::table('instansis')->get();

        return view('dashboard.disposisi.index', compact('sifatSurat', 'instansiview'));
    }

    public function getDisposisiSuratMasuk(Request $request)
    {
        $query = SuratMasuk::with([
            'sifatSurat',
            'instansi',
            'disposisis',
        ]);

        // TANGGAL DITERIMA
        if ($request->filled('tgl_awal')) {
            $query->whereDate('tgl_diterima', '>=', $request->tgl_awal);
        }

        if ($request->filled('tgl_akhir')) {
            $query->whereDate('tgl_diterima', '<=', $request->tgl_akhir);
        }

        // TANGGAL SURAT
        if ($request->filled('tgl_surat')) {
            $query->whereDate('tgl_surat', $request->tgl_surat);
        }

        // SIFAT SURAT
        if ($request->filled('sifat_surat')) {
            $query->where(
                'sifatsurat_id',
                $request->sifat_surat
            );
        }

        // INSTANSI
        if ($request->filled('instansi_id')) {
            $query->where(
                'instansi_id',
                $request->instansi_id
            );
        }

        // STATUS DISPOSISI
        if ($request->filled('status_disposisi')) {

            if ($request->status_disposisi === 'belum_disposisi') {

                $query->whereDoesntHave('disposisis');

            } else {

                $query->whereHas('disposisis', function ($q) use ($request) {
                    $q->where('status', $request->status_disposisi);
                });
            }
        }

        $query->orderBy('tgl_diterima', 'desc');

        return DataTables::of($query)

            ->addIndexColumn()

            // NO AGENDA
            ->editColumn('no_agenda', function ($row) {
                return $row->no_agenda ?? '-';
            })

            // TANGGAL DITERIMA
            ->editColumn('tgl_diterima', function ($row) {

                if (!$row->tgl_diterima) {
                    return '-';
                }

                return Carbon::parse($row->tgl_diterima)
                    ->locale('id')
                    ->translatedFormat('d F Y');
            })

            // NO & TANGGAL SURAT
            ->addColumn('no_surat', function ($row) {

                return '
                <div class="text-start">
                    <small>
                        <b>No. Surat</b> :
                        ' . e($row->no_surat ?? '-') . '
                    </small>

                    <br>

                    <small>
                        <b>Tanggal</b> :
                        ' . (
                    $row->tgl_surat
                                    ? Carbon::parse($row->tgl_surat)
                                        ->locale('id')
                                        ->translatedFormat('d F Y')
                                    : '-'
                ) . '
                    </small>
                </div>
            ';
            })

            // SIFAT SURAT
            ->addColumn('sifat_surat', function ($row) {

                return $row->sifatSurat->nama_sifat
                    ?? '-';
            })

            // INSTANSI / PENGIRIM
            ->addColumn('instansi', function ($row) {

                return $row->instansi->nama_instansi
                    ?? '-';
            })

            // PERIHAL
            ->editColumn('perihal', function ($row) {
                return $row->perihal ?? '-';
            })

            // STATUS DISPOSISI
            ->addColumn('status_disposisi', function ($row) {

                $disposisi = $row->disposisis
                    ->sortByDesc('tgl_dikirim')
                    ->first();

                if (!$disposisi) {
                    return '
                    <span class="badge bg-secondary">
                        Belum Disposisi
                    </span>
                ';
                }

                switch ($disposisi->status) {

                    case 'dikirim':
                        $class = 'bg-info';
                        $label = 'Menunggu Diterima';
                        break;

                    case 'diterima':
                        $class = 'bg-primary';
                        $label = 'Sudah Diterima';
                        break;

                    case 'diteruskan':
                        $class = 'bg-warning text-dark';
                        $label = 'Sedang Diteruskan';
                        break;

                    case 'selesai':
                        $class = 'bg-success';
                        $label = 'Selesai';
                        break;

                    default:
                        $class = 'bg-secondary';
                        $label = '-';
                }

                return '
                <span class="badge ' . $class . '">
                    ' . e($label) . '
                </span>
            ';
            })

            // AKSI
            ->addColumn('aksi', function ($row) {

                return view(
                    'dashboard.disposisi.aksi',
                    compact('row')
                );
            })

            ->rawColumns([
                'no_surat',
                'status_disposisi',
                'aksi',
            ])

            ->make(true);
    }

    public function detailsmDisposisi(string $id)
    {
        $suratMasuk = SuratMasuk::with([
            'sifatSurat',
            'instansi',
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $suratMasuk->id,
                'no_agenda' => $suratMasuk->no_agenda ?? '-',
                'tgl_diterima' => $suratMasuk->tgl_diterima ?? '-',
                'no_surat' => $suratMasuk->no_surat ?? '-',
                'tgl_surat' => $suratMasuk->tgl_surat ?? '-',
                'sifat_surat' => $suratMasuk->sifatSurat->nama_sifat ?? '-',
                'instansi' => $suratMasuk->instansi->nama_instansi ?? '-',
                'perihal' => $suratMasuk->perihal ?? '-',
                'file_surat' => $suratMasuk->file_surat
                    ? asset('storage/' . $suratMasuk->file_surat)
                    : null,
            ],
        ]);
    }

    public function createDisposisiSuratMasuk(string $id)
    {
        $suratMasuk = SuratMasuk::with([
            'sifatSurat',
            'instansi',
        ])->findOrFail($id);

        $pegawai = PegawaiPu::orderBy('nama')->get();

        return view(
            'dashboard.disposisi.create',
            compact('suratMasuk', 'pegawai')
        );
    }
}
