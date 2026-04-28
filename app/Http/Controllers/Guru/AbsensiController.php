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
    public function index()
    {
        $user = Auth::user();

        if (!$user->guru) {
            return redirect()->route('guru.dashboard')
                             ->with('error', 'Profil guru belum terhubung!');
        }

        $hariIni = strtoupper(Carbon::today()->translatedFormat('l')); // JUMAT

        $jadwals = Jadwal::where('guru_id', $user->guru->id)
            ->whereRaw('UPPER(hari) = ?', [$hariIni])
            ->with(['kelas', 'mapel', 'absensi' => function ($q) {
                $q->where('tanggal', today());
            }])
            ->get();

        return view('guru.absensi.index', compact('jadwals'));
    }

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
        $hariJadwal = strtoupper($jadwal->hari);

        if ($hariSekarang !== $hariJadwal) {
            return back()->with('error', 'Absensi hanya bisa dilakukan pada hari jadwal!');
        }

        $siswas = $jadwal->kelas->siswas()->with(['absensi' => function ($q) use ($jadwal) {
            $q->where('jadwal_id', $jadwal->id)
              ->where('tanggal', today());
        }])->get();

        return view('guru.absensi.create', compact('jadwal', 'siswas'));
    }

    public function store(Request $request, Jadwal $jadwal)
    {
        $user = Auth::user();

        if (!$user->guru || $jadwal->guru_id !== $user->guru->id) {
            abort(403);
        }

        $request->validate([
            'kehadiran' => 'required|array',
            'kehadiran.*' => 'required|in:H,I,S,A',
        ]);

        foreach ($request->kehadiran as $siswaId => $status) {
            Absensi::updateOrCreate(
                [
                    'jadwal_id' => $jadwal->id,
                    'siswa_id' => $siswaId,
                    'tanggal' => today(),
                ],
                ['status' => $status]
            );
        }

        return redirect()
            ->route('guru.absensi.index')
            ->with('success', 'Absensi berhasil disimpan!');
    }

    public function edit(Jadwal $jadwal)
    {
        $user = Auth::user();

        if (!$user->guru || $jadwal->guru_id !== $user->guru->id) {
            abort(403);
        }

        $hariSekarang = strtoupper(Carbon::today()->translatedFormat('l'));
        $hariJadwal = strtoupper($jadwal->hari);

        if ($hariSekarang !== $hariJadwal) {
            return back()->with('error', 'Absensi hanya bisa diedit pada hari jadwal!');
        }

        $siswas = $jadwal->kelas->siswas()->with(['absensi' => function ($q) use ($jadwal) {
            $q->where('jadwal_id', $jadwal->id)
            ->where('tanggal', today());
        }])->get();

        return view('guru.absensi.edit', compact('jadwal', 'siswas'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $user = Auth::user();

        if (!$user->guru || $jadwal->guru_id !== $user->guru->id) {
            abort(403);
        }

        $request->validate([
            'kehadiran' => 'required|array',
            'kehadiran.*' => 'required|in:H,I,S,A',
        ]);

        foreach ($request->kehadiran as $siswaId => $status) {
            Absensi::updateOrCreate(
                [
                    'jadwal_id' => $jadwal->id,
                    'siswa_id' => $siswaId,
                    'tanggal' => today(),
                ],
                ['status' => $status]
            );
        }

        return redirect()
            ->route('guru.absensi.index')
            ->with('success', 'Absensi berhasil diperbarui!');
    }

    public function show(Jadwal $jadwal)
    {
        $user = Auth::user();

        if (!$user->guru || $jadwal->guru_id !== $user->guru->id) {
            abort(403);
        }

        $tanggal = today(); 

        $absensis = Absensi::where('jadwal_id', $jadwal->id)
            ->where('tanggal', $tanggal)
            ->with('siswa')
            ->get();

        $summary = $absensis->pluck('status')->countBy()->toArray();

        return view('guru.absensi.show', compact('jadwal', 'absensis', 'summary', 'tanggal'));
    }
    

public function exportExcel(Jadwal $jadwal)
{
    if (Auth::user()->guru?->id !== $jadwal->guru_id) {
        abort(403);
    }

    // Ambil semua absensi untuk jadwal ini
    $absensis = Absensi::where('jadwal_id', $jadwal->id)
        ->with('siswa')
        ->get()
        ->groupBy('siswa_id');

    // TOTAL PERTEMUAN SEMESTER FIXED
    $totalPertemuan = 16;

    // Hitung jumlah pertemuan yang sudah selesai (tanggal unik — ini yang benar untuk "sudah diabsen")
    $pertemuanSelesai = Absensi::where('jadwal_id', $jadwal->id)
        ->distinct('tanggal')
        ->count('tanggal');

    $exportData = [];
    $no = 1;

    foreach ($absensis as $siswaId => $records) {
        $siswa = $records->first()->siswa;

        $hadir = $records->where('status', 'H')->count();
        $izin  = $records->where('status', 'I')->count();
        $sakit = $records->where('status', 'S')->count();
        $alpa  = $records->where('status', 'A')->count();

        // Pertemuan: jumlah hadir siswa / total semester
        $pertemuan = "$pertemuanSelesai/$totalPertemuan";

        // Belum presensi PER SISWA = total semester - pertemuan selesai
        $belumPresensi = $totalPertemuan - $pertemuanSelesai;

        // Persentase hadir dari TOTAL SEMESTER (16 pertemuan)
        $persenHadir = round(($hadir / $totalPertemuan) * 100);

        $exportData[] = [
            'No'              => $no++,
            'NIS'             => $siswa->nis,
            'Nama Siswa'      => $siswa->nama,
            'Pertemuan'       => $pertemuan,
            'Hadir'           => $hadir,
            'Izin'            => $izin,
            'Sakit'           => $sakit,
            'Alpa'            => $alpa,
            'Belum Presensi'  => $belumPresensi,      // SEKARANG PER SISWA: 2 kalau baru 14 pertemuan
            'Hadir (%)'       => $persenHadir . '%',
        ];
    }

    return Excel::download(new AbsensiExport($exportData, $jadwal), 'Rekap_Absensi_Semester.xlsx');
}

public function exportPdf($jadwalId)
{
    $jadwal = Jadwal::with(['mapel', 'kelas'])->findOrFail($jadwalId);

    $data = $this->getRekapSiswa($jadwalId); 

    $pdf = Pdf::loadView('guru.absensi.pdf', [
        'jadwal' => $jadwal,
        'data'   => $data,
    ])->setPaper('A4', 'landscape');

    return $pdf->download('Rekap_Absensi_Siswa.pdf');
}


public function rekap()
{
    $guru = Auth::user()->guru;

    $jadwals = Jadwal::where('guru_id', $guru->id)
        ->with(['mapel', 'kelas'])
        ->get();

    $rekap = [];
    $totalPertemuanSemester = 16; // FIXED 16

    $grandTotalPertemuanSelesai = 0;

    foreach ($jadwals as $jadwal) {
        // Hitung jumlah pertemuan yang sudah diabsen (tanggal unik)
        $pertemuanSelesai = Absensi::where('jadwal_id', $jadwal->id)
            ->distinct('tanggal')
            ->count('tanggal');

        $grandTotalPertemuanSelesai += $pertemuanSelesai;

        // Hitung jumlah siswa di kelas
        $jumlahSiswa = $jadwal->kelas->siswas->count();

        // Hitung status per pertemuan yang sudah selesai
        $totalHadir = Absensi::where('jadwal_id', $jadwal->id)->where('status', 'H')->count();
        $totalIzin  = Absensi::where('jadwal_id', $jadwal->id)->where('status', 'I')->count();
        $totalSakit = Absensi::where('jadwal_id', $jadwal->id)->where('status', 'S')->count();
        $totalAlpa  = Absensi::where('jadwal_id', $jadwal->id)->where('status', 'A')->count();

        // Belum presensi = (total pertemuan - pertemuan selesai) * jumlah siswa
        $belumPresensi = ($totalPertemuanSemester - $pertemuanSelesai) * $jumlahSiswa;

        // Persentase hadir = (total hadir / (pertemuan selesai * jumlah siswa)) * 100
        $persenHadir = $pertemuanSelesai > 0 
            ? round(($totalHadir / ($pertemuanSelesai * $jumlahSiswa)) * 100) 
            : 0;

        $rekap[] = [
            'mapel'               => $jadwal->mapel->nama_mapel,
            'kelas'               => $jadwal->kelas->nama_kelas,
            'pertemuan'           => "$pertemuanSelesai/$totalPertemuanSemester",
            'pertemuan_selesai'   => $pertemuanSelesai,
            'alpa'                => $totalAlpa,
            'hadir'               => $totalHadir,
            'izin'                => $totalIzin,
            'sakit'               => $totalSakit,
            'belum'               => $belumPresensi,
            'persen'              => $persenHadir,
        ];
    }

    return view('guru.absensi.rekap', compact('rekap', 'totalPertemuanSemester', 'grandTotalPertemuanSelesai'));
}

private function getRekapSiswa($jadwalId)
{
    $totalPertemuan = 16;

    
    $pertemuanSelesai = Absensi::where('jadwal_id', $jadwalId)
        ->distinct('tanggal')
        ->count('tanggal');

    $siswaList = Absensi::with('siswa')
        ->where('jadwal_id', $jadwalId)
        ->get()
        ->groupBy('siswa_id');

    $data = [];
    $no = 1;

    foreach ($siswaList as $siswaId => $absensis) {

        $hadir = $absensis->where('status', 'H')->count();
        $izin  = $absensis->where('status', 'I')->count();
        $sakit = $absensis->where('status', 'S')->count();
        $alpa  = $absensis->where('status', 'A')->count();

        
        $pertemuan = $pertemuanSelesai . '/' . $totalPertemuan;

        
        $belum = $totalPertemuan - $pertemuanSelesai;

        
        $persen = $totalPertemuan > 0
            ? round(($hadir / $totalPertemuan) * 100)
            : 0;

        $siswa = $absensis->first()->siswa;

        $data[] = [
            'no'        => $no++,
            'nis'       => $siswa->nis,
            'nama'      => $siswa->nama,
            'pertemuan' => $pertemuan,
            'hadir'     => $hadir,
            'izin'      => $izin,
            'sakit'     => $sakit,
            'alpa'      => $alpa,
            'belum'     => $belum,
            'persen'    => $persen,
        ];
    }

    return collect($data);
}

}