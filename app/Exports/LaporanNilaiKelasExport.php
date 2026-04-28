<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanNilaiKelasExport implements FromCollection, WithTitle, WithEvents, ShouldAutoSize
{
    protected $kelas;
    protected $siswas;
    protected $mapels;
    protected $semester;

    public function __construct($kelas, $siswas, $mapels, $semester)
    {
        $this->kelas    = $kelas;
        $this->siswas   = $siswas;
        $this->mapels   = $mapels;
        $this->semester = $semester;
    }

    public function collection()
    {
        $rows = collect();
        $no   = 1;

        foreach ($this->siswas as $siswa) {
            foreach ($this->mapels as $mapel) {
                $nilaiGroup = $siswa->nilai
                    ->where('mapel_id', $mapel->id)
                    ->where('semester', $this->semester);

                $tugas = $nilaiGroup->filter(fn($n) => str_starts_with($n->kategori, 'tugas_'))->avg('nilai');
                $uts   = $nilaiGroup->where('kategori', 'uts')->first()?->nilai;
                $uas   = $nilaiGroup->where('kategori', 'uas')->first()?->nilai;
                $rata  = $nilaiGroup->avg('nilai');
                $predikat = $rata >= 81 ? 'A' : ($rata >= 70 ? 'B' : ($rata >= 60 ? 'C' : ($rata >= 50 ? 'D' : ($rata > 0 ? 'E' : '-'))));

                $rows->push([
                    'No'             => $no,
                    'NIS'            => $siswa->nis,
                    'Nama Siswa'     => $siswa->nama,
                    'Mata Pelajaran' => $mapel->nama_mapel,
                    'Tugas'          => $tugas ? number_format($tugas, 1) : '-',
                    'UTS'            => $uts ? number_format($uts, 1) : '-',
                    'UAS'            => $uas ? number_format($uas, 1) : '-',
                    'Rata-rata'      => $rata ? number_format($rata, 1) : '-',
                    'Predikat'       => $predikat,
                ]);
            }
            $no++;
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Laporan Nilai';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet         = $event->sheet->getDelegate();
                $highestColumn = $sheet->getHighestColumn();
                $highestRow    = $sheet->getHighestRow();

                $sheet->insertNewRowBefore(1, 5);

                // JUDUL
                $sheet->setCellValue('A1', 'LAPORAN NILAI SISWA');
                $sheet->mergeCells('A1:' . $highestColumn . '1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 16, 'color' => ['argb' => 'FF1E40AF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(36);

                // INFO
                $sheet->setCellValue('A2', 'Kelas');
                $sheet->setCellValue('C2', ': ' . $this->kelas->nama_kelas);
                $sheet->setCellValue('A3', 'Wali Kelas');
                $sheet->setCellValue('C3', ': ' . ($this->kelas->waliKelas->nama ?? '-'));
                $sheet->setCellValue('A4', 'Semester');
                $sheet->setCellValue('C4', ': ' . $this->semester . ' (' . ($this->semester == 1 ? 'Ganjil' : 'Genap') . ')');

                $sheet->mergeCells('A2:B2'); $sheet->mergeCells('C2:' . $highestColumn . '2');
                $sheet->mergeCells('A3:B3'); $sheet->mergeCells('C3:' . $highestColumn . '3');
                $sheet->mergeCells('A4:B4'); $sheet->mergeCells('C4:' . $highestColumn . '4');
                $sheet->getStyle('A2:A4')->getFont()->setBold(true);

                // HEADER TABEL
                $headerRow = 6;
                $sheet->getStyle('A' . $headerRow . ':' . $highestColumn . $headerRow)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E40AF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension($headerRow)->setRowHeight(28);

                // BORDER
                $sheet->getStyle('A' . $headerRow . ':' . $highestColumn . $highestRow)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFB0B0B0']]],
                ]);

                // ZEBRA
                for ($row = $headerRow + 1; $row <= $highestRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle('A' . $row . ':' . $highestColumn . $row)
                              ->getFill()->setFillType(Fill::FILL_SOLID)
                              ->getStartColor()->setARGB('FFF0F4FF');
                    }
                }

                $sheet->freezePane('A' . ($headerRow + 1));
            },
        ];
    }
}