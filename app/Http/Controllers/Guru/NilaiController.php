<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Auth::user()->guru;

        $jadwals = Jadwal::where('guru_id', $guru->id)
            ->with(['mapel', 'kelas'])
            ->get();

        $mapelGrouped = $jadwals->groupBy('mapel_id')->map(function ($group) {
            $first = $group->first();
            $kelasUnik = $group->pluck('kelas')->unique('id')->sortBy('nama_kelas');

            return [
                'mapel' => $first->mapel,
                'kelas' => $kelasUnik->values(),
            ];
        })->values();

        return view('guru.nilai.index', compact('mapelGrouped'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($kelasId, $mapelId, $semester = 1)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $mapel = Mapel::findOrFail($mapelId);

        $guru = Auth::user()->guru;

        $jadwal = Jadwal::where('guru_id', $guru->id)
            ->where('kelas_id', $kelasId)
            ->where('mapel_id', $mapelId)
            ->first();

        if (!$jadwal) {
            abort(403, 'Anda tidak mengajar mapel ini di kelas tersebut.');
        }

        $kategoriList = [
            'tugas_1', 'tugas_2', 'tugas_3',
            'tugas_4', 'tugas_5', 'tugas_6',
            'uts', 'uas'
        ];

        $bobot = [
            'tugas' => 0.4,
            'uts'   => 0.3,
            'uas'   => 0.3,
        ];

        $siswa = $kelas->siswas()
            ->with(['nilai' => function ($q) use ($mapelId, $semester) {
                $q->where('mapel_id', $mapelId)
                  ->where('semester', $semester);
            }])
            ->orderBy('nama')
            ->get();

        $rekapSiswa = $siswa->map(function ($s) use ($kategoriList, $bobot) {
            $nilaiKategori = [];
            $totalTugas = 0;
            $jumlahTugas = 0;

            foreach ($kategoriList as $kat) {
                $nilai = $s->nilai->where('kategori', $kat)->first();
                $nilaiKategori[$kat] = $nilai ? $nilai->nilai : null;

                if (str_starts_with($kat, 'tugas_') && $nilai) {
                    $totalTugas += $nilai->nilai;
                    $jumlahTugas++;
                }
            }

            $rataTugas = $jumlahTugas > 0
                ? round($totalTugas / $jumlahTugas, 2)
                : 0;

            $uts = $nilaiKategori['uts'] ?? 0;
            $uas = $nilaiKategori['uas'] ?? 0;

            $nilaiAkhir = round(
                ($rataTugas * $bobot['tugas']) +
                ($uts * $bobot['uts']) +
                ($uas * $bobot['uas']),
                2
            );

            return [
                'siswa'       => $s,
                'nilai'       => $nilaiKategori,
                'rata_tugas'  => $rataTugas,
                'uts'         => $uts,
                'uas'         => $uas,
                'rata_rata'   => $nilaiAkhir, 
                'nilai_akhir' => $nilaiAkhir,
                'predikat'    => $this->hitungPredikat($nilaiAkhir),
            ];
        });

        return view('guru.nilai.show', compact(
            'kelas',
            'mapel',
            'semester',
            'rekapSiswa',
            'kategoriList'
        ));
    }

private function hitungPredikat($nilai)
{
    if ($nilai >= 90) return 'A';
    if ($nilai >= 80) return 'B';
    if ($nilai >= 70) return 'C';
    if ($nilai >= 60) return 'D';
    return 'E';
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kelasId, $mapelId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $mapel = Mapel::findOrFail($mapelId);

        
        $kategori = [
            'tugas_1', 'tugas_2', 'tugas_3', 'tugas_4', 'tugas_5', 'tugas_6',
            'uts', 'uas'
        ];

        $siswa = $kelas->siswas()->with([
            'nilai' => function($q) use ($mapelId) {
                $q->where('mapel_id', $mapelId);
            }
        ])->get();

        return view('guru.nilai.edit', compact(
            'siswa', 'kelas', 'mapel', 'kategori', 'kelasId', 'mapelId'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kelasId, $mapelId)
    {
        //
    }


public function simpanPerKategori(Request $request, $kelasId, $mapelId, $kategori)
{
    // Validasi dulu biar aman
    $request->validate([
        'semester' => 'required|in:1,2',
        'nilai'    => 'required|array',
        'nilai.*'  => 'nullable|numeric|min:0|max:100',
    ]);

    $semester = $request->semester;

    foreach ($request->nilai as $siswaId => $nilaiInput) {
        // Hanya simpan kalau nilai diisi (bukan null/kosong) dan valid
        if ($nilaiInput !== null && $nilaiInput !== '' && is_numeric($nilaiInput)) {
            \App\Models\Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mapel_id' => $mapelId,
                    'kategori' => $kategori,
                    'semester' => $semester,
                ],
                [
                    'nilai' => $nilaiInput,
                ]
            );
        }
    }

    $kategoriNama = ucwords(str_replace('_', ' ', $kategori));

    return back()->with('success', "Nilai {$kategoriNama} berhasil disimpan!");
}

public function pilihKategori($kelasId, $mapelId)
{
    $kelas = Kelas::findOrFail($kelasId);
    $mapel = Mapel::findOrFail($mapelId);

    // Cek apakah guru ini mengajar mapel & kelas ini
    $guru = Auth::user()->guru;
    $jadwal = Jadwal::where('guru_id', $guru->id)
        ->where('kelas_id', $kelasId)
        ->where('mapel_id', $mapelId)
        ->first();

    if (!$jadwal) {
        abort(403, 'Anda tidak mengajar mata pelajaran ini di kelas tersebut.');
    }

    // Daftar kategori nilai
    $kategori = ['tugas_1', 'tugas_2', 'tugas_3', 'tugas_4', 'tugas_5', 'tugas_6', 'uts', 'uas'];

    return view('guru.nilai.pilih-kategori', compact('kelas', 'mapel', 'kategori'));
}

public function inputPerKategori($kelasId, $mapelId, $kategori)
{
    $kelas = Kelas::findOrFail($kelasId);
    $mapel = Mapel::findOrFail($mapelId);

    // Cek apakah guru ini mengajar di kelas & mapel ini
    $guru = Auth::user()->guru;
    $jadwal = Jadwal::where('guru_id', $guru->id)
        ->where('kelas_id', $kelasId)
        ->where('mapel_id', $mapelId)
        ->first();

    if (!$jadwal) {
        abort(403, 'Anda tidak mengajar mata pelajaran ini di kelas tersebut.');
    }

    // Ambil siswa di kelas ini + nilai lama untuk kategori & semester default
    $siswa = $kelas->siswas()->with(['nilai' => function ($q) use ($mapelId, $kategori) {
        $q->where('mapel_id', $mapelId)
          ->where('kategori', $kategori);
          // Semester gak di-filter di sini, karena di input bisa pilih semester
    }])->orderBy('nama')->get();

    return view('guru.nilai.input-per-kategori', compact('kelas', 'mapel', 'kategori', 'siswa'));
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
