<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Nilai;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $siswa = Auth::user()->siswa;

    $hariIni = \Carbon\Carbon::today()->translatedFormat('l');
    $jadwalsHariIni = Jadwal::whereHas('kelas.siswas', function ($q) use ($siswa) {
        $q->where('siswas.id', $siswa->id); // PAKE siswas.id, BUKAN siswa_id
    })
    ->where('hari', $hariIni)
    ->with(['mapel', 'guru'])
    ->orderBy('jam_mulai')
    ->get();

    $absensi = Absensi::where('siswa_id', $siswa->id)
        ->whereMonth('tanggal', now()->month)
        ->selectRaw('status, count(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $nilaiTerakhir = Nilai::where('siswa_id', $siswa->id)
        ->with('mapel')
        ->orderBy('updated_at', 'desc')
        ->get();

    $pengumuman = Pengumuman::latest()->get();

    return view('siswa.dashboard', compact(
    'jadwalsHariIni',   // UBAH JADI INI (ADA "S")
    'absensi',
    'nilaiTerakhir',
    'pengumuman'
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
        $pengumuman = Pengumuman::latest()->paginate(10);
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

            // UTS & UAS (kalau ada)
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
}
