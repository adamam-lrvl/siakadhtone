<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['kelas', 'mapel', 'guru'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc');

        // SEARCH — filter sebelum grouping
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('kelas', fn($q) => $q->where('nama_kelas', 'like', '%' . $search . '%'))
                ->orWhereHas('mapel', fn($q) => $q->where('nama_mapel', 'like', '%' . $search . '%'))
                ->orWhereHas('guru', fn($q) => $q->where('nama', 'like', '%' . $search . '%'));
            });
        }

        $jadwals = $query->get();

        // GROUPING: Mapel + Kelas + Guru = satu grup
        $grouped = $jadwals->groupBy(function ($item) {
            return $item->mapel_id . '|' . $item->kelas_id . '|' . $item->guru_id;
        });

        $jadwalGrouped = collect();

        foreach ($grouped as $group) {
            $first = $group->first();

            $hariJam = $group->map(function ($j) {
                return [
                    'id'   => $j->id,
                    'hari' => $j->hari,
                    'jam'  => \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') . ' - ' .
                            \Carbon\Carbon::parse($j->jam_selesai)->format('H:i'),
                ];
            })->sortBy(function ($item) {
                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                return array_search($item['hari'], $days);
            })->values();

            $jadwalGrouped->push([
                'id'       => $first->id,
                'kelas'    => $first->kelas,
                'mapel'    => $first->mapel,
                'guru'     => $first->guru,
                'hari_jam' => $hariJam,
            ]);
        }

        // PAGINATION MANUAL
        $perPage     = 10;
        $currentPage = $request->get('page', 1);
        $currentItems = $jadwalGrouped->slice(($currentPage - 1) * $perPage, $perPage);

        $jadwal = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $jadwalGrouped->count(),
            $perPage,
            $currentPage,
            [
                'path'  => $request->url(),
                'query' => $request->query(), // ← ini penting biar search ikut di pagination
            ]
        );

        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $gurus = Guru::all();
        return view('admin.jadwal.create', compact('kelas', 'mapels', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'   => 'required|exists:kelas,id',
            'mapel_id'   => 'required|exists:mapels,id',
            'guru_id'    => 'required|exists:gurus,id',
            'hari'       => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'  => 'required|date_format:H:i',
            'jam_selesai'=> 'required|date_format:H:i|after:jam_mulai',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $gurus = Guru::all();

        return view('admin.jadwal.edit', compact('jadwal', 'kelas', 'mapels', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'kelas_id'   => 'required|exists:kelas,id',
            'mapel_id'   => 'required|exists:mapels,id',
            'guru_id'    => 'required|exists:gurus,id',
            'hari'       => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'  => 'required|date_format:H:i',
            'jam_selesai'=> 'required|date_format:H:i|after:jam_mulai',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return back()->with('success', 'Jadwal berhasil dihapus!');
    }
}   