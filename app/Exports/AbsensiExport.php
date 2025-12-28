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

class AbsensiExport implements FromCollection, WithTitle, WithEvents, ShouldAutoSize
{
    protected $data;
    protected $jadwal;

    public function __construct($data, $jadwal)
    {
        $this->data   = is_array($data) ? collect($data) : $data;
        $this->jadwal = $jadwal;
    }

    public function collection()
    {
        return $this->data;
    }

    public function title(): string
    {
        return 'Rekap Absensi';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /* =====================
                 * GESER DATA KE BAWAH (INI KUNCI)
                 * ===================== */
                $sheet->insertNewRowBefore(1, 5);

                $highestColumn = $sheet->getHighestColumn();
                $highestRow    = $sheet->getHighestRow();

                /* =====================
                 * JUDUL
                 * ===================== */
                $sheet->setCellValue('A1', 'REKAP ABSENSI SISWA');
                $sheet->mergeCells('A1:' . $highestColumn . '1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(35);

                /* =====================
                 * INFO MAPEL & KELAS
                 * ===================== */
                $sheet->setCellValue('A2', 'Mata Pelajaran');
                $sheet->setCellValue('C2', ': ' . $this->jadwal->mapel->nama_mapel);

                $sheet->setCellValue('A3', 'Kelas');
                $sheet->setCellValue('C3', ': ' . $this->jadwal->kelas->nama_kelas);

                $sheet->mergeCells('A2:B2');
                $sheet->mergeCells('C2:' . $highestColumn . '2');
                $sheet->mergeCells('A3:B3');
                $sheet->mergeCells('C3:' . $highestColumn . '3');

                $sheet->getStyle('A2:A3')->getFont()->setBold(true);

                /* =====================
                 * HEADER TABEL
                 * ===================== */
                $headerRow = 5;

                $headers = [
                    'No',
                    'NIS',
                    'Nama Siswa',
                    'Pertemuan',
                    'Hadir',
                    'Izin',
                    'Sakit',
                    'Alpa',
                    'Belum Presensi',
                    'Hadir (%)',
                ];

                $col = 'A';
                foreach ($headers as $header) {
                    $sheet->setCellValue($col . $headerRow, $header);
                    $col++;
                }

                $sheet->getStyle('A' . $headerRow . ':' . $highestColumn . $headerRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF1E40AF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension($headerRow)->setRowHeight(28);

                /* =====================
                 * BORDER TABEL
                 * ===================== */
                $sheet->getStyle('A' . $headerRow . ':' . $highestColumn . $highestRow)
                      ->applyFromArray([
                          'borders' => [
                              'allBorders' => [
                                  'borderStyle' => Border::BORDER_THIN,
                                  'color' => ['argb' => 'FF000000'],
                              ],
                          ],
                      ]);

                /* =====================
                 * ALIGNMENT ISI
                 * ===================== */
                $sheet->getStyle('A' . ($headerRow + 1) . ':C' . $highestRow)
                      ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->getStyle('D' . ($headerRow + 1) . ':' . $highestColumn . $highestRow)
                      ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                /* =====================
                 * FREEZE HEADER
                 * ===================== */
                $sheet->freezePane('A' . ($headerRow + 1));

                /* =====================
                 * ZEBRA ROW
                 * ===================== */
                for ($row = ($headerRow + 1); $row <= $highestRow; $row += 2) {
                    $sheet->getStyle('A' . $row . ':' . $highestColumn . $row)
                          ->getFill()
                          ->setFillType(Fill::FILL_SOLID)
                          ->getStartColor()
                          ->setARGB('FFF3F4F6');
                }
            },
        ];
    }
}
