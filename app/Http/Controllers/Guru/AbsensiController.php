<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // ── HELPER: ambil semua jadwal_id satu mapel+kelas ───────────────────────
    private function getJadwalIds(Jadwal $jadwal): \Illuminate\Support\Collection
    {
        return Jadwal::where('mapel_id', $jadwal->mapel_id)
            ->where('kelas_id', $jadwal->kelas_id)
            ->pluck('id');
    }

    // ── INDEX ─────────────────────────────────────────────────────────────────
    public function index()
    {
        $user = Auth::user();

        if (!$user->guru) {
            return redirect()->route('guru.dashboard')
                             ->with('error', 'Profil guru belum terhubung!');
        }

        // Ambil semua jadwal unik per mapel+kelas (tidak filter hari)
        $hariIni = strtoupper(Carbon::today()->translatedFormat('l'));

        $jadwals = Jadwal::where('guru_id', $user->guru->id)
            ->with(['kelas', 'mapel'])
            ->get()
            // Urutkan: jadwal hari ini duluan, baru yang lain
            ->sortByDesc(fn($j) => strtoupper($j->hari) === $hariIni ? 1 : 0)
            // Ambil satu perwakilan per mapel+kelas
            // Kalau hari ini ada jadwalnya → ambil yang hari ini
            // Kalau tidak → ambil yang manapun
            ->unique(fn($j) => $j->mapel_id . '-' . $j->kelas_id)
            ->values()
            ->map(function ($jadwal) {
                $jadwalIds = Jadwal::where('mapel_id', $jadwal->mapel_id)
                    ->where('kelas_id', $jadwal->kelas_id)
                    ->pluck('id');

                // Sudah absen hari ini?
                $jadwal->sudahAbsenHariIni = Absensi::whereIn('jadwal_id', $jadwalIds)
                    ->whereDate('tanggal', today())
                    ->exists();

                // Pernah absen sama sekali? (untuk tombol lihat rekap)
                $jadwal->pernahAbsen = Absensi::whereIn('jadwal_id', $jadwalIds)
                    ->exists();

                return $jadwal;
            });

        return view('guru.absensi.index', compact('jadwals'));
    }

    // ── CREATE ────────────────────────────────────────────────────────────────
    public function create(Jadwal $jadwal)
    {
        $user = Auth::user();

        if (!$user->guru) {
            return redirect()->route('guru.dashboard')
                             ->with('error', 'Profil guru belum terhubung!');
        }

        if ($jadwal->guru_id !== $user->guru->id) {
            abort(403, 'Akses ditolak.');
        }

        $hariSekarang = strtoupper(Carbon::today()->translatedFormat('l'));
        if (strtoupper($jadwal->hari) !== $hariSekarang) {
            return back()->with('error', 'Absensi hanya bisa dilakukan pada hari jadwal!');
        }

        $siswas = $jadwal->kelas->siswas()->with(['absensi' => function ($q) use ($jadwal) {
            $q->where('jadwal_id', $jadwal->id)->where('tanggal', today());
        }])->get();

        return view('guru.absensi.create', compact('jadwal', 'siswas'));
    }

    // ── STORE ─────────────────────────────────────────────────────────────────
    public function store(Request $request, Jadwal $jadwal)
    {
        $user = Auth::user();

        if (!$user->guru || $jadwal->guru_id !== $user->guru->id) abort(403);

        $request->validate([
            'kehadiran'   => 'required|array',
            'kehadiran.*' => 'required|in:H,I,S,A',
        ]);

        foreach ($request->kehadiran as $siswaId => $status) {
            Absensi::updateOrCreate(
                ['jadwal_id' => $jadwal->id, 'siswa_id' => $siswaId, 'tanggal' => today()],
                ['status' => $status]
            );
        }

        return redirect()->route('guru.absensi.index')
                         ->with('success', 'Absensi berhasil disimpan!');
    }

    // ── EDIT ──────────────────────────────────────────────────────────────────
    public function edit(Jadwal $jadwal)
    {
        $user = Auth::user();

        if (!$user->guru || $jadwal->guru_id !== $user->guru->id) abort(403);

        $hariSekarang = strtoupper(Carbon::today()->translatedFormat('l'));
        if (strtoupper($jadwal->hari) !== $hariSekarang) {
            return back()->with('error', 'Absensi hanya bisa diedit pada hari jadwal!');
        }

        $siswas = $jadwal->kelas->siswas()->with(['absensi' => function ($q) use ($jadwal) {
            $q->where('jadwal_id', $jadwal->id)->where('tanggal', today());
        }])->get();

        return view('guru.absensi.edit', compact('jadwal', 'siswas'));
    }

    // ── UPDATE ────────────────────────────────────────────────────────────────
    public function update(Request $request, Jadwal $jadwal)
    {
        $user = Auth::user();

        if (!$user->guru || $jadwal->guru_id !== $user->guru->id) abort(403);

        $request->validate([
            'kehadiran'   => 'required|array',
            'kehadiran.*' => 'required|in:H,I,S,A',
        ]);

        foreach ($request->kehadiran as $siswaId => $status) {
            Absensi::updateOrCreate(
                ['jadwal_id' => $jadwal->id, 'siswa_id' => $siswaId, 'tanggal' => today()],
                ['status' => $status]
            );
        }

        return redirect()->route('guru.absensi.index')
                         ->with('success', 'Absensi berhasil diperbarui!');
    }

    // ── SHOW: rekap per semester ──────────────────────────────────────────────
    public function show(Jadwal $jadwal)
    {
        $user = Auth::user();

        if (!$user->guru || $jadwal->guru_id !== $user->guru->id) abort(403);

        $totalPertemuan = 16;

        // Ambil semua jadwal_id mapel+kelas yang sama
        $jadwalIds = $this->getJadwalIds($jadwal);

        // Hitung pertemuan yang sudah selesai (tanggal unik lintas semua jadwal_id)
        $pertemuanSelesai = Absensi::whereIn('jadwal_id', $jadwalIds)
            ->selectRaw('COUNT(DISTINCT tanggal) as total')
            ->value('total') ?? 0;

        // Semua siswa di kelas
        $siswas = $jadwal->kelas->siswas()->get();

        // Semua record absensi lintas semua jadwal_id
        $allAbsensi = Absensi::whereIn('jadwal_id', $jadwalIds)
            ->get()
            ->groupBy('siswa_id');

        $rekapSiswa = $siswas->map(function ($siswa) use ($allAbsensi, $totalPertemuan, $pertemuanSelesai) {
            $records = $allAbsensi->get($siswa->id, collect());

            $H = $records->where('status', 'H')->count();
            $I = $records->where('status', 'I')->count();
            $S = $records->where('status', 'S')->count();
            $A = $records->where('status', 'A')->count();

            return [
                'siswa'  => $siswa,
                'H'      => $H,
                'I'      => $I,
                'S'      => $S,
                'A'      => $A,
                'belum'  => $totalPertemuan - $pertemuanSelesai,
                'persen' => $totalPertemuan > 0
                    ? round(($H / $totalPertemuan) * 100, 1)
                    : 0,
            ];
        });

        $summary = [
            'H' => $rekapSiswa->sum('H'),
            'I' => $rekapSiswa->sum('I'),
            'S' => $rekapSiswa->sum('S'),
            'A' => $rekapSiswa->sum('A'),
        ];

        return view('guru.absensi.show', compact(
            'jadwal',
            'rekapSiswa',
            'summary',
            'totalPertemuan',
            'pertemuanSelesai'
        ));
    }

    // ── EXPORT EXCEL ──────────────────────────────────────────────────────────
    public function exportExcel(Jadwal $jadwal)
    {
        if (Auth::user()->guru?->id !== $jadwal->guru_id) abort(403);

        $jadwalIds        = $this->getJadwalIds($jadwal);
        $totalPertemuan   = 16;
        $pertemuanSelesai = Absensi::whereIn('jadwal_id', $jadwalIds)
            ->selectRaw('COUNT(DISTINCT tanggal) as total')
            ->value('total') ?? 0;

        $allAbsensi = Absensi::whereIn('jadwal_id', $jadwalIds)
            ->with('siswa')->get()->groupBy('siswa_id');

        $siswas     = $jadwal->kelas->siswas()->get();
        $exportData = [];
        $no         = 1;

        foreach ($siswas as $siswa) {
            $records = $allAbsensi->get($siswa->id, collect());
            $hadir   = $records->where('status', 'H')->count();
            $izin    = $records->where('status', 'I')->count();
            $sakit   = $records->where('status', 'S')->count();
            $alpa    = $records->where('status', 'A')->count();
            $belum   = $totalPertemuan - $pertemuanSelesai;
            $persen  = round(($hadir / $totalPertemuan) * 100);

            $exportData[] = [
                'No'             => $no++,
                'NIS'            => $siswa->nis,
                'Nama Siswa'     => $siswa->nama,
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
            new AbsensiExport($exportData, $jadwal),
            'Rekap_Absensi_Semester.xlsx'
        );
    }

    // ── EXPORT PDF ────────────────────────────────────────────────────────────
    public function exportPdf(Jadwal $jadwal)
    {
        if (Auth::user()->guru?->id !== $jadwal->guru_id) abort(403);

        $data = $this->getRekapSiswa($jadwal);

        $pdf = Pdf::loadView('guru.absensi.pdf', compact('jadwal', 'data'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('Rekap_Absensi_Siswa.pdf');
    }

    // ── REKAP (ringkasan semua jadwal guru) ───────────────────────────────────
    public function rekap()
    {
        $guru                       = Auth::user()->guru;
        $totalPertemuanSemester     = 16;
        $grandTotalPertemuanSelesai = 0;

        // Ambil jadwal unik per mapel+kelas (bukan semua jadwal_id)
        $jadwals = Jadwal::where('guru_id', $guru->id)
            ->with(['mapel', 'kelas'])
            ->get()
            ->unique(fn($j) => $j->mapel_id . '-' . $j->kelas_id);

        $rekap = [];

        foreach ($jadwals as $jadwal) {
            $jadwalIds = $this->getJadwalIds($jadwal);

            $pertemuanSelesai = Absensi::whereIn('jadwal_id', $jadwalIds)
                ->selectRaw('COUNT(DISTINCT tanggal) as total')
                ->value('total') ?? 0;

            $grandTotalPertemuanSelesai += $pertemuanSelesai;

            $jumlahSiswa = $jadwal->kelas->siswas->count();
            $totalHadir  = Absensi::whereIn('jadwal_id', $jadwalIds)->where('status', 'H')->count();
            $totalIzin   = Absensi::whereIn('jadwal_id', $jadwalIds)->where('status', 'I')->count();
            $totalSakit  = Absensi::whereIn('jadwal_id', $jadwalIds)->where('status', 'S')->count();
            $totalAlpa   = Absensi::whereIn('jadwal_id', $jadwalIds)->where('status', 'A')->count();

            $belumPresensi = ($totalPertemuanSemester - $pertemuanSelesai) * $jumlahSiswa;
            $persenHadir   = $pertemuanSelesai > 0
                ? round(($totalHadir / ($pertemuanSelesai * $jumlahSiswa)) * 100)
                : 0;

            $rekap[] = [
                'jadwal'            => $jadwal,
                'mapel'             => $jadwal->mapel->nama_mapel,
                'kelas'             => $jadwal->kelas->nama_kelas,
                'pertemuan'         => "$pertemuanSelesai/$totalPertemuanSemester",
                'pertemuan_selesai' => $pertemuanSelesai,
                'hadir'             => $totalHadir,
                'izin'              => $totalIzin,
                'sakit'             => $totalSakit,
                'alpa'              => $totalAlpa,
                'belum'             => $belumPresensi,
                'persen'            => $persenHadir,
            ];
        }

        return view('guru.absensi.rekap', compact(
            'rekap',
            'totalPertemuanSemester',
            'grandTotalPertemuanSelesai'
        ));
    }

    // ── HELPER: rekap per siswa untuk PDF ────────────────────────────────────
    private function getRekapSiswa(Jadwal $jadwal): \Illuminate\Support\Collection
    {
        $totalPertemuan = 16;
        $jadwalIds      = $this->getJadwalIds($jadwal);

        $pertemuanSelesai = Absensi::whereIn('jadwal_id', $jadwalIds)
            ->selectRaw('COUNT(DISTINCT tanggal) as total')
            ->value('total') ?? 0;

        $siswas     = $jadwal->kelas->siswas()->get();
        $allAbsensi = Absensi::whereIn('jadwal_id', $jadwalIds)
            ->get()->groupBy('siswa_id');

        return $siswas->map(function ($siswa) use ($allAbsensi, $totalPertemuan, $pertemuanSelesai) {
            $records = $allAbsensi->get($siswa->id, collect());
            $hadir   = $records->where('status', 'H')->count();
            $izin    = $records->where('status', 'I')->count();
            $sakit   = $records->where('status', 'S')->count();
            $alpa    = $records->where('status', 'A')->count();

            return [
                'nis'       => $siswa->nis,
                'nama'      => $siswa->nama,
                'pertemuan' => "$pertemuanSelesai/$totalPertemuan",
                'hadir'     => $hadir,
                'izin'      => $izin,
                'sakit'     => $sakit,
                'alpa'      => $alpa,
                'belum'     => $totalPertemuan - $pertemuanSelesai,
                'persen'    => $totalPertemuan > 0
                    ? round(($hadir / $totalPertemuan) * 100)
                    : 0,
            ];
        });
    }
}