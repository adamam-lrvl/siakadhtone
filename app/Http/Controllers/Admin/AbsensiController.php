<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Absensi::with(['siswa', 'jadwal.mapel', 'jadwal.kelas', 'jadwal.guru'])
                        ->orderBy('tanggal', 'desc');

        // FILTER
        if ($request->filled('kelas_id')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('guru_id')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('guru_id', $request->guru_id);
            });
        }

        if ($request->filled('mapel_id')) {
            $query->whereHas('jadwal', function($q) use ($request) {
                $q->where('mapel_id', $request->mapel_id);
            });
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        $absensis = $query->paginate(25);

        $kelas = Kelas::orderBy('nama_kelas')->get();
        $gurus = Guru::orderBy('nama')->get();
        $mapels = Mapel::orderBy('nama_mapel')->get();

        return view('admin.absensi.index', compact('absensis', 'kelas', 'gurus', 'mapels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jadwals = Jadwal::with(['kelas', 'mapel', 'guru'])->get();
        return view('admin.absensi.create', compact('jadwals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:H,I,S,A',
        ]);

        Absensi::updateOrCreate(
            [
                'jadwal_id' => $request->jadwal_id,
                'siswa_id' => $request->siswa_id,
                'tanggal' => $request->tanggal,
            ],
            ['status' => $request->status]
        );

        return redirect()->route('admin.absensi.index')
                         ->with('success', 'Absensi berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $absensi = Absensi::with(['siswa', 'jadwal.mapel', 'jadwal.kelas', 'jadwal.guru'])
                          ->findOrFail($id);

        return view('admin.absensi.show', compact('absensis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $absensi = Absensi::findOrFail($id);
        $jadwals = Jadwal::with(['kelas', 'mapel', 'guru'])->get();

        return view('admin.absensi.edit', compact('absensis', 'jadwals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:H,I,S,A',
        ]);

        $absensi = Absensi::findOrFail($id);
        $absensi->update([
            'jadwal_id' => $request->jadwal_id,
            'siswa_id' => $request->siswa_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.absensi.index')
                         ->with('success', 'Absensi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('admin.absensi.index')
                         ->with('success', 'Absensi berhasil dihapus!');
    }
}