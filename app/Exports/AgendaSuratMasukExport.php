<?php

namespace App\Exports;

use App\Models\Suratmasuk;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AgendaSuratMasukExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithCustomStartCell,
    WithEvents
{
    protected $tgl_awal;
    protected $tgl_akhir;
    protected $tgl_surat;
    protected $sifat_surat;
    protected $instansi_id;

    public function __construct(
        $tgl_awal = null,
        $tgl_akhir = null,
        $tgl_surat = null,
        $sifat_surat = null,
        $instansi_id = null
    ) {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
        $this->tgl_surat = $tgl_surat;
        $this->sifat_surat = $sifat_surat;
        $this->instansi_id = $instansi_id;
    }

    /*
    |--------------------------------------------------------------------------
    | POSISI AWAL TABEL
    |--------------------------------------------------------------------------
    |
    | Baris 1 = Judul
    | Baris 2 = Nama Instansi
    | Baris 3 = Periode
    | Baris 4 = Waktu Download
    | Baris 5 = Kosong
    | Baris 6 = Header Tabel
    |
    */

    public function startCell(): string
    {
        return 'A6';
    }

    /*
    |--------------------------------------------------------------------------
    | DATA SURAT MASUK
    |--------------------------------------------------------------------------
    */

    public function collection()
    {
        $query = Suratmasuk::with([
            'sifatSurat',
            'instansi',
        ]);

        /*
        |--------------------------------------------------------------------------
        | TANGGAL DITERIMA - AWAL
        |--------------------------------------------------------------------------
        */

        if ($this->tgl_awal) {
            $query->whereDate(
                'tgl_diterima',
                '>=',
                $this->tgl_awal
            );
        }

        /*
        |--------------------------------------------------------------------------
        | TANGGAL DITERIMA - AKHIR
        |--------------------------------------------------------------------------
        */

        if ($this->tgl_akhir) {
            $query->whereDate(
                'tgl_diterima',
                '<=',
                $this->tgl_akhir
            );
        }

        /*
        |--------------------------------------------------------------------------
        | TANGGAL SURAT
        |--------------------------------------------------------------------------
        */

        if ($this->tgl_surat) {
            $query->whereDate(
                'tgl_surat',
                '<=',
                $this->tgl_surat
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SIFAT SURAT
        |--------------------------------------------------------------------------
        */

        if ($this->sifat_surat) {
            $query->where(
                'sifat_surat_id',
                $this->sifat_surat
            );
        }

        /*
        |--------------------------------------------------------------------------
        | INSTANSI
        |--------------------------------------------------------------------------
        */

        if ($this->instansi_id) {
            $query->where(
                'instansi_id',
                $this->instansi_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | URUTKAN NO AGENDA
        |--------------------------------------------------------------------------
        */

        return $query
            ->orderByRaw("
                CAST(
                    SUBSTRING_INDEX(no_agenda, '/', 1)
                    AS UNSIGNED
                ) ASC
            ")
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | HEADER TABEL
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        return [
            'No',
            'No. Agenda',
            'Tanggal Terima',
            'No. Surat',
            'Tanggal Surat',
            'Sifat Surat',
            'Pengirim',
            'Perihal',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | MAPPING DATA
    |--------------------------------------------------------------------------
    */

    public function map($surat): array
    {
        static $no = 0;

        $no++;

        return [

            $no,

            $surat->no_agenda ?? '-',

            $surat->tgl_diterima
                ? Carbon::parse($surat->tgl_diterima)
                    ->locale('id')
                    ->translatedFormat('d F Y')
                : '-',

            $surat->no_surat ?? '-',

            $surat->tgl_surat
                ? Carbon::parse($surat->tgl_surat)
                    ->locale('id')
                    ->translatedFormat('d F Y')
                : '-',

            optional($surat->sifatSurat)->nama_sifat ?? '-',

            optional($surat->instansi)->nama_instansi ?? '-',

            $surat->perihal ?? '-',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | EVENT EXCEL
    |--------------------------------------------------------------------------
    */

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /*
                |--------------------------------------------------------------------------
                | JUDUL
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A1:H1');

                $sheet->setCellValue(
                    'A1',
                    'LAPORAN AGENDA SURAT MASUK'
                );

                /*
                |--------------------------------------------------------------------------
                | NAMA INSTANSI
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A2:H2');

                $sheet->setCellValue(
                    'A2',
                    'BKPSDM Kabupaten Ogan Komering Ilir'
                );

                /*
                |--------------------------------------------------------------------------
                | PERIODE
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A3:H3');

                if ($this->tgl_awal && $this->tgl_akhir) {

                    $periode =
                        'Periode: ' .
                        Carbon::parse($this->tgl_awal)
                            ->locale('id')
                            ->translatedFormat('d F Y') .
                        ' s.d. ' .
                        Carbon::parse($this->tgl_akhir)
                            ->locale('id')
                            ->translatedFormat('d F Y');

                } elseif ($this->tgl_awal) {

                    $periode =
                        'Periode mulai: ' .
                        Carbon::parse($this->tgl_awal)
                            ->locale('id')
                            ->translatedFormat('d F Y');

                } elseif ($this->tgl_akhir) {

                    $periode =
                        'Periode sampai: ' .
                        Carbon::parse($this->tgl_akhir)
                            ->locale('id')
                            ->translatedFormat('d F Y');

                } else {

                    $periode = 'Periode: Semua Data';
                }

                $sheet->setCellValue(
                    'A3',
                    $periode
                );

                /*
                |--------------------------------------------------------------------------
                | TANGGAL DAN WAKTU DOWNLOAD
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A4:H4');

                $tanggalDownload = Carbon::now()
                    ->locale('id')
                    ->translatedFormat('d F Y, H:i');

                $sheet->setCellValue(
                    'A4',
                    'Diunduh: ' . $tanggalDownload . ' WIB'
                );

                /*
                |--------------------------------------------------------------------------
                | STYLE JUDUL
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1')->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],

                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],

                ]);

                /*
                |--------------------------------------------------------------------------
                | STYLE NAMA INSTANSI
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A2')->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],

                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],

                ]);

                /*
                |--------------------------------------------------------------------------
                | STYLE PERIODE
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A3')->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'size' => 11,
                    ],

                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],

                ]);

                /*
                |--------------------------------------------------------------------------
                | STYLE WAKTU DOWNLOAD
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A4')->applyFromArray([

                    'font' => [
                        'italic' => true,
                        'size' => 10,
                    ],

                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],

                ]);

                /*
                |--------------------------------------------------------------------------
                | STYLE HEADER TABEL
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A6:H6')->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'size' => 11,
                    ],

                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],

                    'borders' => [
                        'allBorders' => [
                            'borderStyle' =>
                                \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],

                ]);

                /*
                |--------------------------------------------------------------------------
                | DATA TABEL
                |--------------------------------------------------------------------------
                */

                $highestRow = $sheet->getHighestRow();

                if ($highestRow >= 7) {

                    $sheet->getStyle(
                        'A7:H' . $highestRow
                    )->applyFromArray([

                        'alignment' => [
                            'vertical' => 'center',
                        ],

                        'borders' => [
                            'allBorders' => [
                                'borderStyle' =>
                                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],

                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | RATA TENGAH
                    |--------------------------------------------------------------------------
                    */

                    $sheet->getStyle(
                        'A7:A' . $highestRow
                    )->getAlignment()
                        ->setHorizontal('center');

                    $sheet->getStyle(
                        'B7:C' . $highestRow
                    )->getAlignment()
                        ->setHorizontal('center');

                    $sheet->getStyle(
                        'E7:F' . $highestRow
                    )->getAlignment()
                        ->setHorizontal('center');
                }

                /*
                |--------------------------------------------------------------------------
                | TINGGI BARIS
                |--------------------------------------------------------------------------
                */

                $sheet->getRowDimension(1)
                    ->setRowHeight(30);

                $sheet->getRowDimension(2)
                    ->setRowHeight(22);

                $sheet->getRowDimension(3)
                    ->setRowHeight(20);

                $sheet->getRowDimension(4)
                    ->setRowHeight(20);

                $sheet->getRowDimension(6)
                    ->setRowHeight(25);

                /*
                |--------------------------------------------------------------------------
                | LEBAR KOLOM
                |--------------------------------------------------------------------------
                */

                $sheet->getColumnDimension('A')
                    ->setWidth(8);

                $sheet->getColumnDimension('B')
                    ->setWidth(18);

                $sheet->getColumnDimension('C')
                    ->setWidth(20);

                $sheet->getColumnDimension('D')
                    ->setWidth(30);

                $sheet->getColumnDimension('E')
                    ->setWidth(20);

                $sheet->getColumnDimension('F')
                    ->setWidth(20);

                $sheet->getColumnDimension('G')
                    ->setWidth(35);

                $sheet->getColumnDimension('H')
                    ->setWidth(45);

                /*
                |--------------------------------------------------------------------------
                | WRAP TEXT
                |--------------------------------------------------------------------------
                */

                if ($highestRow >= 7) {

                    $sheet->getStyle(
                        'A6:H' . $highestRow
                    )->getAlignment()
                        ->setWrapText(true);
                }

                /*
                |--------------------------------------------------------------------------
                | FREEZE HEADER
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane('A7');

            },
        ];
    }
}
