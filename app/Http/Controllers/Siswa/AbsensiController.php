<?php

namespace App\Http\Controllers\Siswa;

use App\Exports\Absensi\AbsensiSiswaExport;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AbsensiController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        $absensis = Absensi::where('siswa_id', $siswa->id)
            ->with('jadwal.mapel', 'jadwal.guru')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->paginate(20);

        return view('siswa.absensi.index', compact('absensis'));
    }

    /**
     * Export Absensi Siswa ke Excel
     */
public function exportExcel()
{
    $siswa          = Auth::user()->siswa;
    $totalPertemuan = 16;

    $absensis = Absensi::where('siswa_id', $siswa->id)
        ->with(['jadwal.mapel', 'jadwal.guru'])
        ->get()
        // 🔥 GROUP BY MAPEL, BUKAN JADWAL
        ->groupBy(fn($item) => $item->jadwal->mapel_id);

    $exportData = [];
    $no = 1;

    foreach ($absensis as $records) {
        $mapel = $records->first()->jadwal->mapel;

        // 🔥 HITUNG PERTEMUAN DARI TANGGAL UNIK
        $pertemuanSelesai = $records
            ->pluck('tanggal')
            ->unique()
            ->count();

        $hadir = $records->where('status', 'H')->count();
        $izin  = $records->where('status', 'I')->count();
        $sakit = $records->where('status', 'S')->count();
        $alpa  = $records->where('status', 'A')->count();

        // ✅ INI YANG BENER
        $pertemuan = $pertemuanSelesai . '/' . $totalPertemuan;

        $belum = $totalPertemuan - $pertemuanSelesai;

        $persenHadir = $totalPertemuan > 0
            ? round(($hadir / $totalPertemuan) * 100)
            : 0;

        $exportData[] = [
            'No'             => $no++,
            'NIS'            => $siswa->nis,
            'Mata Pelajaran' => $mapel->nama_mapel ?? '-',
            'Pertemuan'      => $pertemuan,
            'Hadir'          => $hadir,
            'Izin'           => $izin,
            'Sakit'          => $sakit,
            'Alpa'           => $alpa,
            'Belum Presensi' => $belum,
            'Hadir (%)'      => $persenHadir . '%',
        ];
    }

    return Excel::download(
        new AbsensiSiswaExport($exportData, $siswa),
        'Rekap_Absensi_Saya_' . date('Ymd_His') . '.xlsx'
    );
}

    /**
     * Export Absensi Siswa ke PDF
     */
    public function exportPdf()
    {
        $siswa          = Auth::user()->siswa;
        $totalPertemuan = 16;

        $absensis = Absensi::where('siswa_id', $siswa->id)
            ->with(['jadwal.mapel', 'jadwal.guru'])
            ->orderBy('tanggal', 'desc')
            ->get()
            ->groupBy(fn($item) => $item->jadwal->mapel_id);

        $pdf = PDF::loadView('siswa.absensi.export-pdf', compact('absensis', 'siswa', 'totalPertemuan'))
                  ->setPaper('A4', 'landscape');

        return $pdf->download('Rekap_Absensi_Saya_' . date('Ymd_His') . '.pdf');
    }
}