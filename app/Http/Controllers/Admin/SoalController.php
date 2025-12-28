<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Mapel;
use App\Models\PaketSoal;
use App\Models\Kelas;

class SoalController extends Controller
{
    public function index()
    {
        $paketSoal = PaketSoal::with(['mapel', 'kelas', 'soal'])->paginate(10);
        return view('admin.soal.index', compact('paketSoal'));
    }

    public function create()
    {
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        return view('admin.soal.create', compact('mapel', 'kelas'));
    }

    public function show(PaketSoal $soal)
    {
        $soal->load(['mapel', 'kelas', 'soal']);
        return view('admin.soal.show', compact('soal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'durasi' => 'required|integer|min:10',
        ]);

        
        $paket = PaketSoal::create([
            'judul' => $request->judul,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'durasi' => $request->durasi,
            'aktif' => $request->has('aktif'),
        ]);

        
        if ($request->has('soal')) {
            foreach ($request->soal as $s) {
                Soal::create([
                    'paket_soal_id' => $paket->id,
                    'mapel_id' => $request->mapel_id,
                    'pertanyaan' => $s['pertanyaan'],
                    'tipe' => $s['tipe'] ?? 'pg',
                    'pilihan' => isset($s['pilihan']) ? json_encode($s['pilihan']) : null,
                    'jawaban' => $s['jawaban'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.soal.index')->with('success', 'Paket soal berhasil dibuat!');
    }

    public function edit(PaketSoal $soal)
    {
        $mapel = Mapel::all();
        $kelas = Kelas::all();
        $soal->load('soal');

        return view('admin.soal.edit', compact('soal', 'mapel', 'kelas'));
    }

    public function update(Request $request, PaketSoal $soal)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mapel_id' => 'required|exists:mapels,id',
            'kelas_id' => 'required|exists:kelas,id',
            'durasi' => 'required|integer|min:10',
        ]);

    
        $soal->update([
            'judul' => $request->judul,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'durasi' => $request->durasi,
            'aktif' => $request->has('aktif'),
        ]);

        
        $soal->soal()->delete();

        
        if ($request->has('soal')) {
            foreach ($request->soal as $s) {
                Soal::create([
                    'paket_soal_id' => $soal->id,
                    'mapel_id' => $request->mapel_id,
                    'pertanyaan' => $s['pertanyaan'],
                    'tipe' => $s['tipe'] ?? 'pg',
                    'pilihan' => isset($s['pilihan']) ? json_encode($s['pilihan']) : null,
                    'jawaban' => $s['jawaban'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.soal.index')->with('success', 'Paket soal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $paket = PaketSoal::findOrFail($id);

        
        $paket->soal()->delete();
        $paket->delete();

        return redirect()->route('admin.soal.index')->with('success', 'Paket soal berhasil dihapus.');
    }

    public function preview(PaketSoal $paket)
    {
        $paket->load(['mapel', 'kelas', 'soal']);
        return view('admin.soal.preview', compact('paket'));
    }
}
