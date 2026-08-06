<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DashboardController extends Controller
{
    public function index()
{
    $siswa = Auth::user()->siswa;

        $hariIni = \Carbon\Carbon::today()->translatedFormat('l');

        $jadwalsHariIni = Jadwal::whereHas('kelas.siswas', function ($q) use ($siswa) {
            $q->where('siswas.id', $siswa->id);
        })
        ->where('hari', $hariIni)
        ->with(['mapel', 'guru'])
        ->orderBy('jam_mulai')
        ->get();

        // ABSENSI OVERALL (untuk stat card)
        $absensi = Absensi::where('siswa_id', $siswa->id)
            ->whereMonth('tanggal', now()->month)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        //  ABSENSI PER MAPEL (baru)
        $absensiPerMapel = Absensi::where('siswa_id', $siswa->id)
            ->whereMonth('tanggal', now()->month)
            ->with('jadwal.mapel')
            ->get()
            ->groupBy(fn($absen) => $absen->jadwal->mapel->nama_mapel ?? 'Tidak Diketahui')
            ->map(function ($group, $namaMapel) {
                $total = $group->count();
                $hadir = $group->where('status', 'H')->count();
                $persen = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;

                return [
                    'mapel' => $namaMapel,
                    'total' => $total,
                    'hadir' => $hadir,
                    'persen_hadir' => $persen,
                ];
            })
            ->values();

        $nilaiTerakhir = Nilai::where('siswa_id', $siswa->id)
            ->with('mapel')
            ->orderBy('updated_at', 'desc')
            ->get();

        $pengumuman = Pengumuman::published()->latest()->get();

        $jadwalSemester = Jadwal::whereHas('kelas.siswas', function ($q) use ($siswa) {
        $q->where('siswas.id', $siswa->id);
        })
        ->with(['mapel', 'guru'])
        ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
        ->orderBy('jam_mulai')
        ->get()
        ->groupBy('hari');

        // Hari urut
        $hariUrut = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        return view('siswa.dashboard', compact(
            'jadwalsHariIni',
            'absensi',
            'absensiPerMapel',    
            'nilaiTerakhir',
            'pengumuman',
            'jadwalSemester',   
            'hariUrut'
        ));
}

    public function jadwal()
    {
        $siswa = Auth::user()->siswa;

        $jadwals = Jadwal::whereHas('kelas.siswas', function ($q) use ($siswa) {
            $q->where('id', $siswa->id);
        })
        ->with(['mapel', 'guru'])
        ->orderBy('hari')
        ->orderBy('jam_mulai')
        ->get()
        ->groupBy('hari');

        $hariUrut = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        return view('siswa.jadwal.index', compact('jadwals', 'hariUrut'));
    }

    public function absensi()
    {
        $siswa = Auth::user()->siswa;

        $absensis = Absensi::where('siswa_id', $siswa->id)
            ->with('jadwal.mapel', 'jadwal.guru')
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('siswa.absensi.index', compact('absensis'));
    }

    public function pengumuman()
    {
        $pengumuman = Pengumuman::published()->latest()->paginate(10);
        return view('siswa.pengumuman.index', compact('pengumuman'));
    }

public function rekap()
{
    $siswa = Auth::user()->siswa;

    $nilais = Nilai::where('siswa_id', $siswa->id)
        ->with('mapel')
        ->get();

    if ($nilais->isEmpty()) {
        $rekapNilai = collect();
    } else {
        $rekapNilai = $nilais->groupBy('mapel_id')->map(function ($group) {
            $mapel = $group->first()->mapel;

            // RATA-RATA SEMUA TUGAS (tugas_1 sampai tugas_6)
            $tugas = $group->filter(fn($n) => str_starts_with($n->kategori, 'tugas_'))->avg('nilai');

            // UTS & UAS 
            $uts = $group->where('kategori', 'uts')->avg('nilai');
            $uas = $group->where('kategori', 'uas')->avg('nilai');

            $rataRata = $group->avg('nilai');

            $predikat = $rataRata >= 81 ? 'A' :
                        ($rataRata >= 70 ? 'B' :
                        ($rataRata >= 60 ? 'C' :
                        ($rataRata >= 50 ? 'D' : 'E')));

            return (object) [
                'mapel' => $mapel,
                'semester' => $group->first()->semester ?? 1,
                'tugas' => $tugas ? number_format($tugas, 2) : '-',
                'uts' => $uts ? number_format($uts, 2) : '-',
                'uas' => $uas ? number_format($uas, 2) : '-',
                'rata_rata' => number_format($rataRata, 2),
                'predikat' => $predikat,
            ];
        })->values();
    }

    return view('siswa.nilai.index', compact('rekapNilai'));
}

        /**
     * Export Rekap Nilai ke Excel
     */
    public function exportNilaiExcel()
    {
        $siswa = Auth::user()->siswa;

        $nilais = Nilai::where('siswa_id', $siswa->id)
            ->with('mapel')
            ->get();

        $rekapNilai = $nilais->groupBy('mapel_id')->map(function ($group) {
            $mapel = $group->first()->mapel;

            $tugas = $group->filter(fn($n) => str_starts_with($n->kategori, 'tugas_'))->avg('nilai');
            $uts   = $group->where('kategori', 'uts')->avg('nilai');
            $uas   = $group->where('kategori', 'uas')->avg('nilai');

            $rataRata = $group->avg('nilai');

            $predikat = $rataRata >= 81 ? 'A' :
                        ($rataRata >= 70 ? 'B' :
                        ($rataRata >= 60 ? 'C' :
                        ($rataRata >= 50 ? 'D' : 'E')));

            return [
                'Mata Pelajaran' => $mapel->nama_mapel ?? '-',
                'Semester'       => $group->first()->semester ?? 1,
                'Tugas'          => $tugas ? number_format($tugas, 2) : '-',
                'UTS'            => $uts   ? number_format($uts, 2)   : '-',
                'UAS'            => $uas   ? number_format($uas, 2)   : '-',
                'Rata-rata'      => number_format($rataRata, 2),
                'Predikat'       => $predikat,
            ];
        })->values();

        return Excel::download(new class($rekapNilai) implements 
            \Maatwebsite\Excel\Concerns\FromCollection,
            \Maatwebsite\Excel\Concerns\WithHeadings 
        {
            protected $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                return collect($this->data);
            }

            public function headings(): array
            {
                return ['Mata Pelajaran', 'Semester', 'Tugas', 'UTS', 'UAS', 'Rata-rata', 'Predikat'];
            }
        }, 'Rekap_Nilai_Saya_' . date('Ymd_His') . '.xlsx');
    }

    /**
     * Export Rekap Nilai ke PDF
     */
    public function exportNilaiPdf()
    {
        $siswa = Auth::user()->siswa;

        $nilais = Nilai::where('siswa_id', $siswa->id)
            ->with('mapel')
            ->get();

        $rekapNilai = $nilais->groupBy('mapel_id')->map(function ($group) {
            $mapel = $group->first()->mapel;

            $tugas = $group->filter(fn($n) => str_starts_with($n->kategori, 'tugas_'))->avg('nilai');
            $uts   = $group->where('kategori', 'uts')->avg('nilai');
            $uas   = $group->where('kategori', 'uas')->avg('nilai');

            $rataRata = $group->avg('nilai');

            $predikat = $rataRata >= 81 ? 'A' :
                        ($rataRata >= 70 ? 'B' :
                        ($rataRata >= 60 ? 'C' :
                        ($rataRata >= 50 ? 'D' : 'E')));

            return (object) [
                'mapel'     => $mapel,
                'semester'  => $group->first()->semester ?? 1,
                'tugas'     => $tugas ? number_format($tugas, 2) : '-',
                'uts'       => $uts   ? number_format($uts, 2)   : '-',
                'uas'       => $uas   ? number_format($uas, 2)   : '-',
                'rata_rata' => number_format($rataRata, 2),
                'predikat'  => $predikat,
            ];
        })->values();

            $pdf = PDF::loadView('siswa.nilai.export-pdf', compact('rekapNilai', 'siswa'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Rekap_Nilai_Saya_' . date('Ymd_His') . '.pdf');
    }

}
