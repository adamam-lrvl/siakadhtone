<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class LaporanNilaiController extends Controller
{
    public function index()
    {
        $kelas = Kelas::withCount('siswas')
            ->with('waliKelas')
            ->orderBy('nama_kelas')
            ->get();

        return view('kepala-sekolah.laporan-nilai.index', compact('kelas'));
    }

    public function show(Request $request, Kelas $kelas)
    {
        $semester = $request->get('semester', 1);

        // Ambil semua siswa di kelas ini
        $siswas = Siswa::where('kelas_id', $kelas->id)
            ->with(['nilai' => function ($q) use ($semester) {
                $q->where('semester', $semester)->with('mapel');
            }])
            ->orderBy('nama')
            ->get();

        // Ambil semua mapel yang ada nilainya di kelas ini
        $mapels = Nilai::whereIn('siswa_id', $siswas->pluck('id'))
            ->where('semester', $semester)
            ->with('mapel')
            ->get()
            ->pluck('mapel')
            ->filter()
            ->unique('id')
            ->sortBy('nama_mapel')
            ->values();

        // Rekap nilai per siswa per mapel
        $rekap = $siswas->map(function ($siswa) use ($mapels, $semester) {
            $nilaiPerMapel = [];

            foreach ($mapels as $mapel) {
                $nilaiGroup = $siswa->nilai
                    ->where('mapel_id', $mapel->id)
                    ->where('semester', $semester);

                $tugas   = $nilaiGroup->filter(fn($n) => str_starts_with($n->kategori, 'tugas_'))->avg('nilai');
                $uts     = $nilaiGroup->where('kategori', 'uts')->first()?->nilai;
                $uas     = $nilaiGroup->where('kategori', 'uas')->first()?->nilai;
                $rata    = $nilaiGroup->avg('nilai');
                $predikat = $rata >= 81 ? 'A' : ($rata >= 70 ? 'B' : ($rata >= 60 ? 'C' : ($rata >= 50 ? 'D' : ($rata > 0 ? 'E' : '-'))));

                $nilaiPerMapel[$mapel->id] = [
                    'tugas'    => $tugas ? number_format($tugas, 1) : '-',
                    'uts'      => $uts ? number_format($uts, 1) : '-',
                    'uas'      => $uas ? number_format($uas, 1) : '-',
                    'rata'     => $rata ? number_format($rata, 1) : '-',
                    'predikat' => $predikat,
                ];
            }

            return (object) [
                'siswa'         => $siswa,
                'nilaiPerMapel' => $nilaiPerMapel,
            ];
        });

        return view('kepala-sekolah.laporan-nilai.show', compact(
            'kelas', 'semester', 'siswas', 'mapels', 'rekap'
        ));
    }

    public function exportExcel(Request $request, Kelas $kelas)
    {
        $semester = $request->get('semester', 1);

        $siswas = Siswa::where('kelas_id', $kelas->id)
            ->with(['nilai' => fn($q) => $q->where('semester', $semester)->with('mapel')])
            ->orderBy('nama')
            ->get();

        $mapels = Nilai::whereIn('siswa_id', $siswas->pluck('id'))
            ->where('semester', $semester)
            ->with('mapel')
            ->get()
            ->pluck('mapel')
            ->filter()
            ->unique('id')
            ->sortBy('nama_mapel')
            ->values();

        return Excel::download(
            new \App\Exports\LaporanNilaiKelasExport($kelas, $siswas, $mapels, $semester),
            'Laporan_Nilai_' . $kelas->nama_kelas . '_Smt' . $semester . '_' . date('Ymd') . '.xlsx'
        );
    }

    public function exportPdf(Request $request, Kelas $kelas)
    {
        $semester = $request->get('semester', 1);

        $siswas = Siswa::where('kelas_id', $kelas->id)
            ->with(['nilai' => fn($q) => $q->where('semester', $semester)->with('mapel')])
            ->orderBy('nama')
            ->get();

        $mapels = Nilai::whereIn('siswa_id', $siswas->pluck('id'))
            ->where('semester', $semester)
            ->with('mapel')
            ->get()
            ->pluck('mapel')
            ->filter()
            ->unique('id')
            ->sortBy('nama_mapel')
            ->values();

        $rekap = $siswas->map(function ($siswa) use ($mapels, $semester) {
            $nilaiPerMapel = [];
            foreach ($mapels as $mapel) {
                $nilaiGroup = $siswa->nilai->where('mapel_id', $mapel->id)->where('semester', $semester);
                $rata = $nilaiGroup->avg('nilai');
                $nilaiPerMapel[$mapel->id] = [
                    'tugas'    => $nilaiGroup->filter(fn($n) => str_starts_with($n->kategori, 'tugas_'))->avg('nilai'),
                    'uts'      => $nilaiGroup->where('kategori', 'uts')->first()?->nilai,
                    'uas'      => $nilaiGroup->where('kategori', 'uas')->first()?->nilai,
                    'rata'     => $rata ? number_format($rata, 1) : '-',
                    'predikat' => $rata >= 81 ? 'A' : ($rata >= 70 ? 'B' : ($rata >= 60 ? 'C' : ($rata >= 50 ? 'D' : ($rata > 0 ? 'E' : '-')))),
                ];
            }
            return (object) ['siswa' => $siswa, 'nilaiPerMapel' => $nilaiPerMapel];
        });

        $pdf = PDF::loadView('kepala-sekolah.laporan-nilai.export-pdf', compact(
            'kelas', 'semester', 'mapels', 'rekap'
        ))->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Nilai_' . $kelas->nama_kelas . '_Smt' . $semester . '_' . date('Ymd') . '.pdf');
    }
}