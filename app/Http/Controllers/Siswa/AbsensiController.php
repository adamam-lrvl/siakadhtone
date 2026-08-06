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
        $siswa          = Auth::user()->siswa;
        $totalPertemuan = 16;

        $absensis = Absensi::where('siswa_id', $siswa->id)
            ->with(['jadwal.mapel', 'jadwal.guru'])
            ->get()
            ->groupBy(fn($item) => $item->jadwal->mapel_id);

        // Hitung rekap per mapel
        $rekapMapel = $absensis->map(function ($records) use ($totalPertemuan) {
            $mapel            = $records->first()->jadwal->mapel;
            $guru             = $records->first()->jadwal->guru;
            $pertemuanSelesai = $records->pluck('tanggal')->unique()->count();

            $H = $records->where('status', 'H')->count();
            $I = $records->where('status', 'I')->count();
            $S = $records->where('status', 'S')->count();
            $A = $records->where('status', 'A')->count();

            return [
                'mapel'            => $mapel,
                'guru'             => $guru,
                'pertemuanSelesai' => $pertemuanSelesai,
                'H'                => $H,
                'I'                => $I,
                'S'                => $S,
                'A'                => $A,
                'belum'            => $totalPertemuan - $pertemuanSelesai,
                'persen'           => $totalPertemuan > 0
                    ? round(($H / $totalPertemuan) * 100, 1)
                    : 0,
            ];
        })->values();

        // Summary total
        $summary = [
            'H' => $rekapMapel->sum('H'),
            'I' => $rekapMapel->sum('I'),
            'S' => $rekapMapel->sum('S'),
            'A' => $rekapMapel->sum('A'),
        ];

        return view('siswa.absensi.index', compact(
            'rekapMapel',
            'summary',
            'totalPertemuan',
            'siswa'
        ));
    }

    public function exportExcel()
    {
        $siswa          = Auth::user()->siswa;
        $totalPertemuan = 16;

        $absensis = Absensi::where('siswa_id', $siswa->id)
            ->with(['jadwal.mapel', 'jadwal.guru'])
            ->get()
            ->groupBy(fn($item) => $item->jadwal->mapel_id);

        $exportData = [];
        $no = 1;

        foreach ($absensis as $records) {
            $mapel            = $records->first()->jadwal->mapel;
            $pertemuanSelesai = $records->pluck('tanggal')->unique()->count();

            $hadir = $records->where('status', 'H')->count();
            $izin  = $records->where('status', 'I')->count();
            $sakit = $records->where('status', 'S')->count();
            $alpa  = $records->where('status', 'A')->count();
            $belum = $totalPertemuan - $pertemuanSelesai;
            $persen = $totalPertemuan > 0
                ? round(($hadir / $totalPertemuan) * 100)
                : 0;

            $exportData[] = [
                'No'             => $no++,
                'NIS'            => $siswa->nis,
                'Mata Pelajaran' => $mapel->nama_mapel ?? '-',
                'Pertemuan'      => "$pertemuanSelesai/$totalPertemuan",
                'Hadir'          => $hadir,
                'Izin'           => $izin,
                'Sakit'          => $sakit,
                'Alpa'           => $alpa,
                'Belum Presensi' => $belum,
                'Hadir (%)'      => $persen . '%',
            ];
        }

        return Excel::download(
            new AbsensiSiswaExport($exportData, $siswa),
            'Rekap_Absensi_Saya_' . date('Ymd_His') . '.xlsx'
        );
    }

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