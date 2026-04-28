<?php

namespace App\Exports\Absensi;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AbsensiSiswaExport implements FromCollection, WithTitle, WithEvents, ShouldAutoSize
{
    protected $data;
    protected $siswa;

    public function __construct($data, $siswa)
    {
        $this->data  = is_array($data) ? collect($data) : $data;
        $this->siswa = $siswa;
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

                // Geser data ke bawah untuk header
                $sheet->insertNewRowBefore(1, 6);

                $highestColumn = $sheet->getHighestColumn();
                $highestRow    = $sheet->getHighestRow();

                /* =====================
                 * JUDUL
                 * ===================== */
                $sheet->setCellValue('A1', 'REKAP ABSENSI SISWA');
                $sheet->mergeCells('A1:' . $highestColumn . '1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['argb' => 'FF1E40AF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(40);

                /* =====================
                 * INFO SISWA
                 * ===================== */
                $infoStyle = [
                    'font' => ['bold' => true, 'size' => 11],
                ];

                $sheet->setCellValue('A2', 'Nama Siswa');
                $sheet->setCellValue('C2', ': ' . $this->siswa->nama);
                $sheet->mergeCells('A2:B2');
                $sheet->mergeCells('C2:' . $highestColumn . '2');

                $sheet->setCellValue('A3', 'NIS');
                $sheet->setCellValue('C3', ': ' . $this->siswa->nis);
                $sheet->mergeCells('A3:B3');
                $sheet->mergeCells('C3:' . $highestColumn . '3');

                $sheet->setCellValue('A4', 'Kelas');
                $sheet->setCellValue('C4', ': ' . ($this->siswa->kelas->nama_kelas ?? '-'));
                $sheet->mergeCells('A4:B4');
                $sheet->mergeCells('C4:' . $highestColumn . '4');

                $sheet->getStyle('A2:A4')->applyFromArray($infoStyle);
                $sheet->getStyle('C2:C4')->getFont()->setSize(11);

                /* =====================
                 * HEADER TABEL (row 6)
                 * ===================== */
                $headerRow = 6;

                $headers = [
                    'No',
                    'NIS',
                    'Mata Pelajaran',
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
                        'bold'  => true,
                        'size'  => 11,
                        'color' => ['argb' => 'FFFFFFFF'],
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF1E40AF'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                ]);
                $sheet->getRowDimension($headerRow)->setRowHeight(30);

                /* =====================
                 * BORDER SELURUH TABEL
                 * ===================== */
                $sheet->getStyle('A' . $headerRow . ':' . $highestColumn . $highestRow)
                      ->applyFromArray([
                          'borders' => [
                              'allBorders' => [
                                  'borderStyle' => Border::BORDER_THIN,
                                  'color'       => ['argb' => 'FFB0B0B0'],
                              ],
                          ],
                      ]);

                /* =====================
                 * ALIGNMENT ISI DATA
                 * ===================== */
                $dataStartRow = $headerRow + 1;

                // Kolom A-C: kiri (No, NIS, Mata Pelajaran)
                $sheet->getStyle('A' . $dataStartRow . ':C' . $highestRow)
                      ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Kolom D-J: tengah (angka & persentase)
                $sheet->getStyle('D' . $dataStartRow . ':' . $highestColumn . $highestRow)
                      ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Semua baris data: vertical center
                $sheet->getStyle('A' . $dataStartRow . ':' . $highestColumn . $highestRow)
                      ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                /* =====================
                 * ZEBRA ROW
                 * ===================== */
                for ($row = $dataStartRow; $row <= $highestRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle('A' . $row . ':' . $highestColumn . $row)
                              ->getFill()
                              ->setFillType(Fill::FILL_SOLID)
                              ->getStartColor()
                              ->setARGB('FFF0F4FF'); // biru muda
                    }
                }

                /* =====================
                 * HIGHLIGHT HADIR (%)
                 * Merah kalau < 75%, Hijau kalau >= 75%
                 * ===================== */
                $persenCol = 'J'; // kolom Hadir (%)
                for ($row = $dataStartRow; $row <= $highestRow; $row++) {
                    $val = $sheet->getCell($persenCol . $row)->getValue();
                    $persen = (int) str_replace('%', '', $val);

                    $color = $persen >= 75 ? 'FF16A34A' : 'FFDC2626'; // hijau / merah

                    $sheet->getStyle($persenCol . $row)->applyFromArray([
                        'font' => [
                            'bold'  => true,
                            'color' => ['argb' => $color],
                        ],
                    ]);
                }

                /* =====================
                 * FREEZE HEADER
                 * ===================== */
                $sheet->freezePane('A' . $dataStartRow);

                /* =====================
                 * LEBAR KOLOM MANUAL (opsional)
                 * ===================== */
                $sheet->getColumnDimension('A')->setWidth(6);  // No
                $sheet->getColumnDimension('B')->setWidth(14); // NIS
                $sheet->getColumnDimension('C')->setWidth(28); // Mata Pelajaran
                $sheet->getColumnDimension('D')->setWidth(13); // Pertemuan
                $sheet->getColumnDimension('E')->setWidth(10); // Hadir
                $sheet->getColumnDimension('F')->setWidth(10); // Izin
                $sheet->getColumnDimension('G')->setWidth(10); // Sakit
                $sheet->getColumnDimension('H')->setWidth(10); // Alpa
                $sheet->getColumnDimension('I')->setWidth(18); // Belum Presensi
                $sheet->getColumnDimension('J')->setWidth(12); // Hadir (%)
            },
        ];
    }
}