<?php

namespace App\Exports;

use App\Models\Suratkeluar;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class EkspedisiSuratKeluarExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithCustomStartCell,
    WithEvents
{
    protected $tgl_awal;
    protected $tgl_akhir;
    protected $tgl_surat;
    protected $jenis_suratkeluar_id;
    protected $sifat_surat;
    protected $instansi_id;

    public function __construct(
        $tgl_awal = null,
        $tgl_akhir = null,
        $tgl_surat = null,
        $jenis_suratkeluar_id = null,
        $sifat_surat = null,
        $instansi_id = null
    ) {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
        $this->tgl_surat = $tgl_surat;
        $this->jenis_suratkeluar_id = $jenis_suratkeluar_id;
        $this->sifat_surat = $sifat_surat;
        $this->instansi_id = $instansi_id;
    }

    /**
     * Posisi header tabel.
     *
     * Baris 1 = Judul
     * Baris 2 = Instansi
     * Baris 3 = Periode
     * Baris 4 = Waktu download
     * Baris 5 = Kosong
     * Baris 6 = Header tabel
     */
    public function startCell(): string
    {
        return 'A6';
    }

    /**
     * Ambil data berdasarkan filter halaman.
     */
    public function collection()
    {
        $query = Suratkeluar::with([
            'sifatSurat',
            'instansi',
            'jenisSuratKeluar',
            'pegawai',
        ]);

        // Tanggal surat awal
        if ($this->tgl_awal) {
            $query->whereDate(
                'tgl_surat',
                '>=',
                $this->tgl_awal
            );
        }

        // Tanggal surat akhir
        if ($this->tgl_akhir) {
            $query->whereDate(
                'tgl_surat',
                '<=',
                $this->tgl_akhir
            );
        }

        // Tanggal surat tertentu
        if ($this->tgl_surat) {
            $query->whereDate(
                'tgl_surat',
                $this->tgl_surat
            );
        }

        // Jenis surat keluar
        if ($this->jenis_suratkeluar_id) {
            $query->where(
                'jenis_suratkeluar_id',
                $this->jenis_suratkeluar_id
            );
        }

        // Sifat surat
        if ($this->sifat_surat) {
            $query->where(
                'sifat_surat_id',
                $this->sifat_surat
            );
        }

        // Instansi / tujuan
        if ($this->instansi_id) {
            $query->where(
                'instansi_id',
                $this->instansi_id
            );
        }

        // Urutkan berdasarkan nomor agenda
        $query->orderByRaw("
            CAST(
                SUBSTRING_INDEX(no_agenda, '/', 1)
                AS UNSIGNED
            ) ASC
        ");

        return $query->get();
    }

    /**
     * Header Excel.
     */
    public function headings(): array
    {
        return [
            'No',
            'No. Agenda',
            'Jenis Surat Keluar',
            'Detail Surat Tugas dan Surat Perintah Tugas',
            'No. & Tgl. Surat Keluar',
            'Sifat Surat',
            'Lampiran',
            'Tujuan',
            'Perihal',
        ];
    }

    /**
     * Mapping data ke Excel.
     */
    public function map($surat): array
    {
        static $no = 0;

        $no++;

        /*
         * ==========================================================
         * JENIS SURAT
         * ==========================================================
         */

        $jenisSurat = optional(
            $surat->jenisSuratKeluar
        )->jenis_suratkeluar ?? '-';


        /*
         * ==========================================================
         * DETAIL SURAT TUGAS / SPT
         * ==========================================================
         */

        $detailTugas = '-';

        if (
            in_array(
                (int) $surat->jenis_suratkeluar_id,
                [2, 3]
            )
        ) {
            $detail = [];

            /*
             * Pegawai yang ditugaskan
             */
            if (
                $surat->pegawai &&
                $surat->pegawai->count() > 0
            ) {
                $detail[] = 'PEGAWAI DITUGASKAN';

                foreach (
                    $surat->pegawai as $index => $pegawai
                ) {
                    if ($pegawai->pegawaiPu) {

                        $detail[] =
                            ($index + 1) .
                            '. ' .
                            ($pegawai->pegawaiPu->nama ?? '-');

                        $detail[] =
                            'NIP: ' .
                            ($pegawai->pegawaiPu->nip ?? '-');

                        $detail[] =
                            'Jabatan: ' .
                            ($pegawai->pegawaiPu->jabatan ?? '-');
                    }
                }
            } else {
                $detail[] = 'PEGAWAI DITUGASKAN: -';
            }

            /*
             * Jumlah hari
             */
            $detail[] =
                'Jumlah Hari: ' .
                ($surat->jumlah_hari_tugas ?: '-');

            /*
             * Tujuan
             */
            $detail[] =
                'Tujuan: ' .
                ($surat->tujuan_tugas ?: '-');

            /*
             * Maksud / Tujuan
             */
            $detail[] =
                'Maksud/Tujuan: ' .
                ($surat->maksud_tujuan_tugas ?: '-');

            /*
             * Mulai
             */
            $mulai = $surat->mulai_tugas
                ? Carbon::parse($surat->mulai_tugas)
                    ->locale('id')
                    ->translatedFormat('d M Y')
                : '-';

            $detail[] =
                'Mulai: ' .
                $mulai;

            /*
             * Selesai
             */
            $selesai = $surat->selesai_tugas
                ? Carbon::parse($surat->selesai_tugas)
                    ->locale('id')
                    ->translatedFormat('d M Y')
                : '-';

            $detail[] =
                'Selesai: ' .
                $selesai;

            /*
             * Gabungkan dengan baris baru Excel.
             */
            $detailTugas = implode(
                "\n",
                $detail
            );
        }


        /*
         * ==========================================================
         * NO & TGL SURAT
         * ==========================================================
         */

        $tglSurat = $surat->tgl_surat
            ? Carbon::parse($surat->tgl_surat)
                ->locale('id')
                ->translatedFormat('d M Y')
            : '-';

        $noTanggalSurat =
            'No. Surat: ' .
            ($surat->no_surat ?? '-') .
            "\n" .
            'Tgl. Surat: ' .
            $tglSurat;


        /*
         * ==========================================================
         * SIFAT SURAT
         * ==========================================================
         */

        $sifatSurat = optional(
            $surat->sifatSurat
        )->nama_sifat ?? '-';


        /*
         * ==========================================================
         * INSTANSI / TUJUAN
         * ==========================================================
         */

        $instansi = optional(
            $surat->instansi
        )->nama_instansi ?? '-';


        /*
         * ==========================================================
         * LAMPIRAN
         * ==========================================================
         */

        $lampiran = !empty($surat->lampiran)
            ? $surat->lampiran
            : '-';


        /*
         * ==========================================================
         * PERIHAL
         * ==========================================================
         */

        $perihal = $surat->perihal ?? '-';


        return [
            $no,
            $surat->no_agenda ?? '-',
            $jenisSurat,
            $detailTugas,
            $noTanggalSurat,
            $sifatSurat,
            $lampiran,
            $instansi,
            $perihal,
        ];
    }

    /**
     * Event styling Excel.
     */
    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (
                AfterSheet $event
            ) {

                $sheet =
                    $event->sheet->getDelegate();


                /*
                 * ==================================================
                 * JUDUL
                 * ==================================================
                 */

                $sheet->mergeCells('A1:I1');

                $sheet->setCellValue(
                    'A1',
                    'LAPORAN EKSPEDISI SURAT KELUAR'
                );


                /*
                 * ==================================================
                 * INSTANSI
                 * ==================================================
                 */

                $sheet->mergeCells('A2:I2');

                $sheet->setCellValue(
                    'A2',
                    'BKPSDM Kabupaten Ogan Komering Ilir'
                );


                /*
                 * ==================================================
                 * PERIODE
                 * ==================================================
                 */

                $sheet->mergeCells('A3:I3');

                if (
                    $this->tgl_awal &&
                    $this->tgl_akhir
                ) {
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

                } elseif ($this->tgl_surat) {

                    $periode =
                        'Tanggal Surat: ' .
                        Carbon::parse($this->tgl_surat)
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
                 * ==================================================
                 * WAKTU DOWNLOAD
                 * ==================================================
                 */

                $sheet->mergeCells('A4:I4');

                $tanggalDownload =
                    Carbon::now()
                        ->locale('id')
                        ->translatedFormat('d F Y, H:i');

                $sheet->setCellValue(
                    'A4',
                    'Diunduh: ' .
                    $tanggalDownload .
                    ' WIB'
                );


                /*
                 * ==================================================
                 * STYLE JUDUL
                 * ==================================================
                 */

                $sheet->getStyle('A1')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 16,
                        ],
                        'alignment' => [
                            'horizontal' =>
                                Alignment::HORIZONTAL_CENTER,
                            'vertical' =>
                                Alignment::VERTICAL_CENTER,
                        ],
                    ]);


                /*
                 * ==================================================
                 * STYLE INSTANSI
                 * ==================================================
                 */

                $sheet->getStyle('A2')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 12,
                        ],
                        'alignment' => [
                            'horizontal' =>
                                Alignment::HORIZONTAL_CENTER,
                            'vertical' =>
                                Alignment::VERTICAL_CENTER,
                        ],
                    ]);


                /*
                 * ==================================================
                 * STYLE PERIODE
                 * ==================================================
                 */

                $sheet->getStyle('A3')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 11,
                        ],
                        'alignment' => [
                            'horizontal' =>
                                Alignment::HORIZONTAL_CENTER,
                            'vertical' =>
                                Alignment::VERTICAL_CENTER,
                        ],
                    ]);


                /*
                 * ==================================================
                 * STYLE DOWNLOAD
                 * ==================================================
                 */

                $sheet->getStyle('A4')
                    ->applyFromArray([
                        'font' => [
                            'italic' => true,
                            'size' => 10,
                        ],
                        'alignment' => [
                            'horizontal' =>
                                Alignment::HORIZONTAL_CENTER,
                            'vertical' =>
                                Alignment::VERTICAL_CENTER,
                        ],
                    ]);


                /*
                 * ==================================================
                 * HEADER TABEL
                 * ==================================================
                 */

                $sheet->getStyle('A6:I6')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'size' => 11,
                        ],
                        'alignment' => [
                            'horizontal' =>
                                Alignment::HORIZONTAL_CENTER,
                            'vertical' =>
                                Alignment::VERTICAL_CENTER,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' =>
                                    Border::BORDER_THIN,
                            ],
                        ],
                    ]);


                /*
                 * ==================================================
                 * DATA
                 * ==================================================
                 */

                $highestRow =
                    $sheet->getHighestRow();

                if ($highestRow >= 7) {

                    $sheet->getStyle(
                        'A7:I' . $highestRow
                    )->applyFromArray([
                        'alignment' => [
                            'vertical' =>
                                Alignment::VERTICAL_TOP,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' =>
                                    Border::BORDER_THIN,
                            ],
                        ],
                    ]);


                    /*
                     * No
                     */
                    $sheet->getStyle(
                        'A7:A' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );


                    /*
                     * No Agenda
                     */
                    $sheet->getStyle(
                        'B7:B' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );


                    /*
                     * Jenis
                     */
                    $sheet->getStyle(
                        'C7:C' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );


                    /*
                     * No & Tgl Surat
                     */
                    $sheet->getStyle(
                        'E7:E' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );


                    /*
                     * Sifat
                     */
                    $sheet->getStyle(
                        'F7:F' . $highestRow
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_CENTER
                        );
                }


                /*
                 * ==================================================
                 * TINGGI BARIS
                 * ==================================================
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
                    ->setRowHeight(35);


                /*
                 * ==================================================
                 * LEBAR KOLOM
                 * ==================================================
                 */

                $sheet->getColumnDimension('A')
                    ->setWidth(8);

                $sheet->getColumnDimension('B')
                    ->setWidth(18);

                $sheet->getColumnDimension('C')
                    ->setWidth(25);

                $sheet->getColumnDimension('D')
                    ->setWidth(50);

                $sheet->getColumnDimension('E')
                    ->setWidth(25);

                $sheet->getColumnDimension('F')
                    ->setWidth(18);

                $sheet->getColumnDimension('G')
                    ->setWidth(20);

                $sheet->getColumnDimension('H')
                    ->setWidth(30);

                $sheet->getColumnDimension('I')
                    ->setWidth(40);


                /*
                 * ==================================================
                 * FREEZE HEADER
                 * ==================================================
                 */

                $sheet->freezePane('A7');
            },
        ];
    }
}
